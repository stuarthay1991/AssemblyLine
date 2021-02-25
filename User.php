
<html>
<head>
<link rel="stylesheet" href="../../AArnaSC_baseFunc/assets/css/libs/bootstrap.min.css" charset="utf-8">
<link rel="stylesheet" href="../../AArnaSC_baseFunc/assets/css/libs/bootstrap-theme.min.css" charset="utf-8">
<link rel="stylesheet" href="../../AArnaSC_baseFunc/assets/css/mainpage.css" charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="../../AArnaSC_baseFunc/lib/EasyAutocomplete-1.3.5/easy-autocomplete.min.css"> 
<link rel="stylesheet" href="../../AArnaSC_baseFunc/lib/EasyAutocomplete-1.3.5/easy-autocomplete.themes.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js"></script>
<script src="../../AArnaSC_baseFunc/lib/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.min.js"></script>
<script type="text/javascript" src="http://mbostock.github.com/d3/d3.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script src="../../AArnaSC_baseFunc/node_modules/save-svg-as-png/saveSvgAsPng.js"></script>
<script src="http://www.cloudformatter.com/Resources/Pages/CSS2Pdf/Script/xeponline.jqplugin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css">

<script src="../../AArnaSC_baseFunc/lib/FileSaver.js-master/FileSaver.min.js"></script>
<script src="../../AArnaSC_baseFunc/d3write_EXP.js"></script>
<script src="../../AArnaSC_baseFunc/miscFunc_EXP.js"></script>
<script src="../../AArnaSC_baseFunc/svg_to_pdf.js"></script>
<script src="../../AArnaSC_baseFunc/DownloadOptions.js"></script>
<script src="../../AArnaSC_baseFunc/CONSTANTS.js"></script>
<script src="../../AArnaSC_baseFunc/documentFormatter.js"></script>
<script src="../../AssemblyLine/baseJS/Driver.js"></script>
<script src="../../AArnaSC_baseFunc/databaseUpload.js"></script>
<script src="Colors.js"></script>
<script src="opt.js"></script>

<style>
.d3-tip {
  line-height: 1;
  font-weight: bold;
  padding: 12px;
  background: rgba(0, 0, 0, 0.8);
  color: #fff;
  border-radius: 2px;
}

/* Creates a small triangle extender for the tooltip */
.d3-tip:after {
  box-sizing: border-box;
  display: inline;
  font-size: 10px;
  width: 100%;
  line-height: 1;
  color: rgba(0, 0, 0, 0.8);
  content: "\25BC";
  position: absolute;
  text-align: center;
}

/* Style northward tooltips differently */
.d3-tip.n:after {
  margin: -1px 0 0 0;
  top: 100%;
  left: 0;
}

#loading {
    position: absolute; width: 100%; height: 100%; background: url('spinner-loop.gif') no-repeat center center;
}

#view5_loading {
    position: absolute; width: 100%; height: 100%; background: url('spinner-loop.gif') no-repeat center center;	
}

.dataTables_wrapper table tfoot{
    display:none;
}

</style>
</head>

<?php

include 'USER_CONSTANTS.php';
include 'PHP_FUNCTIONS.php';

$sample_switch = "OFF";

$details_handle = fopen("details.txt", "r");
$cell_count = "";
$log_count = 0;
if($details_handle)
{
	while(($line = fgets($details_handle)) !== false)
	{
		if($log_count == 3)
		{
			$cell_count = trim($line);
		}
		$log_count = $log_count + 1;
	}
	fclose($details_handle);
}
else
{
	echo "Error.";
}

$cell_count = intval($cell_count);

$sample_arr = array();
for($i = 0; $i < $cell_count; $i++)
{
	array_push($sample_arr, $i);
}

$opt_handle = fopen("hard_sample.txt", "r");
$opt_sample_input = 1;
if($opt_handle)
{
	while(($line = fgets($opt_handle)) !== false)
	{
		$opt_sample_input = strval($line);
	}
	fclose($opt_handle);
}
else
{
	echo "Error.";
}

$sample_ints = array_rand(array_flip($sample_arr), $opt_sample_input);
$sample_ints = json_encode($sample_ints);


function catch_fatal_error()
{
  // Getting Last Error
  $last_error =  error_get_last();
  
}
register_shutdown_function('catch_fatal_error');

$db_message = json_encode("User");

$db = new SQLite3($database);
$db->enableExceptions(true);

$check_return = json_encode("0");

$alt_view_is_set = json_encode("0");

if(isset($_POST['submit_all_alt']))
{
	$alt_view_is_set = json_encode("1");
}

if(isset($_POST['submit_all']) OR isset($_POST['submit_all_alt']))
{
//DB access
$test_uid1 = $_POST['uid1'];
$test_uid2 = $_POST['uid2'];
$test_uid3 = $_POST['uid3'];
$test_uid4 = $_POST['uid4'];
$test_uid5 = $_POST['uid5'];
}

//START queries
//all_WT

$t1 = tableCall($db, "all_WT", $test_uid1); 
$t2 = tableCall($db, "all_WT", $test_uid2); 
$t3 = tableCall($db, "all_WT", $test_uid3); 
$t4 = tableCall($db, "all_WT", $test_uid4); 
$t5 = tableCall($db, "all_WT", $test_uid5); 

