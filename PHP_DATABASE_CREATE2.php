<?php
require '/var/www/AltAnalyze/ICGS/AssemblyLine/vendor/autoload.php';

require '/var/www/AltAnalyze/ICGS/AssemblyLine/DATABASE_FUNCTIONS.php';

use App\SQLiteConnection as SQLiteConnection;
use App\SQLiteCreateTable as SQLiteCreateTable;
use App\SQLiteInsert as SQLiteInsert;

ini_set("auto_detect_line_endings", true);

$t=time();

$goodtime = 0;

set_time_limit(0);

//Build new viewer!
//START

$db_name = $_POST['user_db_name'];
$prefix_root_string = "../" . $_POST["pubpri_status"] . "/" . $db_name;
$db_name = $db_name . ".db";

mkdir( $prefix_root_string, 0750, true );

$version_file = $prefix_root_string . "/version.txt";
$opened_version_file = fopen($version_file, "w");
$version_posted = $_POST["version"];
fwrite($opened_version_file, $version_posted);
fclose($opened_version_file);

$details_file = $prefix_root_string . "/details.txt";
$opened_details_file = fopen($details_file, "w");
$author_name_posted = $_POST["author_name"];
fwrite($opened_details_file, $author_name_posted);
fwrite($opened_details_file, "\n");

$opt_file = $prefix_root_string . "/opt.js";
$opened_opt_file = fopen($opt_file, "w");


fwrite($opened_opt_file, "var sample_checkbox_set;");
fwrite($opened_opt_file, "\n");

if(isset($_POST["use_sample_check"]))
{
fwrite($opened_opt_file, "sample_checkbox_set = 1;");
fwrite($opened_opt_file, "\n");	
}
else
{
fwrite($opened_opt_file, "sample_checkbox_set = 0;");
fwrite($opened_opt_file, "\n");
}

fwrite($opened_opt_file, "var default_cell_hover_checked;");
fwrite($opened_opt_file, "\n");

if(isset($_POST["use_cell_hover"]))
{
fwrite($opened_opt_file, "default_cell_hover_checked = 1;");
fwrite($opened_opt_file, "\n");
}
else
{
fwrite($opened_opt_file, "default_cell_hover_checked = 0;");
fwrite($opened_opt_file, "\n");
}

fwrite($opened_opt_file, "var default_cell_animate_checked;");
fwrite($opened_opt_file, "\n");

if(isset($_POST["use_cell_animate"]))
{
fwrite($opened_opt_file, "default_cell_animate_checked = 1;");
fwrite($opened_opt_file, "\n");
}
else
{
fwrite($opened_opt_file, "default_cell_animate_checked = 0;");
fwrite($opened_opt_file, "\n");
}

fclose($opened_opt_file);
	
$sample_hardcoded = $prefix_root_string . "/hard_sample.txt";
$opened_sample_hc = fopen($sample_hardcoded, "w");

if(isset($_POST['use_sample_number']))
{
	fwrite($opened_sample_hc, $_POST['use_sample_number']);
	fclose($opened_sample_hc);
}
else
{
	fwrite($opened_sample_hc, "1");
	fclose($opened_sample_hc);
}


//Check if opening UIDs are set, fill them in with defaults if none are provided.
if(isset($_POST['opening_uid1']))
{
	$OUV_1 = $_POST['opening_uid1'];
}
else
{
	$OUV_1 = "Meis1";
}
if(isset($_POST['opening_uid2']))
{
	$OUV_2 = $_POST['opening_uid2'];
}
else
{
	$OUV_2 = "Irf8";
}
if(isset($_POST['opening_uid3']))
{
	$OUV_3 = $_POST['opening_uid3'];
}
else
{
	$OUV_3 = "Mmp9";
}
if(isset($_POST['opening_uid4']))
{
	$OUV_4 = $_POST['opening_uid4'];
}
else
{
	$OUV_4 = "Klf4";
}
if(isset($_POST['opening_uid5']))
{
	$OUV_5 = $_POST['opening_uid5'];
}
else
{
	$OUV_5 = "Itga2b";
}

