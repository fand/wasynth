var SEMITONE = 1.05946309;

var STREAM_LENGTH = 1024;
var SAMPLE_RATE = 44100;


var VCO = function(){
    this.freq_key = 55;
    this.shape = "SINE";
    this.octave = 4;
    this.interval = 0;
    this.fine = 0;
    this.note = 0;
    this.freq = Math.pow(2, this.octave) * this.freq_key;

    // 44100 / freq = 1周期当りのサンプル数
    this.period_sample = SAMPLE_RATE / this.freq;
    this.phase = 0;
    this.d_phase = (2.0 * Math.PI) / this.period_sample;
};

VCO.prototype.setShape = function(shape){
    this.shape = shape;
};

VCO.prototype.setOctave = function(oct){
    this.octave = parseInt(oct);
};

VCO.prototype.setInterval = function(ival){
    this.interval = parseInt(ival);
};

VCO.prototype.setFine = function(fine){
    this.fine = parseInt(fine);
};

VCO.prototype.setNote = function(note){
    this.note = parseInt(note);
};

VCO.prototype.setFreq = function(){
    this.freq =
        Math.pow(2, this.octave)
        * Math.pow(SEMITONE, this.interval+this.note)
        * this.freq_key
        + this.fine;
    this.period_sample = SAMPLE_RATE / this.freq;
    this.d_phase = (2.0 * Math.PI) / this.period_sample;
};

VCO.prototype.setKey = function(k){
    this.freq_key = k;
};

VCO.prototype.sine = function(){
    return Math.sin(this.phase * this.d_phase);
};

VCO.prototype.triangle = function(){
    var saw2 = this.saw() * 2.0;
    if(saw2 < -1.0){
        return saw2 + 2.0;
    }
    if(saw2 < 1.0){
        return -(saw2);
    }
    else{
        return saw2 - 2.0;
    }
};

VCO.prototype.saw = function(){
    var p = this.phase % this.period_sample;
    return 1.99 * (p / this.period_sample) - 1.0;
};

VCO.prototype.rect = function(){
    if(this.sine() > 0){
        return 1.0;
    }
        return -1.0;
};

VCO.prototype.noise = function(){
    return Math.random();
};

VCO.prototype.nextSample = function(){
    this.phase++;
    switch(this.shape){
    case "SINE": return this.sine();
    case "TRIANGLE": return this.triangle();
    case "SAW": return this.saw();
    case "RECT": return this.rect();
    case "NOISE": return this.noise();
    default: return this.sine();
    }
};

VCO.prototype.nextStream = function(){
    var stream = [];
    for(var i=0; i<STREAM_LENGTH; i++){
        stream[i] = this.nextSample();
    }

    return stream;
};


var EG = function(){
    this.time = 0;
    this.on = false;
    this.envelope = 0.0;

    this.attack = 0;
    this.decay = 0;
    this.sustain = 0.0;
    this.release = 0;

    this.setParam();
}

EG.prototype.setParam = function(param, val){
    switch(param){
    case "attack":
        this.attack = val;
        break;
    case "decay":
        this.decay = val;
        break;
    case "sustain":
        this.sustain = val / 100.0;
        break;
    case "release":
        this.release = val;
        break;
    }
}

EG.prototype.getParam = function(){
    return [this.attack, this.decay, this.sustain, this.release];
};

EG.prototype.noteOn = function(){
    this.time = 0;
    this.on = true;
};

EG.prototype.noteOff = function(){
    this.time = 0;
    this.on = false;
    this.envelope_released = this.envelope;
};

EG.prototype.step = function(){
    this.time++;
};

EG.prototype.getEnvelope = function(){
    
    if(this.on){
        if(this.time < this.attack){
            this.envelope = 1.0 * (this.time / this.attack);
        }
        else if(this.time < (this.attack + this.decay)){
            var e = ((this.time - this.attack) / this.decay) * (1.0-this.sustain);
            this.envelope = 1.0 - e;
        }
        else{
            this.envelope = this.sustain;
        }
    }else{
        if(this.time < this.release){
            this.envelope = this.envelope_released * (this.release-this.time) / this.release;
        }
        else{
            this.envelope = 0.0;
        }
    }
    
    return this.envelope;
};