$test = generic_tableCall($db, "all_WT");

$g_array = groupCall($db, "groups_all_WT");

$col_array = array();

if($g_array != "Failed")
{
	$g_array_length = count($g_array);
	for($i = 0; $i < $g_array_length; $i++)
	{
		array_push($col_array, $g_array[$i]['cell_name']);		
	}
	//startJSON("temp_group_file.json");
	//writeTempGroupFile($g_array);
	//endJSON("temp_group_file.json");
}

ini_set("auto_detect_line_endings", true);

$all_wt_cells_file = fopen("column_root.txt", "r");
if($all_wt_cells_file) 
{
    while (($line = fgets($all_wt_cells_file)) !== false) 
	{
        $all_wt_cells = explode("\t", $line);
    }
    fclose($all_wt_cells_file);
} 

normCellAutocomplete($col_array);

startJSON("temp_exp_file.json");
$test_out = finalizeExpressionFormat($test, $all_wt_cells);
$t1_out= finalizeExpressionFormat($t1, $all_wt_cells);
$t2_out = finalizeExpressionFormat($t2, $all_wt_cells);
$t3_out = finalizeExpressionFormat($t3, $all_wt_cells);
$t4_out = finalizeExpressionFormat($t4, $all_wt_cells);
$t5_out = finalizeExpressionFormat($t5, $all_wt_cells, 1);
endJSON("temp_exp_file.json");

//All Version Ticks

$TICKS_ALL_TABLE = tickWrite($db, "tickTable_all", $col_array);
$TICKS_ALL_TABLE_out = json_encode($TICKS_ALL_TABLE);

//This function creates a new JSON object for the autocomplete feature to use. This allows for dynamic reconstruction of the
//autocomplete listings for each new database used; new entry sets are always respective to the currently utilized database.
writeAutocomplete($db, "all_WT");

$col_array = json_encode($col_array);

//Final Output Genes
//Format for recognizing the genes sent via form to the server are re-formatted here to allow for
//easy variable usage in javascript, using the "json_encode" to allow for this.
if(isset($_POST['submit_all']) OR isset($_POST['submit_all_alt']))
{
$test_uid1 = json_encode($_POST['uid1']);
$test_uid2 = json_encode($_POST['uid2']);
$test_uid3 = json_encode($_POST['uid3']);
$test_uid4 = json_encode($_POST['uid4']);
$test_uid5 = json_encode($_POST['uid5']);			
}
else
{
	$test_uid1 = json_encode($test_uid1);
	$test_uid2 = json_encode($test_uid2);
	$test_uid3 = json_encode($test_uid3);
	$test_uid4 = json_encode($test_uid4);
	$test_uid5 = json_encode($test_uid5);
}

$database = json_encode($database);

//exec("node " . "node_test1.js");

?>