//Organize opening UIDs into an array.
$OUV_array = [$OUV_1, $OUV_2, $OUV_3, $OUV_4, $OUV_5];

//Copy needed files to the new directory.
copy("PHP_FUNCTIONS.php", ($prefix_root_string . "/PHP_FUNCTIONS.php"));
copy("User.php", ($prefix_root_string . "/User.php"));
copy("spinner-loop.gif", ($prefix_root_string . "/spinner-loop.gif"));

//Write the user's set opening UIDs into the new USER_CONSTANTS.php file in the new directory.
createPHPconstants($db_name, $OUV_array, $prefix_root_string);
writeColorFile($prefix_root_string);
$db_name = $prefix_root_string . "/" . $db_name;
$overwrite_flag = 0;

if(file_exists($db_name))
{
echo "<script type='text/javascript'>alert('File already exists! Please go back and try a different name!');</script>";
$overwrite_flag = "Yeah";
$overwrite_flag = json_encode($overwrite_flag); 
}
else
{
errorHandler('norm_exp');
$norm_exp_file = $_FILES['norm_exp']['tmp_name'];
$sqlite = new SQLiteCreateTable((new SQLiteConnection())->connect($db_name));
$trick_wagon = unionBuild("all_WT");
$sqlite->createTables($trick_wagon);
$call_string = unionIn("all_WT");
$norm_group_columns = array("uid", "cells");
$line_count = 0;
$pdo = (new SQLiteConnection())->connect($db_name);
$sql_insert = new SQLiteInsert($pdo);
$handle = fopen($norm_exp_file, "r");
$sql_insert->begin();
if($handle) 
{
    while (($line = fgets($handle)) !== false) 
	{
        if($line_count == 0)
		{
			$line_count = $line_count + 1;
			$root_col_file = fopen(($prefix_root_string . "/column_root.txt"), "w") or die("Unable to open file!");
			$splitter = strpos($line, "\t");
			$row_bacon = substr($line, ($splitter+1));
			fwrite($root_col_file, $row_bacon);
			fclose($root_col_file);			
		}
		else
		{
			$line_count = $line_count + 1;
			$splitter = strpos($line, "\t");
			$row_1 = substr($line, 0, ($splitter));
			$row_2 = substr($line, ($splitter+1));
			//$row_2 = explode("\t", $row_2);
			//$string_out = roundAndStringify($row_2);
			$rye = array($row_1, $row_2);			
			$sql_insert->insertObj($call_string, $norm_group_columns, $rye);			
		}
    }

    fclose($handle);
} 
else 
{
    echo "Error parsing out the cell names.";
    echo "<br>";
} 
$sql_insert->commit();
$sql_insert->createIndex();

$total_entries = $line_count - 1;
fwrite($opened_details_file, $total_entries);
fwrite($opened_details_file, "\n");

$non_repeating_g_set = array();

try
{
errorHandler('norm_group');
$norm_group_file = $_FILES['norm_group']['tmp_name'];
$e_file = fopen($norm_group_file, "rb") or die("Unable to open file!");
$norm_group = fread($e_file,filesize($norm_group_file));
$newline_type_flag = strpos($norm_group, "\r\n");
if($newline_type_flag == false)
{
	$newline_type_flag = strpos($norm_group, "\n");
	if($newline_type_flag == false)
	{
		$newline_type_flag = "\r";
	}
	else
	{
		$newline_type_flag = "\n";
	}
}
else
{
	$newline_type_flag = "\r\n";
}

$norm_group_out = explode($newline_type_flag, $norm_group);
$norm_group_columns = ["cell_name", "group_num", "group_name"];

fclose($e_file);

//Write NORM GROUP to DB

$NORM_group_table_head = groupBuild("groups_all_WT");
$sqlite->createTables($NORM_group_table_head);
$call_string = rowIn("groups_all_WT", $norm_group_columns);
$sql_insert->begin();
$norm_group_out_length = count($norm_group_out);
for($i = 0; $i < $norm_group_out_length; $i++)
{
	$cur_row = explode("\t", $norm_group_out[$i]);
	$sql_insert->insertObj($call_string, $norm_group_columns, $cur_row);
	try
	{
		array_push($non_repeating_g_set,$cur_row[2]);
	}
	catch (Exception $e)
	{
		echo "Undefined offset for " . str($norm_group_out[$i]);
		echo "<br>";
	}
}

$non_repeating_g_write = "";
$total_cell_number = count($non_repeating_g_set);
$non_repeating_g_set = array_unique($non_repeating_g_set);
$non_repeating_g_size = count($non_repeating_g_set);
$non_repeating_g_keys = array_keys($non_repeating_g_set);
for($i = 0; $i < $non_repeating_g_size; $i++)
{
	if($i == 0)
	{
		$non_repeating_g_write = $non_repeating_g_write . $non_repeating_g_set[$non_repeating_g_keys[$i]];
	}
	else
	{
		$non_repeating_g_write = $non_repeating_g_write . "|" . $non_repeating_g_set[$non_repeating_g_keys[$i]];
	}
}

fwrite($opened_details_file, $non_repeating_g_write);
fwrite($opened_details_file, "\n");
fwrite($opened_details_file, $total_cell_number);

$sql_insert->commit();
	
}
catch (Exception $e)
{
	echo "Read error for the front page group file.";
	echo "<br>";
}

try
{
switch ($_FILES['norm_tick']['error']) 
{
	case UPLOAD_ERR_OK:
		break;
	case UPLOAD_ERR_NO_FILE:
		throw new RuntimeException('No file sent.');
	case UPLOAD_ERR_INI_SIZE:
	case UPLOAD_ERR_FORM_SIZE:
		throw new RuntimeException('Exceeded filesize limit.');
	default:
		throw new RuntimeException('Unknown errors.');
}

$norm_tick_file = $_FILES['norm_tick']['tmp_name'];
echo json_encode($norm_tick_file);
echo "Rogbert";
if($norm_tick_file != null)
{
//Write NORM TICKS to DB

$norm_tick_head = tickUnionBuild("tickTable_all");
$sqlite->createTables($norm_tick_head);
$call_string = rowIn("tickTable_all", ["GroupName", "values"]);

$line_count = 0;
$handle = fopen($norm_tick_file, "r") or die("Unable to open file!");
$sql_insert->begin();
if($handle) 
{
    while (($line = fgets($handle)) !== false) 
	{
        if($line_count == 0)
		{
			$line_count = $line_count + 1;
			$splitter = strpos($line, "\t");
			$row_1 = substr($line, 0, ($splitter));
			$row_2 = substr($line, ($splitter+1));
			$rye = array("cells", $row_2);			
			$sql_insert->insertObj($call_string, ["GroupName", "values"], $rye);
		}
		else
		{
			$splitter = strpos($line, "\t");
			$row_1 = substr($line, 0, ($splitter));
			$row_2 = substr($line, ($splitter+1));
			//$row_2 = explode("\t", $row_2);
			//$string_out = roundAndStringify($row_2);
			$rye = array($row_1, $row_2);			
			$sql_insert->insertObj($call_string, ["GroupName", "values"], $rye);			
		}
    }

    fclose($handle);
} 
else 
{
    echo "Norm tick file cannot be opened.";
    echo "<br>";
} 
$sql_insert->commit();
}
}
catch (Exception $e)
{
	echo "Read error for the front page tick file.";
	echo "<br>";
}
echo "data";
echo "<br>";
$output_take = "Output";
echo json_encode($output_take);
$norm_tick = "";
$norm_tick_out = "";
$norm_tick_columns = "";
$norm_xpr = "";
$norm_xpr_out = "";
$norm_xpr_columns = "";

//Write feedback to doc, and set values if needed
$mut_tick_out = "";
$mut_tick_columns = "";
$mut_xpr_out = "";
$mut_xpr_columns = "";

$db_name = substr($db_name, 0, (strlen($db_name) - 3));
$db_name = json_encode($db_name);

$action_stream = $prefix_root_string . "/User.php";

//$action_stream = json_encode($action_stream);
fclose($opened_details_file);
}

?>