var ResFilter = function(ctx){
    this.lpf = ctx.createBiquadFilter();
    this.lpf.type = 0;    // lowpass 0

    this.freq_min = 80;
    this.freq = 5000;
    this.resonance = 10;
    this.Q = 10;
};

ResFilter.prototype.connect = function(dst){
    this.lpf.connect(dst);
};

ResFilter.prototype.connectFEG = function(g){
    this.feg = g;
};

ResFilter.prototype.getNode = function(){
    return this.lpf;
}

ResFilter.prototype.getResonance = function(){
    return this.Q;
};

ResFilter.prototype.setFreq = function(freq){
    this.freq = Math.pow(freq/1000, 2.0)*25000;
};

ResFilter.prototype.setQ = function(q){
    this.Q = q;
    this.lpf.Q.value = this.Q;
};


ResFilter.prototype.update = function(){
    this.lpf.frequency.value = this.freq * this.feg.getEnvelope() + this.freq_min;
};



var Synth = function(ctx, id){
    this.id = id;

    this.node = ctx.createJavaScriptNode(STREAM_LENGTH, 1,2);
    this.vco = [new VCO(),new VCO(),new VCO()];
    this.gain = [1.0, 1.0, 1.0];
    
    this.eg = new EG();
    this.filter = new ResFilter(ctx);
    this.feg = new EG();
    this.filter.connectFEG(this.feg);

    // resonance用ノイズ生成
    this.vco_res = new VCO();
    this.vco_res.setShape("NOISE");

    this.ratio = 1.0;
    this.freq_key = 0;
    this.is_playing = false;
}

Synth.prototype.initDOM = function(){

    this.root = $("#panel_"+this.id);
    var self = this;
    
    // vco init
    $("#vco0_"+self.id).bind("change", function(){
        self.setVCOParam();
    });    
    $("#vco1_"+self.id).bind("change", function(){
        self.setVCOParam();
    });
    
    // mixer init
    $("#mixer_"+self.id).bind("change", function(){
        self.setGain();
    });
    
    
    // filter init
    $("#filter_"+self.id).bind("change", function(){
        self.setFilterParam();
    });
    
    // EG init
    self.canvasEG = $("#canvasEG_"+self.id).get()[0];
    self.contextEG = self.canvasEG.getContext('2d');
    $("#EG_"+this.id+" > input").bind("change", function(){
        self.eg.setParam($(this).attr("name"), parseInt($(this).val()));
        self.updateCanvas("EG");
    });
    
    // filter EG init
    self.canvasFEG = $("#canvasFEG_"+self.id).get()[0];
    self.contextFEG = self.canvasFEG.getContext('2d');
    $("#FEG_"+self.id+" > input").bind("change", function(){
        self.feg.setParam($(this).attr("name"), parseInt($(this).val()));
        self.updateCanvas("FEG");
    });
    
    self.setParam();
};

Synth.prototype.updateCanvas = function(name){
    var canvas, context, adsr;

    if (name=="EG"){
        canvas = this.canvasEG;
        context = this.contextEG;
        adsr = this.eg.getParam();
    }else{
        canvas = this.canvasFEG;
        context = this.contextFEG;
        adsr = this.feg.getParam();
    }

    var w = canvas.width = 180;
    var h = canvas.height = 50;
    

    context.clearRect(0,0,w,h);

    context.beginPath();
    context.moveTo(w/4*(1.0- adsr[0]/50000.0), h);
    context.lineTo(w/4,0);  // attack
    context.lineTo(w/4 + (w/4)*(adsr[1]/50000.0),h*(1.0-adsr[2]));  // decay
    context.lineTo(w*3/4, h*(1.0-adsr[2]));  // sustain
    context.lineTo(w*3/4 + (w/4)*(adsr[3]/50000.0), h);  // release
    context.strokeStyle = 'rgb(0, 220, 255)';
    context.stroke();
};