<body style="width: 100%;">
<div class="container" id="tabgroup" style="width: 100%;">
    <ul class="nav nav-tabs" role="tablist">
      <li id="header" style="top:10px;">
      		<strong id="nav_header"><font color="green">AltAnalyze ICGS Viewer</font></strong>
      </li>
      <li id="list_norm_view" class="active" style="left:20px;">
          <a href="#view1" role="tab" data-toggle="tab" style="color: green;">
              Expression-View <i class="glyphicon glyphicon-align-justify"></i>
          </a>
      </li>
	  <li id="list_options_view" style="left:20px">
		  <a href="#view_options" role="tab" data-toggle="tab" style="color: green;">
           Options <i class="glyphicon glyphicon-tasks"></i>
          </a>	  	  
	  </li>
      <li style="left:20px;">
		  <a href="#view4" role="tab" data-toggle="tab" style="color: green;">
           Download <i class="glyphicon glyphicon-download-alt"></i>
          </a>	  
      </li>
	  <li id="list_contact_view" style="left:20px;">
		  <a href="#view3" role="tab" data-toggle="tab" style="color: green;">
           Contact <i class="glyphicon glyphicon-earphone"></i>
          </a>	  
	  </li>
	  <li id="db_display_li" style="float: right; right:20px; color: green;">
           <h4 id="db_display_span"></h4>
	  </li>
    </ul>
	<div id="loading"></div>

    <div class="tab-content" style="width: 100%;">
    <div class="tab-pane fade active in" id="view1" style="width: 100%;">
		<div style="position: relative; margin-left: 20px; display: flex;">
		<span style="flex: 1;">
			<form id="Form" action="User.php" method="POST">
			<input id="SERVER_SECRET" type="text" name="server" value = <?php echo $database;?> style="display: none;"/>
			<h4>Enter Genes</h4>
			<div id="Input_Panel" style="position:relative;">
	    		<div id="Input_1" class="output_div" style="display: flex;">
		    		<div id="I_1test_1" style="width: 60px; position: relative;">
		    			<strong style="position: relative; right: 10px; top:3px;">Gene 1:</strong>
		    		</div>
					<div id="I_1test_2" style="flex: 1;">
					<input id="SEARCH_BAR1" type="text" name="uid1" value = <?php echo $test_uid1;?> style="width: 130px; position: relative;"/>
					</div>
				</div>    		
	    		<div id="Input_2" class="output_div" style="display: flex;">
		    		<div id="I_2test_1" style="position: relative; width: 60px;">
		    			<strong style="position: relative; right: 10px; top:3px;">Gene 2:</strong>
		    		</div>
					<div id="I_2test_2" style="flex: 1;">
					<input id="SEARCH_BAR2" type="text" name="uid2" value = <?php echo $test_uid2;?> style="width: 130px; position: relative;"/>
					</div>
				</div>    		
	    		<div id="Input_3" class="output_div" style="display: flex;">
		    		<div id="I_3test_1" style="width: 60px; position: relative;">
		    			<strong style="position: relative; right: 10px; top:3px;">Gene 3:</strong>
		    		</div>
					<div id="I_3test_2" style="flex: 1;">
					<input id="SEARCH_BAR3" type="text" name="uid3" value = <?php echo $test_uid3;?> style="width: 130px; position: relative;"/>
					</div>
				</div>    		
	    		<div id="Input_4" class="output_div" style="display: flex;">
		    		<div id="I_4test_1" style="width: 60px; position: relative;">
		    			<strong style="position: relative; right: 10px; top:3px;">Gene 4:</strong>
		    		</div>
					<div id="I_4test_2" style="flex: 1;">
					<input id="SEARCH_BAR4" type="text" name="uid4" value = <?php echo $test_uid4;?> style="width: 130px; position: relative;"/>
					</div>
				</div>    		
	    		<div id="Input_5" class="output_div" style="display: flex;">
		    		<div id="I_5test_1" style="width: 60px; position: relative;">
		    			<strong style="position: relative; right: 10px; top:3px;">Gene 5:</strong>
		    		</div>
					<div id="I_5test_2" style="flex: 1;">
					<input id="SEARCH_BAR5" type="text" name="uid5" value = <?php echo $test_uid5;?> style="width: 130px; position: relative;"/>
					</div>
				</div>  
				<div>
				<input id="in_button" type="submit" class="btn btn-success" name="submit_all" value="Submit" style="position: relative; left: 7px;"/>
				</div> 		
	    	</div>
			</form>
		</span>
		<span style="margin-left: 50px; position: relative; display: inline-block; width: 300px;">
		<h4 style="text-align: center;">Group Zoom</h4>
		<table id="group_table" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Group</th>
					<th>Number</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Group</th>
					<th>Number</th>
				</tr>
			</tfoot>
			<tbody id="group_table_id">
			</tbody>
		</table>
		<button id="in_button" class="btn btn-success" style="display: inline-block; width:25%;" onclick="inToZoom()">Set</button><button id="in_button" class="btn btn-success" style="display: inline-block; width:25%;" onclick="resetZoom()">Reset</button><button id="in_button" class="btn btn-success" style="display: inline-block; width:28%;" onclick="deselectZoom()">Deselect All</button>
		</span>
		<span style="margin-left: 50px; position: relative; display: inline-block; width: 300px;">
			<h4 style="margin-left: 20px;">Cell Search</h4>
			<span style="margin-left: 20px; display: inline-block; margin-bottom: 30px;"><span></span><input id="old_cell_search_input" type="text"></input><button id="old_cell_search_button" class="btn btn-success" onclick="OldsearchForCell()">Search </button><button id="old_restore_other_button" class="btn btn-success" onclick="OldrestoreAll()">Reset</button></span>
			<h4 style="margin-left: 20px;">Cell Capture</h4>
			<span style="margin-left: 20px; display: inline-block; margin-bottom: 30px;"><span></span><select id="old_capture_combo"></select><button id="old_capture_search_button" class="btn btn-success" onclick="OldcaptureCells()">Set</button><button id="old_restore_button" class="btn btn-success" onclick="OldrestoreAll()">Reset</button></span>
		</span>
		</div>

		<div id="I" style="position: relative; top: 20px;">
		<h5 id="db_title_exp" style="text-align: center;"></h5>
		<div id="ALL_HEAD" style="position: relative;"></div>
		<div id="ALL_HEAD_zoom" style="display: none; position: relative;"></div>
    	<div id="Output_Div_1" style="position: relative;"></div>
    	<div id="Output_Div_1_zoom" style="display: none; position: relative;"></div>
    	<div id="Output_Div_2" style="position: relative;"></div>
    	<div id="Output_Div_2_zoom" style="display: none; position: relative;"></div>
    	<div id="Output_Div_3" style="position: relative;"></div>
    	<div id="Output_Div_3_zoom" style="display: none; position: relative;"></div>
    	<div id="Output_Div_4" style="position: relative;"></div>
    	<div id="Output_Div_4_zoom" style="display: none; position: relative;"></div>
    	<div id="Output_Div_5" style="position: relative;"></div>
    	<div id="Output_Div_5_zoom" style="display: none; position: relative;"></div>
		<div id="All_Ver_Tick" style="position: relative;"></div>
		<div id="All_Ver_Tick_zoom" style="display: none; position: relative;"></div>
		</div>

		<div id="Trans_H" style="display: none; position: relative;"></div>
		<div id="Trans_D1" style="display: none; position: relative;"></div>
		<div id="Trans_D2" style="display: none; position: relative;"></div>
		<div id="Trans_D3" style="display: none; position: relative;"></div>
		<div id="Trans_D4" style="display: none; position: relative;"></div>
		<div id="Trans_D5" style="display: none; position: relative;"></div>
		<div id="Trans_T" style="display: none; position: relative;"></div>

		<div id="d_png" style="display: none;">
		<svg id="d_svg" width="1260" height="800">
		</svg>
		</div>
		
	</div>
    <div class="tab-pane fade" id="view3">
	<h3>Contact Information</h3>
	<br>
	<p>For all questions, problems, and suggestions please contact the current adminstrator of this application <strong>Stuart Hay</strong>.</p>
	<br>
	<p>Email: haysb91@gmail.com</p>
	<br>
	</div>

    <div class="tab-pane fade" id="view4" style="border-color: rgb(76, 201, 76);">
	<h3>Download Options</h3>

	<br>
	
	<h4>PDF of gene expression plots</h4>

	<form>
	  <input type="radio" name="colors" id="norm-view-download-opt" checked>
	  <label for="norm-view-download-opt">Norm-View</label>
	</form>

	<label for="download_format_img_combo">Format:</label>
	<select id="download_format_img_combo">
	<option value="PDF">PDF</option>
	<option value="PNG">PNG (High Resolution)</option>
	</select>

	<br>
	<label for="filename_d">Enter filename:</label>
	<input id="filename_d" type="text"/>
	
	<br>

	<button id="test_PDF" class="btn btn-success" onclick="pdfWrite()">Download<i class="glyphicon glyphicon-arrow-down"></i></button>
	
	<br>
	
	<br>
	
	<div style="display: none;">
	<h4>Table(s) of gene expression</h4>
	
	<input id="check_boxd_t1" type="checkbox" checked/>
	<label for="check_boxd_t1" style="position:relative; bottom:3px">Norm-View Full</label>	

	<br>

	<label for="download_format_table_combo">Format:</label>
	<select id="download_format_table_combo">
	<option value="CSV">CSV</option>
	</select>
	
	<br>

	<label for="filename_t">Enter filename:</label>
	<input id="filename_t" type="text"/>
	

	<br>
	
	<br>
	
	<button id="down_TABLE" class="btn btn-success" style="position: relative; bottom:15px;" onclick="downloadTable()">Download<i class="glyphicon glyphicon-arrow-down"></i></button>
	</div>
	
	</div>

	<div class="tab-pane fade" id="view_options">
	
	<h3>Options</h3>
	
	<div id="cell_hover_options">
	<h5>Cell Hover -<font id="cell_hover_text_1" style="color: red; text-indent: 30px;">OFF</font></h5>
	<input id="cell_hover_toggle" type="checkbox" onclick="toggleHover()"/>
	<label for="cell_hover_toggle" style="position:relative; bottom:3px">Cell Hover</label>	
	</div>
		
	</div>

	
