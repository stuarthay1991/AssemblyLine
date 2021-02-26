
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
<script src="miscFunc_DIRECT.js"></script>
<script src="../../AArnaSC_baseFunc/svg_to_pdf.js"></script>
<script src="../../AArnaSC_baseFunc/DownloadOptions.js"></script>
<script src="../../AArnaSC_baseFunc/CONSTANTS.js"></script>
<script src="../../AArnaSC_baseFunc/documentFormatter.js"></script>
<script src="../../AssemblyLine/baseJS/Driver.js"></script>
<script src="../../AArnaSC_baseFunc/databaseUpload.js"></script>
<script src="Colors.js"></script>
<script src="opt.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>

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
	$uids = $_POST['uids'];
}
else
{
	$uids = "Sftpd,Ager,S100a12,Spp1,Klrf1,Irf8,Meis1,Meis2,Meis3,Meis4";
}
$uids = explode(",", $uids);

//START queries
//all_WT

$t1 = tableCall($db, "all_WT", $uids[0]); 
$t2 = tableCall($db, "all_WT", $uids[1]); 
$t3 = tableCall($db, "all_WT", $uids[2]); 
$t4 = tableCall($db, "all_WT", $uids[3]); 
$t5 = tableCall($db, "all_WT", $uids[4]); 
$t6 = tableCall($db, "all_WT", $uids[5]);
$t7 = tableCall($db, "all_WT", $uids[6]);
$t8 = tableCall($db, "all_WT", $uids[7]);
$t9 = tableCall($db, "all_WT", $uids[8]);
$t10 = tableCall($db, "all_WT", $uids[9]);

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
$t5_out = finalizeExpressionFormat($t5, $all_wt_cells);
$t6_out = finalizeExpressionFormat($t6, $all_wt_cells);
$t7_out = finalizeExpressionFormat($t7, $all_wt_cells);
$t8_out = finalizeExpressionFormat($t8, $all_wt_cells);
$t9_out = finalizeExpressionFormat($t9, $all_wt_cells);
$t10_out = finalizeExpressionFormat($t10, $all_wt_cells, 1);
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
			<input id="GENES_SECRET" type="text" name="uids_in" style="display: none;"/>
			<h4>Enter Genes</h4>
			<div id="Input_Panel" style="position:relative;">
	    		<div id="Input_1" class="output_div">
					<div id="I_1test_2">
					<textarea id="SEARCH_BAR1" name="uids" rows="3" style="width: 400px;" value="Sftpd,Ager,S100a12,Spp1,Klrf1,Irf8,Meis1,Meis2,Meis3,Meis4">Sftpd,Ager,S100a12,Spp1,Klrf1,Irf8,Meis1,Meis2,Meis3,Meis4</textarea>
					</div>

				</div>
				<div>
				</div> 		
	    	</div>   	
			</form>
			<button id="in_button" class="btn btn-success" name="submit_all" onclick="functest1()" style="position: relative; left: 7px;">Submit</button>
			<form id="theForm" action="main.php" method="POST" style="display: none;">
				<input type="text" id="ajax_uid" name="uid" style="display: hidden;"/>
				<input type="text" id="outputdivin" name="odiv" style="display: hidden;"/>
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
		<button id="in_button" class="btn btn-success" style="display: inline-block; width:25%;" onclick="inToZoom()">Set</button><button id="resin_button" class="btn btn-success" style="display: inline-block; width:25%;" onclick="resetZoom()">Reset</button><button id="in_button" class="btn btn-success" style="display: inline-block; width:28%;" onclick="deselectZoom()">Deselect All</button>
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

		<div id="ThePope" style="height: 70%; overflow-y: scroll; overflow-x: hidden;">

    	<div id="Output_Div_1" style="position: relative;"></div>
    	<div id="Output_Div_2" style="position: relative;"></div>
    	<div id="Output_Div_3" style="position: relative;"></div>
    	<div id="Output_Div_4" style="position: relative;"></div>
    	<div id="Output_Div_5" style="position: relative;"></div>
    	<div id="Output_Div_6" style="position: relative;"></div>
    	<div id="Output_Div_7" style="position: relative;"></div>
    	<div id="Output_Div_8" style="position: relative;"></div>
    	<div id="Output_Div_9" style="position: relative;"></div>
    	<div id="Output_Div_10" style="position: relative;"></div>

    	</div>

		<div id="All_Ver_Tick" style="position: relative;"></div>
		<div id="funkytest" style="display: none; position: relative;"></div>
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

