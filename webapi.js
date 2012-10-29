var SEMITONE = 1.05946309;
var KEY_LIST = {
    "A": 55,
    "Bb": 58.27047018976124,
    "B": 61.7354126570155,
    "C": 32.70319566257483,
    "Db": 34.64782887210901,
    "D": 36.70809598967594,
    "Eb": 38.890872965260115,
    "E": 41.20344461410875,
    "F": 43.653528929125486,
    "Gb": 46.2493028389543,
    "G": 48.999429497718666,
    "Ab": 51.91308719749314
};
var SCALE_LIST = {
    "IONIAN": [0,2,4,5,7,9,11,12,14,16],
    "DORIAN": [0,2,3,5,7,9,10,12,14,15],
    "PHRYGIAN": [0,1,3,5,7,8,10,12,13,15],
    "LYDIAN": [0,2,4,6,7,9,11,12,14,16],
    "MIXOLYDIAN": [0,2,4,5,7,9,10,12,14,16],
    "AEOLIAN": [0,2,3,5,7,8,10,12,14,15],
    "LOCRIAN": [0,1,3,5,6,8,10,12,13,15]
};

var STREAM_LENGTH = 1024;
var SAMPLE_RATE = 44100;




var Player = function(){
    this.bpm = 120;
    this.duration = 500; // msec
    this.freq_key = 55;
    this.scale = [];
    this.setBPM();
    this.setScale();
    this.is_playing = false;
    this.position = 0;
    this.current_id = 0;
    this.id_list = [this.current_id];

    this.context = new webkitAudioContext();
    SAMPLE_RATE = this.context.sampleRate;

    this.track = [];
    this.track.push(new Track(this, this.context, this.current_id, "synth"));
    
//    this.volume = this.context.createGainNode();
//    this.volume.gain.value = 1.0;

    for(var i=0; i<this.track.length; i++){
        this.track[i].connect(this.context.destination);
    }
};

Player.prototype.init = function(){
    this.setBPM();
    this.setKey();
    this.setScale();
};

Player.prototype.setBPM = function(){
    this.bpm = $("#bpm_"+this.current_id).val();
    this.duration = 15.0 / this.bpm* 1000; // msec
};

Player.prototype.setKey = function(){
    this.freq_key = KEY_LIST[$("#key_"+this.current_id).val()];
    for(var i=0; i<this.track.length; i++){
        this.track[i].setKey(this.freq_key);
    }
};

Player.prototype.setScale = function(){
    this.scale = SCALE_LIST[$("#mode_"+this.current_id).val()];
};

Player.prototype.addPattern = function(time, note){
    this.pattern[time] = note;
 
};

Player.prototype.removePattern = function(time){
    this.pattern[time] = 0;
};


Player.prototype.isPlaying = function(){
    return this.is_playing;
};

Player.prototype.play = function(pos){
    this.init();
    
    this.is_playing = true;
    if(pos!=undefined){
        this.position = pos;
    }
    var self = this;
    $("#indicator").show();
    setTimeout(function(){self.play_seq();},100);
}

Player.prototype.play_seq = function(){
    if(this.is_playing){
        if(this.position >= this.pattern.length){
            this.position = 0;
        }
        if(this.pattern[this.position] != 0){
            this.noteOn(this.pattern[this.position]);
        }
        var self = this;
        setTimeout(function(){
            self.noteOff();
        }, self.duration-10);
        setTimeout(function(){self.position++;self.play_seq();}, self.duration);
        
        $("#indicator").css("left", (26*this.position + 70)+"px");
    }
};

Player.prototype.stop = function(){
    this.is_playing = false;
    this.position = this.pattern.length;
    $("#indicator").hide().css("left", "-1000px");
};

Player.prototype.pause = function(){
    this.is_playing = false;
};

Player.prototype.noteOn = function(note){
    for(var i=0; i<this.track.length; i++){
        this.track[i].setNote(this.intervalToSemitone(note));
        this.track[i].noteOn();
    }
};

Player.prototype.noteOff = function(){
    for(var i=0; i<this.track.length; i++){
        this.track[i].noteOff();
    }
};