</div>

<div id="save_SVG_stash" style="display: none;">
</div>

<div id="save_SVG_stash2" style="display: none;">
</div>

<form id="svgformdown" method="post" action="../../AssemblyLine/gyr.php" style="display: none;">
      <input type="hidden" id="PAH1Zdata" name="PAH1Zdata" value="">
      <input type="hidden" id="filename_pdf" name="filename_pdf" value="">
</form>


<script>

console.log("screen width", window.innerWidth);

var screen_adj = window.innerWidth / 1280;

var CONSTANTS = new DEFAULTS();

var VARIABLE_PDF_FILE_ID;

var currently_loaded_db = <?php echo $database;?>;
currently_loaded_db = currently_loaded_db.substring(0, (currently_loaded_db.length - 3));
document.getElementById("db_display_span").innerHTML = currently_loaded_db;

document.getElementById("db_title_exp").innerHTML = currently_loaded_db;

$(window).ready(function() {
    $('#loading').hide();
	$('#old_cell_search_div').show();
	$('#old_cell_search_input').show();
});


function buildCaptureUI(tickset1, tickset2, combo_id)
{
	all_ticks = [];
	if(tickset1 != "None")
	{
		for(var i = 0; i < tickset1.length; i++)
		{
			all_ticks.push(tickset1[i]["GroupName"]);
		}
	}
	if(tickset2 != "None")
	{
		for(var i = 0; i < tickset2.length; i++)
		{
			all_ticks.push(tickset2[i]["GroupName"]);
		}
	}
	for(var i = 0; i < all_ticks.length; i++)
	{
		buildAndAddOptions(all_ticks[i], combo_id);
	}
}

function buildAndAddOptions(current_set_name, combo_id)
{
	var new_option = document.createElement("option");
	var new_option_text = document.createTextNode(current_set_name);
	new_option.appendChild(new_option_text);
	document.getElementById(combo_id).appendChild(new_option);
}

var main_search_features = {
    url: "gene_desc.json",

    getValue: "desc",
    list: {
        match: {
            enabled: true
        }
    },

    theme: "plate-dark"
};

var cell_norm_search_features = {
    url: "norm_cell_desc.json",

    getValue: "desc",
    list: {
        match: {
            enabled: true
        }
    },

    theme: "plate-dark"
};

