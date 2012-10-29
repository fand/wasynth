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
      <div id="10_0_{$id}" class="cell_seq">0</div>
      <div id="10_1_{$id}" class="cell_seq">1</div>
      <div id="10_2_{$id}" class="cell_seq">2</div>
      <div id="10_3_{$id}" class="cell_seq">3</div>
      <div id="10_4_{$id}" class="cell_seq">4</div>
      <div id="10_5_{$id}" class="cell_seq">5</div>
      <div id="10_6_{$id}" class="cell_seq">6</div>
      <div id="10_7_{$id}" class="cell_seq">7</div>
      <div id="10_8_{$id}" class="cell_seq">8</div>
      <div id="10_9_{$id}" class="cell_seq">9</div>
      <div id="10_10_{$id}" class="cell_seq">10</div>
      <div id="10_11_{$id}" class="cell_seq">11</div>
      <div id="10_12_{$id}" class="cell_seq">12</div>
      <div id="10_13_{$id}" class="cell_seq">13</div>
      <div id="10_14_{$id}" class="cell_seq">14</div>
      <div id="10_15_{$id}" class="cell_seq">15</div>
      <div id="10_16_{$id}" class="cell_seq">16</div>
      <div id="10_17_{$id}" class="cell_seq">17</div>
      <div id="10_18_{$id}" class="cell_seq">18</div>
      <div id="10_19_{$id}" class="cell_seq">19</div>
      <div id="10_20_{$id}" class="cell_seq">20</div>
      <div id="10_21_{$id}" class="cell_seq">21</div>
      <div id="10_22_{$id}" class="cell_seq">22</div>
      <div id="10_23_{$id}" class="cell_seq">23</div>
      <div id="10_24_{$id}" class="cell_seq">24</div>
      <div id="10_25_{$id}" class="cell_seq">25</div>
      <div id="10_26_{$id}" class="cell_seq">26</div>
      <div id="10_27_{$id}" class="cell_seq">27</div>
      <div id="10_28_{$id}" class="cell_seq">28</div>
      <div id="10_29_{$id}" class="cell_seq">29</div>
      <div id="10_30_{$id}" class="cell_seq">30</div>
      <div id="10_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  
  <tr note="9">
    <th>9th</th>
    <td class="clearfix">
      <div id="9_0_{$id}" class="cell_seq">0</div>
      <div id="9_1_{$id}" class="cell_seq">1</div>
      <div id="9_2_{$id}" class="cell_seq">2</div>
      <div id="9_3_{$id}" class="cell_seq">3</div>
      <div id="9_4_{$id}" class="cell_seq">4</div>
      <div id="9_5_{$id}" class="cell_seq">5</div>
      <div id="9_6_{$id}" class="cell_seq">6</div>
      <div id="9_7_{$id}" class="cell_seq">7</div>
      <div id="9_8_{$id}" class="cell_seq">8</div>
      <div id="9_9_{$id}" class="cell_seq">9</div>
      <div id="9_10_{$id}" class="cell_seq">10</div>
      <div id="9_11_{$id}" class="cell_seq">11</div>
      <div id="9_12_{$id}" class="cell_seq">12</div>
      <div id="9_13_{$id}" class="cell_seq">13</div>
      <div id="9_14_{$id}" class="cell_seq">14</div>
      <div id="9_15_{$id}" class="cell_seq">15</div>
      <div id="9_16_{$id}" class="cell_seq">16</div>
      <div id="9_17_{$id}" class="cell_seq">17</div>
      <div id="9_18_{$id}" class="cell_seq">18</div>
      <div id="9_19_{$id}" class="cell_seq">19</div>
      <div id="9_20_{$id}" class="cell_seq">20</div>
      <div id="9_21_{$id}" class="cell_seq">21</div>
      <div id="9_22_{$id}" class="cell_seq">22</div>
      <div id="9_23_{$id}" class="cell_seq">23</div>
      <div id="9_24_{$id}" class="cell_seq">24</div>
      <div id="9_25_{$id}" class="cell_seq">25</div>
      <div id="9_26_{$id}" class="cell_seq">26</div>
      <div id="9_27_{$id}" class="cell_seq">27</div>
      <div id="9_28_{$id}" class="cell_seq">28</div>
      <div id="9_29_{$id}" class="cell_seq">29</div>
      <div id="9_30_{$id}" class="cell_seq">30</div>
      <div id="9_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  
  <tr note="8">
    <th>8va</th>
    <td class="clearfix">
      <div id="8_0_{$id}" class="cell_seq">0</div>
      <div id="8_1_{$id}" class="cell_seq">1</div>
      <div id="8_2_{$id}" class="cell_seq">2</div>
      <div id="8_3_{$id}" class="cell_seq">3</div>
      <div id="8_4_{$id}" class="cell_seq">4</div>
      <div id="8_5_{$id}" class="cell_seq">5</div>
      <div id="8_6_{$id}" class="cell_seq">6</div>
      <div id="8_7_{$id}" class="cell_seq">7</div>
      <div id="8_8_{$id}" class="cell_seq">8</div>
      <div id="8_9_{$id}" class="cell_seq">9</div>
      <div id="8_10_{$id}" class="cell_seq">10</div>
      <div id="8_11_{$id}" class="cell_seq">11</div>
      <div id="8_12_{$id}" class="cell_seq">12</div>
      <div id="8_13_{$id}" class="cell_seq">13</div>
      <div id="8_14_{$id}" class="cell_seq">14</div>
      <div id="8_15_{$id}" class="cell_seq">15</div>
      <div id="8_16_{$id}" class="cell_seq">16</div>
      <div id="8_17_{$id}" class="cell_seq">17</div>
      <div id="8_18_{$id}" class="cell_seq">18</div>
      <div id="8_19_{$id}" class="cell_seq">19</div>
      <div id="8_20_{$id}" class="cell_seq">20</div>
      <div id="8_21_{$id}" class="cell_seq">21</div>
      <div id="8_22_{$id}" class="cell_seq">22</div>
      <div id="8_23_{$id}" class="cell_seq">23</div>
      <div id="8_24_{$id}" class="cell_seq">24</div>
      <div id="8_25_{$id}" class="cell_seq">25</div>
      <div id="8_26_{$id}" class="cell_seq">26</div>
      <div id="8_27_{$id}" class="cell_seq">27</div>
      <div id="8_28_{$id}" class="cell_seq">28</div>
      <div id="8_29_{$id}" class="cell_seq">29</div>
      <div id="8_30_{$id}" class="cell_seq">30</div>
      <div id="8_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  
  <tr note="7">
    <th>7th</th>
    <td class="clearfix">
      <div id="7_0_{$id}" class="cell_seq">0</div>
      <div id="7_1_{$id}" class="cell_seq">1</div>
      <div id="7_2_{$id}" class="cell_seq">2</div>
      <div id="7_3_{$id}" class="cell_seq">3</div>
      <div id="7_4_{$id}" class="cell_seq">4</div>
      <div id="7_5_{$id}" class="cell_seq">5</div>
      <div id="7_6_{$id}" class="cell_seq">6</div>
      <div id="7_7_{$id}" class="cell_seq">7</div>
      <div id="7_8_{$id}" class="cell_seq">8</div>
      <div id="7_9_{$id}" class="cell_seq">9</div>
      <div id="7_10_{$id}" class="cell_seq">10</div>
      <div id="7_11_{$id}" class="cell_seq">11</div>
      <div id="7_12_{$id}" class="cell_seq">12</div>
      <div id="7_13_{$id}" class="cell_seq">13</div>
      <div id="7_14_{$id}" class="cell_seq">14</div>
      <div id="7_15_{$id}" class="cell_seq">15</div>
      <div id="7_16_{$id}" class="cell_seq">16</div>
      <div id="7_17_{$id}" class="cell_seq">17</div>
      <div id="7_18_{$id}" class="cell_seq">18</div>
      <div id="7_19_{$id}" class="cell_seq">19</div>
      <div id="7_20_{$id}" class="cell_seq">20</div>
      <div id="7_21_{$id}" class="cell_seq">21</div>
      <div id="7_22_{$id}" class="cell_seq">22</div>
      <div id="7_23_{$id}" class="cell_seq">23</div>
      <div id="7_24_{$id}" class="cell_seq">24</div>
      <div id="7_25_{$id}" class="cell_seq">25</div>
      <div id="7_26_{$id}" class="cell_seq">26</div>
      <div id="7_27_{$id}" class="cell_seq">27</div>
      <div id="7_28_{$id}" class="cell_seq">28</div>
      <div id="7_29_{$id}" class="cell_seq">29</div>
      <div id="7_30_{$id}" class="cell_seq">30</div>
      <div id="7_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  
  <tr note="6">
    <th>6th</th>
    <td class="clearfix">
      <div id="6_0_{$id}" class="cell_seq">0</div>
      <div id="6_1_{$id}" class="cell_seq">1</div>
      <div id="6_2_{$id}" class="cell_seq">2</div>
      <div id="6_3_{$id}" class="cell_seq">3</div>
      <div id="6_4_{$id}" class="cell_seq">4</div>
      <div id="6_5_{$id}" class="cell_seq">5</div>
      <div id="6_6_{$id}" class="cell_seq">6</div>
      <div id="6_7_{$id}" class="cell_seq">7</div>
      <div id="6_8_{$id}" class="cell_seq">8</div>
      <div id="6_9_{$id}" class="cell_seq">9</div>
      <div id="6_10_{$id}" class="cell_seq">10</div>
      <div id="6_11_{$id}" class="cell_seq">11</div>
      <div id="6_12_{$id}" class="cell_seq">12</div>
      <div id="6_13_{$id}" class="cell_seq">13</div>
      <div id="6_14_{$id}" class="cell_seq">14</div>
      <div id="6_15_{$id}" class="cell_seq">15</div>
      <div id="6_16_{$id}" class="cell_seq">16</div>
      <div id="6_17_{$id}" class="cell_seq">17</div>
      <div id="6_18_{$id}" class="cell_seq">18</div>
      <div id="6_19_{$id}" class="cell_seq">19</div>
      <div id="6_20_{$id}" class="cell_seq">20</div>
      <div id="6_21_{$id}" class="cell_seq">21</div>
      <div id="6_22_{$id}" class="cell_seq">22</div>
      <div id="6_23_{$id}" class="cell_seq">23</div>
      <div id="6_24_{$id}" class="cell_seq">24</div>
      <div id="6_25_{$id}" class="cell_seq">25</div>
      <div id="6_26_{$id}" class="cell_seq">26</div>
      <div id="6_27_{$id}" class="cell_seq">27</div>
      <div id="6_28_{$id}" class="cell_seq">28</div>
      <div id="6_29_{$id}" class="cell_seq">29</div>
      <div id="6_30_{$id}" class="cell_seq">30</div>
      <div id="6_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  
  <tr note="5">
    <th>5th</th>
    <td class="clearfix">
      <div id="5_0_{$id}" class="cell_seq">0</div>
      <div id="5_1_{$id}" class="cell_seq">1</div>
      <div id="5_2_{$id}" class="cell_seq">2</div>
      <div id="5_3_{$id}" class="cell_seq">3</div>
      <div id="5_4_{$id}" class="cell_seq">4</div>
      <div id="5_5_{$id}" class="cell_seq">5</div>
      <div id="5_6_{$id}" class="cell_seq">6</div>
      <div id="5_7_{$id}" class="cell_seq">7</div>
      <div id="5_8_{$id}" class="cell_seq">8</div>
      <div id="5_9_{$id}" class="cell_seq">9</div>
      <div id="5_10_{$id}" class="cell_seq">10</div>
      <div id="5_11_{$id}" class="cell_seq">11</div>
      <div id="5_12_{$id}" class="cell_seq">12</div>
      <div id="5_13_{$id}" class="cell_seq">13</div>
      <div id="5_14_{$id}" class="cell_seq">14</div>
      <div id="5_15_{$id}" class="cell_seq">15</div>
      <div id="5_16_{$id}" class="cell_seq">16</div>
      <div id="5_17_{$id}" class="cell_seq">17</div>
      <div id="5_18_{$id}" class="cell_seq">18</div>
      <div id="5_19_{$id}" class="cell_seq">19</div>
      <div id="5_20_{$id}" class="cell_seq">20</div>
      <div id="5_21_{$id}" class="cell_seq">21</div>
      <div id="5_22_{$id}" class="cell_seq">22</div>
      <div id="5_23_{$id}" class="cell_seq">23</div>
      <div id="5_24_{$id}" class="cell_seq">24</div>
      <div id="5_25_{$id}" class="cell_seq">25</div>
      <div id="5_26_{$id}" class="cell_seq">26</div>
      <div id="5_27_{$id}" class="cell_seq">27</div>
      <div id="5_28_{$id}" class="cell_seq">28</div>
      <div id="5_29_{$id}" class="cell_seq">29</div>
      <div id="5_30_{$id}" class="cell_seq">30</div>
      <div id="5_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  
  <tr note="4">
    <th>4th</th>
    <td class="clearfix">
      <div id="4_0_{$id}" class="cell_seq">0</div>
      <div id="4_1_{$id}" class="cell_seq">1</div>
      <div id="4_2_{$id}" class="cell_seq">2</div>
      <div id="4_3_{$id}" class="cell_seq">3</div>
      <div id="4_4_{$id}" class="cell_seq">4</div>
      <div id="4_5_{$id}" class="cell_seq">5</div>
      <div id="4_6_{$id}" class="cell_seq">6</div>
      <div id="4_7_{$id}" class="cell_seq">7</div>
      <div id="4_8_{$id}" class="cell_seq">8</div>
      <div id="4_9_{$id}" class="cell_seq">9</div>
      <div id="4_10_{$id}" class="cell_seq">10</div>
      <div id="4_11_{$id}" class="cell_seq">11</div>
      <div id="4_12_{$id}" class="cell_seq">12</div>
      <div id="4_13_{$id}" class="cell_seq">13</div>
      <div id="4_14_{$id}" class="cell_seq">14</div>
      <div id="4_15_{$id}" class="cell_seq">15</div>
      <div id="4_16_{$id}" class="cell_seq">16</div>
      <div id="4_17_{$id}" class="cell_seq">17</div>
      <div id="4_18_{$id}" class="cell_seq">18</div>
      <div id="4_19_{$id}" class="cell_seq">19</div>
      <div id="4_20_{$id}" class="cell_seq">20</div>
      <div id="4_21_{$id}" class="cell_seq">21</div>
      <div id="4_22_{$id}" class="cell_seq">22</div>
      <div id="4_23_{$id}" class="cell_seq">23</div>
      <div id="4_24_{$id}" class="cell_seq">24</div>
      <div id="4_25_{$id}" class="cell_seq">25</div>
      <div id="4_26_{$id}" class="cell_seq">26</div>
      <div id="4_27_{$id}" class="cell_seq">27</div>
      <div id="4_28_{$id}" class="cell_seq">28</div>
      <div id="4_29_{$id}" class="cell_seq">29</div>
      <div id="4_30_{$id}" class="cell_seq">30</div>
      <div id="4_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  
  <tr note="3">
    <th>3rd</th>
    <td class="clearfix">
      <div id="3_0_{$id}" class="cell_seq">0</div>
      <div id="3_1_{$id}" class="cell_seq">1</div>
      <div id="3_2_{$id}" class="cell_seq">2</div>
      <div id="3_3_{$id}" class="cell_seq">3</div>
      <div id="3_4_{$id}" class="cell_seq">4</div>
      <div id="3_5_{$id}" class="cell_seq">5</div>
      <div id="3_6_{$id}" class="cell_seq">6</div>
      <div id="3_7_{$id}" class="cell_seq">7</div>
      <div id="3_8_{$id}" class="cell_seq">8</div>
      <div id="3_9_{$id}" class="cell_seq">9</div>
      <div id="3_10_{$id}" class="cell_seq">10</div>
      <div id="3_11_{$id}" class="cell_seq">11</div>
      <div id="3_12_{$id}" class="cell_seq">12</div>
      <div id="3_13_{$id}" class="cell_seq">13</div>
      <div id="3_14_{$id}" class="cell_seq">14</div>
      <div id="3_15_{$id}" class="cell_seq">15</div>
      <div id="3_16_{$id}" class="cell_seq">16</div>
      <div id="3_17_{$id}" class="cell_seq">17</div>
      <div id="3_18_{$id}" class="cell_seq">18</div>
      <div id="3_19_{$id}" class="cell_seq">19</div>
      <div id="3_20_{$id}" class="cell_seq">20</div>
      <div id="3_21_{$id}" class="cell_seq">21</div>
      <div id="3_22_{$id}" class="cell_seq">22</div>
      <div id="3_23_{$id}" class="cell_seq">23</div>
      <div id="3_24_{$id}" class="cell_seq">24</div>
      <div id="3_25_{$id}" class="cell_seq">25</div>
      <div id="3_26_{$id}" class="cell_seq">26</div>
      <div id="3_27_{$id}" class="cell_seq">27</div>
      <div id="3_28_{$id}" class="cell_seq">28</div>
      <div id="3_29_{$id}" class="cell_seq">29</div>
      <div id="3_30_{$id}" class="cell_seq">30</div>
      <div id="3_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  
  <tr note="2">
    <th>2nd</th>
    <td class="clearfix">
      <div id="2_0_{$id}" class="cell_seq">0</div>
      <div id="2_1_{$id}" class="cell_seq">1</div>
      <div id="2_2_{$id}" class="cell_seq">2</div>
      <div id="2_3_{$id}" class="cell_seq">3</div>
      <div id="2_4_{$id}" class="cell_seq">4</div>
      <div id="2_5_{$id}" class="cell_seq">5</div>
      <div id="2_6_{$id}" class="cell_seq">6</div>
      <div id="2_7_{$id}" class="cell_seq">7</div>
      <div id="2_8_{$id}" class="cell_seq">8</div>
      <div id="2_9_{$id}" class="cell_seq">9</div>
      <div id="2_10_{$id}" class="cell_seq">10</div>
      <div id="2_11_{$id}" class="cell_seq">11</div>
      <div id="2_12_{$id}" class="cell_seq">12</div>
      <div id="2_13_{$id}" class="cell_seq">13</div>
      <div id="2_14_{$id}" class="cell_seq">14</div>
      <div id="2_15_{$id}" class="cell_seq">15</div>
      <div id="2_16_{$id}" class="cell_seq">16</div>
      <div id="2_17_{$id}" class="cell_seq">17</div>
      <div id="2_18_{$id}" class="cell_seq">18</div>
      <div id="2_19_{$id}" class="cell_seq">19</div>
      <div id="2_20_{$id}" class="cell_seq">20</div>
      <div id="2_21_{$id}" class="cell_seq">21</div>
      <div id="2_22_{$id}" class="cell_seq">22</div>
      <div id="2_23_{$id}" class="cell_seq">23</div>
      <div id="2_24_{$id}" class="cell_seq">24</div>
      <div id="2_25_{$id}" class="cell_seq">25</div>
      <div id="2_26_{$id}" class="cell_seq">26</div>
      <div id="2_27_{$id}" class="cell_seq">27</div>
      <div id="2_28_{$id}" class="cell_seq">28</div>
      <div id="2_29_{$id}" class="cell_seq">29</div>
      <div id="2_30_{$id}" class="cell_seq">30</div>
      <div id="2_31_{$id}" class="cell_seq">31</div>
    </td>
  </tr>
  <tr note="1">
    <th>1st</th>
    <td class="clearfix">
      <div id="1_0_{$id}" class="cell_seq">0</div>
      <div id="1_1_{$id}" class="cell_seq">1</div>
      <div id="1_2_{$id}" class="cell_seq">2</div>
      <div id="1_3_{$id}" class="cell_seq">3</div>
      <div id="1_4_{$id}" class="cell_seq">4</div>
      <div id="1_5_{$id}" class="cell_seq">5</div>
      <div id="1_6_{$id}" class="cell_seq">6</div>
      <div id="1_7_{$id}" class="cell_seq">7</div>
      <div id="1_8_{$id}" class="cell_seq">8</div>
      <div id="1_9_{$id}" class="cell_seq">9</div>
      <div id="1_10_{$id}" class="cell_seq">10</div>
      <div id="1_11_{$id}" class="cell_seq">11</div>
      <div id="1_12_{$id}" class="cell_seq">12</div>
      <div id="1_13_{$id}" class="cell_seq">13</div>
      <div id="1_14_{$id}" class="cell_seq">14</div>
      <div id="1_15_{$id}" class="cell_seq">15</div>
      <div id="1_16_{$id}" class="cell_seq">16</div>
      <div id="1_17_{$id}" class="cell_seq">17</div>
      <div id="1_18_{$id}" class="cell_seq">18</div>
      <div id="1_19_{$id}" class="cell_seq">19</div>
      <div id="1_20_{$id}" class="cell_seq">20</div>
      <div id="1_21_{$id}" class="cell_seq">21</div>
      <div id="1_22_{$id}" class="cell_seq">22</div>
      <div id="1_23_{$id}" class="cell_seq">23</div>
      <div id="1_24_{$id}" class="cell_seq">24</div>
      <div id="1_25_{$id}" class="cell_seq">25</div>
      <div id="1_26_{$id}" class="cell_seq">26</div>
      <div id="1_27_{$id}" class="cell_seq">27</div>
      <div id="1_28_{$id}" class="cell_seq">28</div>
      <div id="1_29_{$id}" class="cell_seq">29</div>
      <div id="1_30_{$id}" class="cell_seq">30</div>
      <div id="1_31_{$id}" class="cell_seq">31</div>
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