Synth.prototype.setParam = function(){
    this.setVCOParam();
    this.setEGParam();
    this.setFEGParam();
    this.setFilterParam();
    this.setGain();
};

Synth.prototype.setVCOParam = function(){
    for(var i=0; i<this.vco.length; i++){
        var s = i+"_"+this.id;
        this.vco[i].setShape($("#shape"+s).val());
        this.vco[i].setOctave($("#octave"+s).val());
        this.vco[i].setInterval($("#interval"+s).val());
        this.vco[i].setFine(parseInt($("#fine"+s).val()));
        this.vco[i].setKey(this.freq_key);
        this.vco[i].setFreq();
    }
};

Synth.prototype.setEGParam = function(){
    var self = this;
    $("#EG_"+this.id+" > input").each(function(){
        self.eg.setParam($(this).attr("name"), parseInt($(this).val()));
    });
    this.updateCanvas("EG");
};


Synth.prototype.setFEGParam = function(){
    var self = this;
    $("#FEG_"+this.id+" > input").each(function(){
        self.feg.setParam($(this).attr("name"), parseInt($(this).val()));
    });
    this.updateCanvas("FEG");
};

Synth.prototype.setFilterParam = function(){
    this.filter.setFreq($("#freq_"+this.id).val());
    this.filter.setQ($("#Q_"+this.id).val());
};

Synth.prototype.setGain = function(){
    for(var i=0; i<this.gain.length; i++){
        this.gain[i] = parseInt($("#vol"+i+"_"+this.id).val()) / 100.0;
    }
};

Synth.prototype.nextStream = function(){
    var stream = [];
    var s_vco = [];
    var res = this.filter.getResonance();
    var s_res = [];

    for(var j=0; j<3; j++){
        s_vco[j] = this.vco[j].nextStream();
    }
    s_res = this.vco_res.nextStream();
    
    for(var i=0; i<STREAM_LENGTH; i++){
        this.eg.step();
        this.feg.step();
        this.filter.update();
        
        var env = this.eg.getEnvelope();
        stream[i] = 0;
        for(var j=0; j<3; j++){
            stream[i] += s_vco[j][i] * this.gain[j] *0.3 * env;
        }

        if(res > 1){
            stream[i] += s_res[i] * 0.1 * (res/1000.0);
        }
    }
    return stream;
};

Synth.prototype.noteOn = function(){
    this.is_playing = true;

    this.eg.noteOn();
    this.feg.noteOn();

    var self = this;
    this.node.onaudioprocess = function(event) {
        var data_L = event.outputBuffer.getChannelData(0);
        var data_R = event.outputBuffer.getChannelData(1);
        var s = self.nextStream();
        var i = data_L.length;
        while (i--){
            data_L[i] = s[i];
            data_R[i] = s[i];
        }
    };
};

Synth.prototype.noteOff = function(){
    this.is_playing = false;
    this.eg.noteOff();
    this.feg.noteOff();
    
    var self = this;
    this.node.onaudioprocess = function(event) {
        var data_L = event.outputBuffer.getChannelData(0);
        var data_R = event.outputBuffer.getChannelData(1);
        var s = self.nextStream();
        var i = data_L.length;
        while (i--){
            data_L[i] = s[i];
            data_R[i] = s[i];
        }
    };
};

Synth.prototype.setKey = function(freq_key){
    this.freq_key = freq_key
    for(var i=0; i<this.vco.length; i++){
        this.vco[i].setKey(freq_key);
    }
};

Synth.prototype.setScale = function(scale){
    this.scale = scale;
};

Synth.prototype.isPlaying = function(){
    return this.is_playing;
};

Synth.prototype.connect = function(dst){
    this.node.connect(this.filter.getNode());
    this.filter.connect(dst);
};

Synth.prototype.setNote = function(note){
    for(var i=0;i<this.vco.length;i++){
        this.vco[i].setNote(note);
        this.vco[i].setFreq();
    }
};

Synth.prototype.reflectParam = function(){


    
};



var Sampler = function(){

};



