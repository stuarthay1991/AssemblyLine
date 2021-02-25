<?php

include 'USER_CONSTANTS.php';
include 'PHP_FUNCTIONS.php';

$sample_switch = "OFF";

function catch_fatal_error()
{
  // Getting Last Error
  $last_error =  error_get_last();
  
}
register_shutdown_function('catch_fatal_error');

$db = new SQLite3($database);
$db->enableExceptions(true);

//DB access
$uid = $_POST['uid'];
$uid = strtoupper($uid);

//START queries
//all_WT

$t1 = tableCall($db, "all_WT", $uid); 

$col_array = array();
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


$t1_out= aeF($t1, $all_wt_cells);

$ajax_output = array();
$ajax_output["exp"] = $t1_out;
$ajax_output["uid"] = $uid;
$ajax_output["div"] = $_POST['odiv'];

echo json_encode($ajax_output);

?>