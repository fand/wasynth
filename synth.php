<?php
   $id = $_GET["track_id"];

if(!is_numeric($id)){
  $id = 0;
}
   
$html = <<<EOT

<form name="control" id="control_{$id}" class="module RS_control">
  key: <select id="key_{$id}">
    <option>A</option>
    <option>D</option>
    <option>G</option>
    <option>C</option>
    <option>F</option>
    <option>Bb</option>
    <option>Eb</option>
    <option>Ab</option>
    <option>Db</option>
    <option>Gb</option>
    <option>B</option>
    <option>E</option>
  </select>
  mode: <select id="mode_{$id}">
    <option>IONIAN</option>
    <option>DORIAN</option>
    <option>PHRYGIAN</option>
    <option>LYDIAN</option>
    <option>MIXOLYDIAN</option>
    <option>AEOLIAN</option>
    <option>LOCRIAN</option>
  </select>
  BPM: <input id="bpm_{$id}" min="60" max="240" value="70" type="number">
  <input type="button" id="play_{$id}" value="play" style="width:80px;"/>
  <input type="button" id="stop_{$id}" value="stop" />

  <input type="button" id="pencil_{$id}" value="+" />
  <input type="button" id="glue_{$id}" value="*" />
  <input type="button" id="erase_{$id}" value="-" />       
</form>

<div id="indicator"></div>
<table id="editor">
  <tr note="10">
    <th>10th</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>
  </tr>
  <tr note="9">
    <th>9th</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>
  </tr>
  <tr note="8">
    <th>8va</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>
  </tr>
  <tr note="7">
    <th>7th</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>
  </tr>
  <tr note="6">
    <th>6th</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>
  </tr>
  <tr note="5">
    <th>5th</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>
  </tr>
  <tr note="4">
    <th>4th</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>

  </tr>
  <tr note="3">
    <th>3rd</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>

  </tr>
  <tr note="2">
    <th>2nd</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>
  </tr>
  <tr note="1">
    <th>1st</th>
    <td class="clearfix">
      <div class="cell_seq">0</div>
      <div class="cell_seq">1</div>
      <div class="cell_seq">2</div>
      <div class="cell_seq">3</div>
      <div class="cell_seq">4</div>
      <div class="cell_seq">5</div>
      <div class="cell_seq">6</div>
      <div class="cell_seq">7</div>
      <div class="cell_seq">8</div>
      <div class="cell_seq">9</div>
      <div class="cell_seq">10</div>
      <div class="cell_seq">11</div>
      <div class="cell_seq">12</div>
      <div class="cell_seq">13</div>
      <div class="cell_seq">14</div>
      <div class="cell_seq">15</div>
      <div class="cell_seq">16</div>
      <div class="cell_seq">17</div>
      <div class="cell_seq">18</div>
      <div class="cell_seq">19</div>
      <div class="cell_seq">20</div>
      <div class="cell_seq">21</div>
      <div class="cell_seq">22</div>
      <div class="cell_seq">23</div>
      <div class="cell_seq">24</div>
      <div class="cell_seq">25</div>
      <div class="cell_seq">26</div>
      <div class="cell_seq">27</div>
      <div class="cell_seq">28</div>
      <div class="cell_seq">29</div>
      <div class="cell_seq">30</div>
      <div class="cell_seq">31</div>
    </td>
  </tr>
</table>

<div id="panel_{$id}" class="RS_panel">
<fieldset id="vco0_{$id}" class="RS_module RS_vco0">
  <legend>OSC1</legend>
  WAVE <select id="shape0_{$id}">
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
  FREQ <br><input id="freq_{$id}" class="filter_slider" type="range" min="10" max="1000" value="400"><br>
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
</div>
EOT;

echo $html;