var Sequencer = function(track, id){
    this.track = track;
    this.id = id;
    this.edit_mode = "pencil";
    this.mouse_note = 0;
    this.mouse_time = 0;
    this.pressed_mouse = false;
    this.pressed_key = false;

    // pattern = [patter_num][time][]
    // [note,duration]で一つのtone
    this.pattern = [[[0,0]]];
    this.pattern_num = 0;


    // 自然数ならnote, 0ならoff, -1ならextend
    this.glue_pattern = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
    this.glue_start = 0;
    this.glue_end = 0;
};

Sequencer.prototype.addNote = function(time, note, duration){
    this.pattern[this.pattern_num][time] = [note, duration];
    this.glue_pattern[time] = note;
    for(var i=1; i<duration; i++){
        this.glue_pattern[time + i] = -1;
    }
};

Sequencer.prototype.removeNote = function(time){
    this.pattern[this.pattern_index][time] = [0, 0];

    if(this.glue_pattern[time] > 0){
        
    }
};

Sequencer.prototype.extendNote = function(time, note, duration){
    this.pattern[this.pattern_index][time][2] = duration;
    
    this.glue_pattern[time] = note;
    for(var i=1; i<duration; i++){
        this.glue_pattern[i] = -1;
    }
};

Sequencer.prototype.getCurrentPattern = function(num){
    return this.pattern[num];
};

Sequencer.prototype.setPatternNumber = function(num){
    this.pattern_num = num;
};

Sequencer.prototype.drawGlue = function(){

    var self = this;
    var offset = $("#editor").offset();

    $("#editor > div.glue_over").remove();

    for(var i=0; i< this.glue_pattern.length; i++){
        if(this.glue_pattern[i] > 0){
            var w = 0;
            while(this.glue_pattern[i+w]<-1){ w++;}
            
            var row = $("tr[note=" + this.glue_pattern[i] + "] > td > div");    
            var x_cell = row.eq(i).offset().left - 2;
            var w_cell = row.eq(i+w).offset().left - x_cell +18;
            var y_cell = row.offset().top - 2;
            var over = $("<div class='glue_over' start='"+
                         self.glue_start + "' end='"+
                         self.glue_end + "'></div>")
                .css({
                    "left": (x_cell - offset.left) + "px",
                    "top": y_cell - offset.top  + "px",
                    "width": w_cell + "px"
                });
            over.mouseup(function(){
                self.pressed_mouse = false;
                self.glue_start = 100;
                self.glue_end = 0;
            });

            $("#editor").append(over);
        }
    }
};

Sequencer.prototype.setEditMode = function(s){
    this.edit_mode = s;
};

Sequencer.prototype.clickCell = function(cell){

    var self = this;
    var time = cell.text();
    
    switch(self.edit_mode){
    case "glue":  // breakは付けない
        self.glue_start = parseInt(time);
        self.glue_end = parseInt(time);
    case "pencil":
        if(cell.hasClass("on")){
            cell.removeClass("on").addClass("off");
            cell.removeNote(time);
        }else{
            // 同じ列でクリックされた以外のセルをonクラスをremove
            $("div.on").filter(function(){
                return ($(this).text() == time);
            }).each(function(){
                $(this).removeClass("on").addClass("off");
            });
            cell.removeClass("off").addClass("on");
            self.addNote(time, self.mouse_note, 1);
        }
        break;
        
    case "erase":
        if(cell.hasClass("on")){
            cell.removeClass("on").addClass("off");
        }
        break;
    }
};

Sequencer.prototype.dragCell = function(cell){

    var self = this;
    var time = cell.text();
    
    switch (self.edit_mode){
    case "pencil":
        // 同じ列でクリックされた以外のセルをonクラスをremove
        $("div.on").filter(function(){
            return ($(this).text() == time);
        }).each(function(){
            $(this).removeClass("on").addClass("off");
            self.removeNote(time);
        });
        cell.removeClass("off").addClass("on");
        self.addNote(time, self.mouse_note, 1);
        break;
        
    case "glue":
        $("#control_"+self.id).text(this.glue_pattern);
        // 同じ列でクリックされた以外のセルをonクラスをremove
        $("div.on").filter(function(){
            return ($(this).text() == time);
        }).each(function(){
            $(this).removeClass("on").addClass("off");
        });
        
        if(time < self.glue_start){
            self.glue_start = parseInt(time);
        }
        if(self.mouse_time > self.glue_end){
            self.glue_end = parseInt(time);
        }

        if(self.glue_pattern[time] > 0 && self.glue_pattern[time+1] == -1 && time > self.glue_start){
            self.glue_pattern[time+1] = self.glue_pattern[time];
            self.glue_pattern[time] = -1;
            self.drawGlue();
        }

        break;
        
    case "erase":
        if(cell.hasClass("on")){
            cell.removeClass("on").addClass("off");
        }
    }
};