console.log("uids", document.getElementById("SEARCH_BAR1").innerHTML);

var screen_adj = window.innerWidth / 1280;

var CONSTANTS = new DEFAULTS();

var VARIABLE_PDF_FILE_ID;

var new_col;
var new_group;

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


$("#old_cell_search_input").easyAutocomplete(cell_norm_search_features);

//TEST CASES
var test_y = <?php echo $test_out;?>;
var js_ticks_all_table = <?php echo $TICKS_ALL_TABLE_out;?>;
var c = <?php echo $col_array;?>;
var pile_of_div_ids = ["Output_Div_1","Output_Div_2","Output_Div_3","Output_Div_4","Output_Div_5","Output_Div_6","Output_Div_7","Output_Div_8","Output_Div_9","Output_Div_10"];
var pile_of_uids = ["Sftpd","Ager","S100a12","Spp1","Klrf1","Irf8","Meis1","Meis2","Meis3","Meis4"];

var sample_ints = <?php echo $sample_ints;?>;

var title1 = <?php echo json_encode($uids[0]);?>;
var title2 = <?php echo json_encode($uids[1]);?>;
var title3 = <?php echo json_encode($uids[2]);?>;
var title4 = <?php echo json_encode($uids[3]);?>;
var title5 = <?php echo json_encode($uids[4]);?>;
var title6 = <?php echo json_encode($uids[5]);?>;
var title7 = <?php echo json_encode($uids[6]);?>;
var title8 = <?php echo json_encode($uids[7]);?>;
var title9 = <?php echo json_encode($uids[8]);?>;
var title10 = <?php echo json_encode($uids[9]);?>;
var group_dict = <?php echo json_encode($g_array);?>;

if(sample_checkbox_set == 1)
{
	var c = resampleGroups(sample_ints, c);
	var group_dict = resampleGroups(sample_ints, group_dict);
}

var y1 = <?php echo $t1_out;?>;
var y2 = <?php echo $t2_out;?>;
var y3 = <?php echo $t3_out;?>;
var y4 = <?php echo $t4_out;?>;
var y5 = <?php echo $t5_out;?>;
var y6 = <?php echo $t6_out;?>;
var y7 = <?php echo $t7_out;?>;
var y8 = <?php echo $t8_out;?>;
var y9 = <?php echo $t9_out;?>;
var y10 = <?php echo $t10_out;?>;

console.log("fkubsdik", y8);

var norm_view_all_expression = [y1, y2, y3, y4, y5, y6, y7, y8, y9, y10];

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

var test_SVG = new buildD3("funkytest", c, test_y, CONSTANTS.DEFAULT_SCALE, "test_title", group_dict, standard_ratio, screen_adj);