$("#SEARCH_BAR1").easyAutocomplete(main_search_features);
$("#SEARCH_BAR2").easyAutocomplete(main_search_features);
$("#SEARCH_BAR3").easyAutocomplete(main_search_features);
$("#SEARCH_BAR4").easyAutocomplete(main_search_features);
$("#SEARCH_BAR5").easyAutocomplete(main_search_features);

$("#old_cell_search_input").easyAutocomplete(cell_norm_search_features);

/*
document.getElementById("SEARCH_BAR1").nextSibling.style.top = "-12px";
document.getElementById("SEARCH_BAR2").nextSibling.style.top = "-22px";
document.getElementById("SEARCH_BAR3").nextSibling.style.top = "-32px";
document.getElementById("SEARCH_BAR4").nextSibling.style.top = "-42px";
document.getElementById("SEARCH_BAR5").nextSibling.style.top = "-52px";
document.getElementById("SEARCH_BAR1").nextSibling.style.width = "170px";
document.getElementById("SEARCH_BAR2").nextSibling.style.width = "170px";
document.getElementById("SEARCH_BAR3").nextSibling.style.width = "170px";
document.getElementById("SEARCH_BAR4").nextSibling.style.width = "170px";
document.getElementById("SEARCH_BAR5").nextSibling.style.width = "170px";
*/

//TEST CASES
var test_y = <?php echo $test_out;?>;
var js_ticks_all_table = <?php echo $TICKS_ALL_TABLE_out;?>;
var y1 = <?php echo $t1_out;?>;
var y2 = <?php echo $t2_out;?>;
var y3 = <?php echo $t3_out;?>;
var y4 = <?php echo $t4_out;?>;
var y5 = <?php echo $t5_out;?>;
var c = <?php echo $col_array;?>;

var sample_ints = <?php echo $sample_ints;?>;

var title1 = <?php echo $test_uid1;?>;
var title2 = <?php echo $test_uid2;?>;
var title3 = <?php echo $test_uid3;?>;
var title4 = <?php echo $test_uid4;?>;
var title5 = <?php echo $test_uid5;?>;
var group_dict = <?php echo json_encode($g_array);?>;

if(sample_checkbox_set == 1)
{
	var c = resampleGroups(sample_ints, c);
	var group_dict = resampleGroups(sample_ints, group_dict);
}

var norm_view_all_expression = [y1, y2, y3, y4, y5];
//console.log(test_y);
//console.log(y1);
//console.log(y2);
//console.log(y3);
//console.log(y4);
//console.log(y5);

//The driver in this application is not used in the traditional sense; rather, it tries to figure out what types of data 
//the requested database does have and does not have. This is absolutely a necessity to have in order for the application
//to run smoothly, no matter how scarce the resulting dataset is.
var application = new pageDriver(test_y, group_dict, js_ticks_all_table, c);
application.runTests();
application.printTests();
application.buildGroups();
application.checkValues();

let norm_group_consolidated_set = Array.from(application.norm_group_set);

var norm_group_nameToNumberDict = application.norm_group_dict;

//makeZoomCheckboxes(norm_group_consolidated_set);
makeZoomTable(norm_group_consolidated_set);

var groupTableCons = "";
var groupTableCons2 = "";
$(document).ready(function() {
	groupTableCons = $('#group_table').DataTable({
        "scrollY":        "100px",
        "scrollCollapse": true,
        "paging":         false,
		"bFilter": false,
        "order": [[ 1, "asc" ]]		
	});

    $('#group_table_id').on('click', 'tr', function () {
        $(this).toggleClass('selected');
		//var data = tbl.row( this ).data();
        //alert( 'You clicked on '+data[0]+'\'s row' );
    } );
	
} );

let basicOnion = Array.from(application.norm_group_set);

var standard_ratio = 509;

var test_SVG = new buildD3("Output_Div_1", c, y1, CONSTANTS.DEFAULT_SCALE, title1, group_dict, standard_ratio, screen_adj);

var div1_SVG = new buildD3("Output_Div_1", c, y1, CONSTANTS.DEFAULT_SCALE, title1, group_dict, standard_ratio, screen_adj);
var div2_SVG = new buildD3("Output_Div_2", c, y2, CONSTANTS.DEFAULT_SCALE, title2, group_dict, standard_ratio, screen_adj);
var div3_SVG = new buildD3("Output_Div_3", c, y3, CONSTANTS.DEFAULT_SCALE, title3, group_dict, standard_ratio, screen_adj);
var div4_SVG = new buildD3("Output_Div_4", c, y4, CONSTANTS.DEFAULT_SCALE, title4, group_dict, standard_ratio, screen_adj);
var div5_SVG = new buildD3("Output_Div_5", c, y5, CONSTANTS.DEFAULT_SCALE, title5, group_dict, standard_ratio, screen_adj);

test_SVG.logCoordOnly(1, "TEST");
requestAnimationFrame(div1_SVG.write);
requestAnimationFrame(div2_SVG.write);
requestAnimationFrame(div3_SVG.write);
requestAnimationFrame(div4_SVG.write);
requestAnimationFrame(div5_SVG.write);
div1_SVG.write(1, "None");
div2_SVG.write(1, "None");
div3_SVG.write(1, "None");
div4_SVG.write(1, "None");
div5_SVG.write(1, "None");