Sequencer.prototype.initDOM = function(){

    var self = this;

    // table init
    $("tr").mouseenter(function(event){
        self.mouse_note = $(this).attr("note");
    }).mouseup(function(){
        self.pressed_mouse = false;
        self.glue_start = 100;
        self.glue_end = 0;
    });

    $("div.cell_seq").each(function(){
        $(this).addClass("off");
    });
        
    $("div.cell_seq").mousedown(function(){
        self.pressed_mouse = true;
        self.mouse_time = $(this).text();
        self.clickCell($(this));
    }).mouseenter(function(){
        if(self.pressed_mouse){
            self.mouse_time = $(this).text();
            self.dragCell($(this));
        }
    }).mouseup(function(){
        self.pressed_mouse = false;
        self.glue_start = 100;
        self.glue_end = 0;
    });
    
    $("th").mouseenter(function(){
        var note = $(this).parent().eq(0).attr("note");
        self.synth.setNote(self.track.player.intervalToSemitone(note));
        if(pressed_mouse){
            self.synth.noteOn();
        }
    }).mousedown(function(){
        pressed_mouse = true;
        self.synth.setNote(self.track.player.intervalToSemitone(self.mouse_note));
        self.synth.noteOn();
    }).mouseup(function(){
        self.pressed_mouse = false;
        self.synth.noteOff();
    });

    $("#pencil_"+self.id).click(function(){
        self.setEditMode("pencil");
    });
    $("#glue_"+self.id).click(function(){
        self.setEditMode("glue");
    });
    $("#erase_"+self.id).click(function(){
        self.setEditMode("erase");
    });
};


/////////////////////////////////////////////
// Trackオブジェクト
// synth, sequencer, fxをメンバに持つ
// synthを継承するよりこっちのほうが楽？

var Track = function(player, ctx, id, type){
    this.player = player;
    this.id = id;
    this.synth;
    if(type == "synth"){
        this.synth = new Synth(ctx, id);
    }else if(type == "sampler"){
        this.synth = new Sampler();
    }

    this.fx = [];
    
    this.sequencer = new Sequencer(this, id);
    
    this.initDOM();
};

Track.prototype.initDOM = function(){
    $("#instruments").append('<div id="track_'+ this.id + '" class="track"> </div>');
    this.root = $("#track_"+this.id);

    var self = this;
    this.root.load("./synth.php?track_id="+this.id, function(){

        $("#play_"+self.id).on("mousedown", function(){
            if(self.player.isPlaying()){
                self.player.pause();
                $(this).attr("value", "play");
            }
            else{
                self.player.play();
                $(this).attr("value", "pause");
            }
        });
        
        $("#stop_"+self.id).on("mousedown", function(){
            self.player.stop();
            $("#play").attr("value", "play");
        });
    

        $("#control_"+self.id).on("change", function(){
            self.player.setBPM();
            self.player.setKey();
            self.player.setScale();
        });
        

        self.sequencer.initDOM();
        self.synth.initDOM();
        self.player.init();
    });
};

Track.prototype.setKey = function(freq_key){
    this.synth.setKey(freq_key);
};

Track.prototype.connect = function(dst){
    this.synth.connect(dst);
};

Track.prototype.setNote = function(note){
    this.synth.setNote(note);
};

Track.prototype.noteOn = function(){
    this.synth.noteOn();
};

Track.prototype.noteOff = function(){
    this.synth.noteOff();
};