var div1_SVG = new buildD3("Output_Div_1", c, y1, CONSTANTS.DEFAULT_SCALE, title1, group_dict, standard_ratio, screen_adj);
var div2_SVG = new buildD3("Output_Div_2", c, y2, CONSTANTS.DEFAULT_SCALE, title2, group_dict, standard_ratio, screen_adj);
var div3_SVG = new buildD3("Output_Div_3", c, y3, CONSTANTS.DEFAULT_SCALE, title3, group_dict, standard_ratio, screen_adj);
var div4_SVG = new buildD3("Output_Div_4", c, y4, CONSTANTS.DEFAULT_SCALE, title4, group_dict, standard_ratio, screen_adj);
var div5_SVG = new buildD3("Output_Div_5", c, y5, CONSTANTS.DEFAULT_SCALE, title5, group_dict, standard_ratio, screen_adj);
var div6_SVG = new buildD3("Output_Div_6", c, y6, CONSTANTS.DEFAULT_SCALE, title6, group_dict, standard_ratio, screen_adj);
var div7_SVG = new buildD3("Output_Div_7", c, y7, CONSTANTS.DEFAULT_SCALE, title7, group_dict, standard_ratio, screen_adj);
var div8_SVG = new buildD3("Output_Div_8", c, y8, CONSTANTS.DEFAULT_SCALE, title8, group_dict, standard_ratio, screen_adj);
var div9_SVG = new buildD3("Output_Div_9", c, y9, CONSTANTS.DEFAULT_SCALE, title9, group_dict, standard_ratio, screen_adj);
var div10_SVG = new buildD3("Output_Div_10", c, y10, CONSTANTS.DEFAULT_SCALE, title10, group_dict, standard_ratio, screen_adj);

test_SVG.logCoordOnly(1, "TEST");
requestAnimationFrame(div1_SVG.write);
requestAnimationFrame(div2_SVG.write);
requestAnimationFrame(div3_SVG.write);
requestAnimationFrame(div4_SVG.write);
requestAnimationFrame(div5_SVG.write);
requestAnimationFrame(div6_SVG.write);
requestAnimationFrame(div7_SVG.write);
requestAnimationFrame(div8_SVG.write);
requestAnimationFrame(div9_SVG.write);
requestAnimationFrame(div10_SVG.write);
div1_SVG.write(1, "None");
div2_SVG.write(1, "None");
div3_SVG.write(1, "None");
div4_SVG.write(1, "None");
div5_SVG.write(1, "None");
div6_SVG.write(1, "None");
div7_SVG.write(1, "None");
div8_SVG.write(1, "None");
div9_SVG.write(1, "None");
div10_SVG.write(1, "None");

var KingOnion = new HeaderOnion(test_SVG.logDictXGroups, "ALL_HEAD", screen_adj, basicOnion, "BASIC_COLOR", 0, 0, norm_group_nameToNumberDict);
KingOnion.writeHeadSVG();
KingOnion.writeDescriptSVG();

if(application.flag_n_ticks == "True")
{
var TickSvgObject = new TickTurnip(js_ticks_all_table, c, "All_Ver_Tick", standard_ratio, screen_adj, "no_group");	
TickSvgObject.writeHeadSVG();
TickSvgObject.writeTicks();
}

var UNI_SVG_LIST = [div1_SVG, div2_SVG, div3_SVG, div4_SVG, div5_SVG, div6_SVG, div7_SVG, div8_SVG, div9_SVG, div10_SVG];

var UNI_SVG_HEADER = KingOnion;
var UNI_SVG_TICKS = TickSvgObject;

if(default_cell_hover_checked == 1)
{
	document.getElementById("cell_hover_toggle").click();
}

buildCaptureUI("None", js_ticks_all_table, "old_capture_combo");

norm_view_all_titles = [title1, title2, title3, title4, title5];

function showRequest(formData, jqForm, options) {
    //debugger;
    var queryString = $.param(formData);
    console.log('About to submit: \n' + queryString + '\n');
    return true;
}

function functest1()
{
	var all_uids = document.getElementById("SEARCH_BAR1").value;
	var delimiter = "\n";
	if(all_uids.indexOf("\n") != -1 && all_uids.indexOf(",") == -1)
	{
		delimiter = "\n";
	}
	if(all_uids.indexOf("\n") == -1 && all_uids.indexOf(",") != -1)
	{
		delimiter = ",";
	}
	if(all_uids.indexOf("\n") != -1 && all_uids.indexOf(",") != -1)
	{
		if(all_uids.split(",").length > all_uids.split("\n").length)
		{
			delimiter = ",";
			all_uids = all_uids.replace("\n", "");
		}
		else
		{
			delimiter = "\n";
		}
	}

	all_uids = all_uids.split(delimiter);

	var myNode = document.getElementById("ThePope");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}

	pile_of_div_ids = [];
	pile_of_uids = [];
	UNI_SVG_LIST = [];

	for(var i=0; i<all_uids.length; i++)
	{
		var ref_div = "Output_Div_".concat((i+1).toString());
		//console.log("ref_div", ref_div);
		document.getElementById("outputdivin").value = ref_div;
		document.getElementById("ajax_uid").value = all_uids[i];
		var popediv = document.createElement("DIV");
		popediv.id = ref_div;
		pile_of_div_ids.push(ref_div);
		pile_of_uids.push(all_uids[i]);
		document.getElementById("ThePope").appendChild(popediv);
		functest2();
	}

}