var KingOnion = new HeaderOnion(test_SVG.logDictXGroups, "ALL_HEAD", screen_adj, basicOnion, "BASIC_COLOR", 0, 0, norm_group_nameToNumberDict);
KingOnion.writeHeadSVG();
KingOnion.writeDescriptSVG();

if(application.flag_n_ticks == "True")
{
var TickSvgObject = new TickTurnip(js_ticks_all_table, c, "All_Ver_Tick", standard_ratio, screen_adj, "no_group");
TickSvgObject.writeHeadSVG();
TickSvgObject.writeTicks();
}

var UNI_SVG_LIST = [div1_SVG, div2_SVG, div3_SVG, div4_SVG, div5_SVG];

var UNI_SVG_HEADER = KingOnion;
var UNI_SVG_TICKS = TickSvgObject;

if(default_cell_hover_checked == 1)
{
	document.getElementById("cell_hover_toggle").click();
}

buildCaptureUI("None", js_ticks_all_table, "old_capture_combo");

norm_view_all_titles = [title1, title2, title3, title4, title5];

var form = document.getElementById('file-form');
var norm_express_fileSelect = document.getElementById("Norm-Express-Input");
var norm_group_fileSelect = document.getElementById("Norm-Group-Input");
var norm_tick_fileSelect = document.getElementById("Norm-Tick-Input");
var uploadButton = document.getElementById("create_database_button");

function turnOnHovers()
{
	document.getElementById("cell_hover_text_1").style.color = "Green";
	document.getElementById("cell_hover_text_1").innerHTML = "ON";
	for(var i = 0; i < UNI_SVG_LIST.length; i++)
	{
		curSVG = UNI_SVG_LIST[i];
		rect_set = curSVG.SVG.selectAll("rect");
        rect_set.each(function(d) {       		
    		if(this.attributes.type.value == "cell")
    		{
				var found_thing = d3.select(this);
				var hig = curSVG.tip;

				found_thing	
					.on("mouseover", function(){				
						d3.select(this).style("fill", "white");
						d3.select(this).style("stroke", "red");
						hig.show(this.attributes);
					})
					.on("mouseout", function(){
						d3.select(this).style("fill", this.attributes.off_color.value);
						d3.select(this).style("stroke", this.attributes.off_color.value);
						hig.hide();
					})				
    		}
		});

	}
}

function turnOffHovers()
{
	document.getElementById("cell_hover_text_1").style.color = "Red";
	document.getElementById("cell_hover_text_1").innerHTML = "OFF";
	for(var i = 0; i < UNI_SVG_LIST.length; i++)
	{
		curSVG = UNI_SVG_LIST[i];
		rect_set = curSVG.SVG.selectAll("rect");
        rect_set.each(function(d) {       		
    		if(this.attributes.type.value == "cell")
    		{
				var found_thing = d3.select(this);
				var hig = curSVG.tip;

				found_thing	
					.on("mouseover", function(){})
					.on("mouseout", function(){})				
    		}
		});

	}
}

function toggleHover()
{
	if(document.getElementById("cell_hover_toggle").checked == true)
	{
		turnOnHovers();
	}
	else
	{
		turnOffHovers();
	}
}

function boogieDown()
{
	if(document.getElementById("Expand_To_Advanced_icon").className == "glyphicon glyphicon-menu-right")
	{
		document.getElementById("Expand_To_Advanced_icon").className = "glyphicon glyphicon-menu-down";
		document.getElementById("Expand_Option").style.display = "block";
	}
	else
	{
		document.getElementById("Expand_To_Advanced_icon").className = "glyphicon glyphicon-menu-right";
		document.getElementById("Expand_Option").style.display = "none";
	}

}