Player.prototype.intervalToSemitone  = function(ival){
    return Math.floor((ival-1)/7) * 12 + this.scale[(ival-1) % 7];
};

Player.prototype.readPattern = function(track_num, pat){
    var limit = Math.min(pat.length, this.track.length);
    
    $(".on").removeClass("on").addClass("off");
    for(var i=0; i<this.track.length; i++){
        if(pat[i][0]!=0){
            $("[note=" + pat[i][0] + "] *").filter(function(){
                return ($(this).text() == i);
            }).removeClass("off").addClass("on");
        }
    }
    for(var i=0; i<track.length; i++){
        this.track[i] = pat[i];
    }
};

Player.prototype.readMML = function(){

};

Player.prototype.addTrack = function(){
    
    this.track.push(new Track);

};

Player.prototype.removeTrack = function(){
    this.current_id++;
};


$(function(){

    $("#cover").delay(2000).fadeOut(1000, function(){$(this).remove();});
    
    // $("#twitter").socialbutton('twitter', {
    //     button: 'horizontal',
    //     text: 'Web Audio API Sequencer http://www.kde.cs.tsukuba.ac.jp/~fand/wasynth/'
    // });
    // $("#hatena").socialbutton('hatena');
    // $("#facebook").socialbutton('facebook_like', {
    //     button: 'button_count'
    // });
    
    var player = new Player();

    var pressed_key = false;
    var pressed_mouse = false;

    player.setBPM();
    player.setKey();
    player.setScale();
    

    $(window).keydown(function(e){
        if(pressed_key==false){
            pressed_key=true;
            
            if(player.isPlaying()){
                player.noteOff();
            }
            
            switch(e.keyCode){
            case 90:
                player.noteOn(1); break;
            case 88:
                player.noteOn(2); break;
            case 67:
                player.noteOn(3); break;
            case 86:
                player.noteOn(4); break;
            case 66:
                player.noteOn(5); break;
            case 78:
                player.noteOn(6); break;
            case 77:
                player.noteOn(7); break;
            case 188: case 65:
                player.noteOn(8); break;
            case 190: case 83:
                player.noteOn(9); break;
            case 191: case 68:
                player.noteOn(10); break;
            case 70:
                player.noteOn(11); break;
            case 71:
                player.noteOn(12); break;
            case 72:
                player.noteOn(13); break;
            case 74: 
                player.noteOn(14); break;
            case 75: case 81:
                player.noteOn(15); break;
            case 76: case 87:
                player.noteOn(16); break;
            case 187: case 69:
                player.noteOn(17); break;
            case 82:
                player.noteOn(18); break;
            case 84:
                player.noteOn(19); break;
            case 89:
                player.noteOn(20); break;
            case 85:
                player.noteOn(21); break;
            case 73: case 49:
                player.noteOn(22); break;
            case 79: case 50:
                player.noteOn(23); break;
            case 80: case 51:
                player.noteOn(24); break;
            case 52:
                player.noteOn(25); break;
            case 53:
                player.noteOn(26); break;
            case 54:
                player.noteOn(27); break;
            case 55:
                player.noteOn(28); break;
            case 56:
                player.noteOn(29); break;
            case 57:
                player.noteOn(30); break;
            case 48:
                player.noteOn(31); break;
            }
        }
    });
    
    $(window).keyup(function(){
        pressed_key = false;
        player.noteOff();
    });
    
    var pat = [[[3,1],
                [3,1],
                [10,1],
                [3,1],
                [10,1],
                [3,1],
                [9,1],
                [3,1],
                [3,1],
                [3,1],
                [10,1],
                [3,1],
                [10,1],
                [3,1],
                [9,1],
                [3,1],
                [1,1],
                [1,1],
                [10,1],
                [1,1],
                [10,1],
                [1,1],
                [9,1],
                [1,1],
                [2,1],
                [2,1],
                [10,1],
                [2,1],
                [10,1],
                [2,1],
                [9,1],
                [2,1]]];
    player.readPattern(pat);
});