function functest2()
{
    $('#theForm').ajaxSubmit({
        beforeSubmit: showRequest,
        success: functest3
    });
    return false;

}

function functest3(data)
{
	data = JSON.parse(data);
	//console.log("HDNIE", data);
	var div_SVG = new buildD3(data["div"], c, data["exp"], CONSTANTS.DEFAULT_SCALE, data["uid"], group_dict, standard_ratio, screen_adj);
	UNI_SVG_LIST.push(div_SVG);
	requestAnimationFrame(div_SVG.write);
	div_SVG.write(1, "None");
	resetHead();
}

function functest2zoom()
{
    $('#theForm').ajaxSubmit({
        beforeSubmit: showRequest,
        success: functest3zoom
    });
    return false;

}

function functest3zoom(data)
{
	data = JSON.parse(data);
	//console.log("HDNIE", data);
	var div_SVG = new buildD3(data["div"], new_col, data["exp"], CONSTANTS.DEFAULT_SCALE, data["uid"], new_group, standard_ratio, screen_adj);
	UNI_SVG_LIST.push(div_SVG);
	requestAnimationFrame(div_SVG.write);
	div_SVG.write(1, "None");

}


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
	
	//CLEAR DIVS
	UNI_SVG_LIST = [];
	for(var i = 0; i<pile_of_div_ids.length; i++)
	{
		var myNode = document.getElementById(pile_of_div_ids[i]);
		while (myNode.firstChild) {
			myNode.removeChild(myNode.firstChild);
		}
	}

	var otherNode = document.getElementById("ALL_HEAD");
	while (otherNode.firstChild) {
		otherNode.removeChild(otherNode.firstChild);
	}
	otherNode = document.getElementById("All_Ver_Tick");
	while (otherNode.firstChild) {
		otherNode.removeChild(otherNode.firstChild);
	}	

	
	var ret_obj = groupSplitSet(c, group_dict, g);
	new_col = ret_obj[0];
	new_group = ret_obj[1];

	var t_SVG = new buildD3("funkytest", new_col, test_y, CONSTANTS.DEFAULT_SCALE, "test_title", new_group, standard_ratio, screen_adj);
	t_SVG.logCoordOnly(1, "TEST");

	var O_zoom = new HeaderOnion(t_SVG.logDictXGroups, "ALL_HEAD", screen_adj, g, "BASIC_COLOR", 1, d, norm_group_nameToNumberDict);
	O_zoom.writeHeadSVG();
	O_zoom.writeDescriptSVG();

	if(application.flag_n_ticks == "True")
	{
	var TSO = new TickTurnip(js_ticks_all_table, new_col, "All_Ver_Tick", standard_ratio, screen_adj, "no_group");
	TSO.writeHeadSVG();
	TSO.writeTicks();
	}

	for(var i=0; i<pile_of_uids.length; i++)
	{
		document.getElementById("outputdivin").value = pile_of_div_ids[i];
		document.getElementById("ajax_uid").value = pile_of_uids[i];		
		functest2zoom();
	}
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

function resetHead()
{
	var otherNode = document.getElementById("ALL_HEAD");
	while (otherNode.firstChild) {
		otherNode.removeChild(otherNode.firstChild);
	}

	var KingOnion = new HeaderOnion(test_SVG.logDictXGroups, "ALL_HEAD", screen_adj, basicOnion, "BASIC_COLOR", 0, 0, norm_group_nameToNumberDict);
	KingOnion.writeHeadSVG();
	KingOnion.writeDescriptSVG();
}

