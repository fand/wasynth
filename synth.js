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
    this.vivid = 0;
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
    this.freq = freq - this.freq_min;
};

ResFilter.prototype.setVivid = function(vivid){
//    this.vivid = vivid;
//    this.lpf.gain.value = this.vivid - 50;
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


    this.initDOM();
}

Synth.prototype.initDOM = function(){
    $("#instruments").append('<div id="synth'+ this.id + '" class="instrument clearfix"> </div>');
    this.root = $("#synth"+this.id);

    var self = this;
    this.root.load("./synth.php?track_id="+this.id, function(){

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
        $("#EG_"+self.id+" > input").bind("change", function(){
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
    });

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
    