function mapToZoom(g, d)
{
	
	var myNode = document.getElementById("Output_Div_1_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Output_Div_2_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Output_Div_3_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Output_Div_4_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Output_Div_5_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("ALL_HEAD_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("All_Ver_Tick_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}	

	
	var ret_obj = groupSplitSet(c, group_dict, g);
	var new_col = ret_obj[0];
	var new_group = ret_obj[1];

	var t_SVG = new buildD3("Output_Div_1_zoom", new_col, y1, CONSTANTS.DEFAULT_SCALE, title1, new_group, standard_ratio, screen_adj);
	t_SVG.logCoordOnly(1, "TEST");

	var O_zoom = new HeaderOnion(t_SVG.logDictXGroups, "ALL_HEAD_zoom", screen_adj, g, "BASIC_COLOR", 1, d, norm_group_nameToNumberDict);
	O_zoom.writeHeadSVG();
	O_zoom.writeDescriptSVG();
	
	var zoom1_SVG = new buildD3("Output_Div_1_zoom", new_col, y1, CONSTANTS.DEFAULT_SCALE, title1, new_group, standard_ratio, screen_adj);
	zoom1_SVG.write(1, "None", 1);

	var zoom2_SVG = new buildD3("Output_Div_2_zoom", new_col, y2, CONSTANTS.DEFAULT_SCALE, title2, new_group, standard_ratio, screen_adj);
	zoom2_SVG.write(1, "None", 1);

	var zoom3_SVG = new buildD3("Output_Div_3_zoom", new_col, y3, CONSTANTS.DEFAULT_SCALE, title3, new_group, standard_ratio, screen_adj);
	zoom3_SVG.write(1, "None", 1);

	var zoom4_SVG = new buildD3("Output_Div_4_zoom", new_col, y4, CONSTANTS.DEFAULT_SCALE, title4, new_group, standard_ratio, screen_adj);
	zoom4_SVG.write(1, "None", 1);

	var zoom5_SVG = new buildD3("Output_Div_5_zoom", new_col, y5, CONSTANTS.DEFAULT_SCALE, title5, new_group, standard_ratio, screen_adj);
	zoom5_SVG.write(1, "None", 1);
	
	if(application.flag_n_ticks == "True")
	{
	var TSO = new TickTurnip(js_ticks_all_table, new_col, "All_Ver_Tick_zoom", standard_ratio, screen_adj, "no_group");
	TSO.writeHeadSVG();
	TSO.writeTicks();
	}

	document.getElementById("Output_Div_1").style.display = "none";
	document.getElementById("Output_Div_1_zoom").style.display = "block";
	document.getElementById("Output_Div_2").style.display = "none";
	document.getElementById("Output_Div_2_zoom").style.display = "block";
	document.getElementById("Output_Div_3").style.display = "none";
	document.getElementById("Output_Div_3_zoom").style.display = "block";
	document.getElementById("Output_Div_4").style.display = "none";
	document.getElementById("Output_Div_4_zoom").style.display = "block";
	document.getElementById("Output_Div_5").style.display = "none";
	document.getElementById("Output_Div_5_zoom").style.display = "block";
	document.getElementById("ALL_HEAD").style.display = "none";
	document.getElementById("ALL_HEAD_zoom").style.display = "block";
	document.getElementById("All_Ver_Tick").style.display = "none";
	document.getElementById("All_Ver_Tick_zoom").style.display = "block";
	
}

function inToZoom()
{
	groupsters = [];
	g_d = {};
	var L = groupTableCons.rows('.selected').data().length;
	for(var i = 0; i < L; i++)
	{
		groupsters.push(groupTableCons.rows('.selected').data()[i][0]);
		g_d[groupTableCons.rows('.selected').data()[i][0]] = groupTableCons.rows('.selected').data()[i][1];

	}

	mapToZoom(groupsters, g_d);
}

function resetZoom()
{
	var myNode = document.getElementById("Output_Div_1_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Output_Div_2_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Output_Div_3_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Output_Div_4_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Output_Div_5_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("ALL_HEAD_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("All_Ver_Tick_zoom");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	
	document.getElementById("Output_Div_1").style.display = "block";
	document.getElementById("Output_Div_1_zoom").style.display = "none";
	document.getElementById("Output_Div_2").style.display = "block";
	document.getElementById("Output_Div_2_zoom").style.display = "none";
	document.getElementById("Output_Div_3").style.display = "block";
	document.getElementById("Output_Div_3_zoom").style.display = "none";
	document.getElementById("Output_Div_4").style.display = "block";
	document.getElementById("Output_Div_4_zoom").style.display = "none";
	document.getElementById("Output_Div_5").style.display = "block";
	document.getElementById("Output_Div_5_zoom").style.display = "none";
	document.getElementById("ALL_HEAD").style.display = "block";
	document.getElementById("ALL_HEAD_zoom").style.display = "none";
	document.getElementById("All_Ver_Tick").style.display = "block";
	document.getElementById("All_Ver_Tick_zoom").style.display = "none";
	
}

function makeZoomCheckboxes(gs)
{
	var oDiv = document.getElementById("OZ");
	var baseString = "groupZoom";
	for(var i = 0; i < gs.length; i++)
	{
		var iDiv = document.createElement('div');
		var modStr = (i + 1).toString();
		var cur_id_write = baseString.concat(modStr);

		var x = document.createElement("LABEL");
		var t = document.createTextNode(gs[i]);
		x.setAttribute("for", cur_id_write);
		x.appendChild(t);
		iDiv.appendChild(x);
		
		var cboxI = document.createElement("INPUT");
		cboxI.setAttribute("type", "checkbox");
		cboxI.id = cur_id_write;
		cboxI.value = gs[i];
		iDiv.appendChild(cboxI);
		oDiv.appendChild(iDiv);
	}
}

function makeZoomTable(gs)
{
    var table_body = document.getElementById("group_table_id");
    for (var p = 0, len = gs.length; p < len; p++) 
    {
        	var cur_tr = document.createElement("TR");
			cur_tr.id = "d_tr".concat(p.toString());
			cur_tr.className = "table_row";
			var cur_td1 = document.createElement("TD");
			var cur_td2 = document.createElement("TD");
			var createAText1 = document.createTextNode(gs[p]);
			var createAText2 = document.createTextNode((p.toString()));
			cur_td1.appendChild(createAText1);
			cur_td2.appendChild(createAText2);
			cur_tr.appendChild(cur_td1);
			cur_tr.appendChild(cur_td2);
			table_body.appendChild(cur_tr);
    }
	
}

//CH_SET_UP


function deselectZoom()
{
	groupTableCons.rows('.table_row').deselect();	
}


function pdfWrite()
{
	var myNode = document.getElementById("Trans_D1");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Trans_D2");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Trans_D3");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Trans_D4");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Trans_D5");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Trans_H");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	myNode = document.getElementById("Trans_T");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}

	var myNode = document.getElementById("d_svg");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}

	var Ttest_SVG = new buildD3("Trans_D1", c, y1, CONSTANTS.DEFAULT_SCALE, title1, group_dict, standard_ratio, 1);

	var Tdiv1_SVG = new buildD3("Trans_D1", c, y1, CONSTANTS.DEFAULT_SCALE, title1, group_dict, standard_ratio, 1);
	var Tdiv2_SVG = new buildD3("Trans_D2", c, y2, CONSTANTS.DEFAULT_SCALE, title2, group_dict, standard_ratio, 1);
	var Tdiv3_SVG = new buildD3("Trans_D3", c, y3, CONSTANTS.DEFAULT_SCALE, title3, group_dict, standard_ratio, 1);
	var Tdiv4_SVG = new buildD3("Trans_D4", c, y4, CONSTANTS.DEFAULT_SCALE, title4, group_dict, standard_ratio, 1);
	var Tdiv5_SVG = new buildD3("Trans_D5", c, y5, CONSTANTS.DEFAULT_SCALE, title5, group_dict, standard_ratio, 1);

	Ttest_SVG.logCoordOnly(1, "TEST");
	requestAnimationFrame(Tdiv1_SVG.write);
	requestAnimationFrame(Tdiv2_SVG.write);
	requestAnimationFrame(Tdiv3_SVG.write);
	requestAnimationFrame(Tdiv4_SVG.write);
	requestAnimationFrame(Tdiv5_SVG.write);
	Tdiv1_SVG.write(1, "None");
	Tdiv2_SVG.write(1, "None");
	Tdiv3_SVG.write(1, "None");
	Tdiv4_SVG.write(1, "None");
	Tdiv5_SVG.write(1, "None");

	var TKingOnion = new HeaderOnion(Ttest_SVG.logDictXGroups, "Trans_H", 1, basicOnion, "BASIC_COLOR", 0, 0, norm_group_nameToNumberDict);
	TKingOnion.writeHeadSVG();
	TKingOnion.writeDescriptSVG();

	if(application.flag_n_ticks == "True")
	{
	var TTickSvgObject = new TickTurnip(js_ticks_all_table, c, "Trans_T", standard_ratio, 1, "no_group");
	TTickSvgObject.writeHeadSVG();
	TTickSvgObject.writeTicks();
	}

	var itm = document.getElementById("Trans_H_group");
	var cln = itm.cloneNode(true);
	cln.id = "Trans_H_group_new";
	document.getElementById("d_svg").appendChild(cln);

	var itm = document.getElementById("Trans_D1_group");
	var cln = itm.cloneNode(true);
	cln.id = "Trans_D1_group_new";
	document.getElementById("d_svg").appendChild(cln);
	var itm = document.getElementById("Trans_D2_group");
	var cln = itm.cloneNode(true);
	cln.id = "Trans_D2_group_new";
	document.getElementById("d_svg").appendChild(cln);
	var itm = document.getElementById("Trans_D3_group");
	var cln = itm.cloneNode(true);
	cln.id = "Trans_D3_group_new";
	document.getElementById("d_svg").appendChild(cln);
	var itm = document.getElementById("Trans_D4_group");
	var cln = itm.cloneNode(true);
	cln.id = "Trans_D4_group_new";
	document.getElementById("d_svg").appendChild(cln);
	var itm = document.getElementById("Trans_D5_group");
	var cln = itm.cloneNode(true);
	cln.id = "Trans_D5_group_new";
	document.getElementById("d_svg").appendChild(cln);

	var itm = document.getElementById("Trans_T_group");
	var cln = itm.cloneNode(true);
	cln.id = "Trans_T_group_new";
	document.getElementById("d_svg").appendChild(cln);

	d3.select("#Trans_H_group_new").attr("transform", "translate(11, 20)");
	d3.select("#Trans_D1_group_new").attr("transform", "translate(10, 100)");
	d3.select("#Trans_D2_group_new").attr("transform", "translate(10, 200)");
	d3.select("#Trans_D3_group_new").attr("transform", "translate(10, 300)");
	d3.select("#Trans_D4_group_new").attr("transform", "translate(10, 400)");
	d3.select("#Trans_D5_group_new").attr("transform", "translate(10, 500)");
	d3.select("#Trans_T_group_new").attr("transform", "translate(10, 600)");


    var pAH1_Z_Node = (new XMLSerializer).serializeToString(document.getElementById("d_svg"));

    var form = document.getElementById("svgformdown");
    form['PAH1Zdata'].value = pAH1_Z_Node;
    form['filename_pdf'].value = document.getElementById("filename_d").value;
    form.submit();
	/*if(document.getElementById("norm-view-download-opt").checked == true)
	{
		$('#d_png').find('svg').attr('xmlns','http://www.w3.org/2000/svg');
		var d_file_base = document.getElementById("filename_d").value;
		xepOnline.Formatter.Format('d_png',{filename: d_file_base, pageWidth:'18in', pageHeight:'18in',render:'download', srctype:'svg'});
	}*/
}

function downloadPerturb()
{

}


</script>
</body>
</html>