function resetZoom()
{
	UNI_SVG_LIST = [];
	for(var i = 0; i<pile_of_div_ids.length; i++)
	{
		var myNode = document.getElementById(pile_of_div_ids[i]);
		while (myNode.firstChild) {
			myNode.removeChild(myNode.firstChild);
		}
	}

	var otherNode = document.getElementById("ALL_HEAD");
	while (otherNode.firstChild) {
		otherNode.removeChild(otherNode.firstChild);
	}
	otherNode = document.getElementById("All_Ver_Tick");
	while (otherNode.firstChild) {
		otherNode.removeChild(otherNode.firstChild);
	}

	//var test_SVG = new buildD3("funkytest", c, test_y, CONSTANTS.DEFAULT_SCALE, "test_title", group_dict, standard_ratio, screen_adj);

	var KingOnion = new HeaderOnion(test_SVG.logDictXGroups, "ALL_HEAD", screen_adj, basicOnion, "BASIC_COLOR", 0, 0, norm_group_nameToNumberDict);
	KingOnion.writeHeadSVG();
	KingOnion.writeDescriptSVG();

	if(application.flag_n_ticks == "True")
	{
		var TickSvgObject = new TickTurnip(js_ticks_all_table, c, "All_Ver_Tick", standard_ratio, screen_adj, "no_group");
		TickSvgObject.writeHeadSVG();
		TickSvgObject.writeTicks();
	}

	for(var i=0; i<pile_of_uids.length; i++)
	{
		document.getElementById("outputdivin").value = pile_of_div_ids[i];
		document.getElementById("ajax_uid").value = pile_of_uids[i];		
		functest2();
	}
		
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
	var scale_Y_div = (10.0 / pile_of_div_ids.length);
	var scale_X_div = 1.0 / screen_adj;
	scale_Y_div = scale_Y_div.toString();
	scale_X_div = scale_X_div.toString();

	var myNode = document.getElementById("d_svg");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}

	for(var i = 0; i < pile_of_div_ids.length; i++)
	{
		var grabbed_div = (pile_of_div_ids[i]).concat("_group");
		var itm = document.getElementById(grabbed_div);
		var cln = itm.cloneNode(true);
		cln.id = grabbed_div.concat("_new");
		document.getElementById("d_svg").appendChild(cln);
	}

	var itm = document.getElementById("ALL_HEAD_group");
	var cln = itm.cloneNode(true);
	cln.id = "ALL_HEAD_group_new";
	document.getElementById("d_svg").appendChild(cln);


	var itm = document.getElementById("All_Ver_Tick_group");
	var cln = itm.cloneNode(true);
	cln.id = "All_Ver_Tick_group_new";
	document.getElementById("d_svg").appendChild(cln);

	d3.select("#ALL_HEAD_group_new").attr("transform", "scaleX(".concat(scale_X_div).concat(")"));
	d3.select("#ALL_HEAD_group_new").attr("transform", "translate(11, 20)");	

	for(var i = 0; i < pile_of_div_ids.length; i++)
	{
		var grabbed_div = (pile_of_div_ids[i]).concat("_group_new");
		d3.select(("#".concat(grabbed_div))).attr("transform", "scale(".concat(scale_X_div).concat(", ").concat(scale_Y_div).concat(")"));
		var y_position = 100;
		var y_adj = ((800.0 / pile_of_div_ids.length) * i);
		y_position = (y_position + y_adj).toString();
		d3.select(("#".concat(grabbed_div))).attr("transform", "translate(10, ".concat(y_position).concat(")"));
	}

	d3.select("#All_Ver_Tick_group_new").attr("transform", "scaleX(".concat(scale_X_div).concat(")"));
	d3.select("#All_Ver_Tick_group_new").attr("transform", "translate(10, 950)");
	
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