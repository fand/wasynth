<?php
   $id = $_GET["track_id"];

$html = <<<EOT
<fieldset id="vco0_{$id}" class="RS_module RS_vco0">
  <legend>OSC1</legend>
  WAVE <select class="shape">
    <option>SINE</option>
    <option>TRIANGLE</option>
    <option>SAW</option>
    <option selected="selected">RECT</option>
    <option>NOISE</option>
  </select><br>
  OCT <input id="octave0_{$id}" class="octave" type="number" min="0" max="5" value="1"><br>
  SHIFT <input id="interval0_{$id}" class="interval" type="number" min="-12" max="12" value="0"><br>
  TUNE <input id="fine0_{$id}" class="fine" type="number" min="-50" max="50" value="0"><br>
</fieldset>

<fieldset id="vco1_{$id}" class="RS_module RS_vco1">
  <legend>OSC2</legend>
  WAVE <select id="shape1_{$id}">
    <option>SINE</option>
    <option>TRIANGLE</option>
    <option selected="selected">SAW</option>
    <option>RECT</option>
    <option>NOISE</option>
  </select><br>
  OCT <input id="octave1_{$id}" class="octave" type="number" min="0" max="5" value="1"><br>
  SHIFT <input id="interval1_{$id}" class="interval" type="number" min="-12" max="12" value="7"><br>
  TUNE <input id="fine1_{$id}" class="fine" type="number" min="-50" max="50" value="1"><br>
</fieldset>

<fieldset name="vco2_{$id}" class="RS_module RS_vco2">
  <legend>OSC3</b>
  WAVE <select id="shape2_{$id}">
    <option>SINE</option>
    <option>TRIANGLE</option>
    <option>SAW</option>
    <option>RECT</option>
    <option selected="selected">NOISE</option>
  </select><br>
  OCT <input id="octave2_{$id}" class="octave" min="0" max="5" value="3" type="number"><br>
  SHIFT <input id="interval2_{$id}" class="interval" type="number" min="-12" max="12" value="0"><br>
  TUNE <input id="fine2_{$id}" class="fine" min="-50" max="50" value="0" type="number"><br>
</fieldset>

<fieldset id="mixer_{$id}" class="RS_module RS_mixer">
  <legend>Mixer</legend>
  OSC1 <input id="vol0_{$id}" type="range" min="0" max="99" value="50"><br>
  OSC2 <input id="vol1_{$id}" type="range" min="0" max="99" value="40"><br>
  NOISE <input id="vol2_{$id}" type="range" min="0" max="99" value="1"><br>
</fieldset>

<fieldset id="EG_{$id}" class="RS_module RS_EG">
  <legend>Envelope</legend>
  <canvas id="canvasEG_{$id}"></canvas>
  ATTACK <input name="attack" type="range" min="0" max="50000" value="0"><br>
  DECAY <input name="decay" type="range" min="0" max="50000" value="18000"><br>
  SUSTAIN <input name="sustain" type="range" min="0" max="100" value="40"><br>
  RELEASE <input name="release" type="range" min="0" max="50000" value="10000"><br>
</fieldset>

<fieldset id="filter_{$id}" class="RS_module RS_filter clearfix">
  <legend>Filter</legend>
  <div class="RS_filter_freq">
  FREQ <br><input id="freq_{$id}" class="filter_slider" type="range" min="60" max="20000" value="5000"><br>
  </div>
  <div class="RS_filter_Q">
  REZ <br><input id="Q_{$id}" class="filter_slider" type="range" min="0" max="40" value="6"><br>
  </div>
</fieldset>

<fieldset id="FEG_{$id}" class="RS_module RS_FEG"> 
  <legend>FilterEnvelope</legend>
    <canvas id="canvasFEG_{$id}"></canvas>
  ATTACK <input name="attack" type="range" min="0" max="50000" value="1000"><br>
  DECAY <input name="decay" type="range" min="0" max="50000" value="0"><br>
  SUSTAIN <input name="sustain" type="range" min="0" max="100" value="100"><br>
  RELEASE <input name="release" type="range" min="0" max="50000" value="10000"><br>
</fieldset>
EOT;

echo $html;
