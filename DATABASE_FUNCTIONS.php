<?php

function headerBuild($header, $title)
{
	$output_string = '';
	$output_string = $output_string . 'CREATE TABLE IF NOT EXISTS ' . "'" . $title . "'" . ' (';
	for($i = 0; $i < count($header); $i++)
	{
		$cur_column = $header[$i];
		if($i != (count($header)-1))
		{
			if($i == 0)
			{
				$output_string = $output_string . "'" . $cur_column . "'" . "\t"."TEXT,";
			}
			else
			{
				$output_string = $output_string . "'" . $cur_column . "'" . "\t"."TEXT,";
			}
		}
		else
		{
			$output_string = $output_string . "'" . $cur_column . "'" . "\t"."TEXT)";			
		}
	}

	return $output_string;
}

function groupBuild($title)
{
	$output_string = '';
	$output_string = $output_string . 'CREATE TABLE IF NOT EXISTS ' . "'" . $title . "'" . ' (';
	$output_string = $output_string . "'" . "cell_name" . "'" . "\t"."TEXT,";
	$output_string = $output_string . "'" . "group_num" . "'" . "\t"."TEXT,";
	$output_string = $output_string . "'" . "group_name" . "'" . "\t"."TEXT)";
	return $output_string;
}

function unionBuild($title)
{
	$output_string = '';
	$output_string = $output_string . 'CREATE TABLE IF NOT EXISTS ' . "'" . $title . "'" . ' (';
	$output_string = $output_string . "'" . "uid" . "'" . "\t"."TEXT,";
	$output_string = $output_string . "'" . "cells" . "'" . "\t"."TEXT)";
	return $output_string;
}

function tickUnionBuild($title)
{
	$output_string = '';
	$output_string = $output_string . 'CREATE TABLE IF NOT EXISTS ' . "'" . $title . "'" . ' (';
	$output_string = $output_string . "'" . "GroupName" . "'" . "\t"."TEXT,";
	$output_string = $output_string . "'" . "values" . "'" . "\t"."TEXT)";
	return $output_string;
}


function errorHandler($file_name)
{
	switch ($_FILES[$file_name]['error']) 
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
	
}

function rowIn($table_name, $rows_list)
{
	$sql = 'INSERT INTO ' . "'" . $table_name . "'";

	
	$sql = $sql . ' VALUES('; 
	
	for($i = 0; $i < count($rows_list); $i++)
	{
		if($i != (count($rows_list) - 1))
		{
			$sql = $sql . "?" . ",";	
		}
		else
		{
			$sql = $sql . "?" . ")"; 
		}
	}

	return $sql;

}

function unionIn($table_name)
{
	$sql = 'INSERT INTO ' . "'" . $table_name . "'";
	
	$sql = $sql . ' VALUES('; 
	
	$sql = $sql . "?" . ",";	
	$sql = $sql . "?" . ")"; 

	return $sql;
}

function rowPrepare($expression)
{
	$first_end = strpos($expression, "\n");
	$import = substr($expression, 0, $first_end);
	$out = explode("\t", $import);
	$expression = substr($expression, ($first_end + 1));
	return array($out, $expression);
}

function mac_rowPrepare($expression)
{
	$first_end = strpos($expression, "\r");
	$import = substr($expression, 0, $first_end);
	$out = explode("\t", $import);
	$expression = substr($expression, ($first_end + 1));
	return array($out, $expression);
}


function unionPrepare($expression)
{
	$first_end = strpos($expression, "\n");
	$import = substr($expression, 0, $first_end);
	$out = str_replace("\t","|",$import);
	$expression = substr($expression, ($first_end + 1));
	return array($out, $expression);
}

function roundAndStringify($input_array)
{
	$round_string = "";
	$input_array_length = count($input_array);
	for($i = 0; $i < $input_array_length; $i++)
	{
		$rounded = $input_array[$i];
		$rounded = substr($rounded, 0, 3);
		if($i == 0)
		{
			$round_string = $round_string . $rounded;
		}
		else
		{
			$round_string = $round_string . "|" . $rounded;
		}
	}
	return $round_string;
}



function originalWrite($expression)
{
	$start=time();
	$first_end = strpos($expression, "\n");
	$import = substr($expression, 0, $first_end);
	$splitter = strpos($import, "\t");
	$row_1 = substr($import, 0, ($splitter));
	$row_2 = substr($import, ($splitter+1));
	$end = time() - $start;
	//$start=time();
	//$row_2 = explode("\t", $row_2);
	//$string_out = roundAndStringify($row_2);
	//$out = str_replace("\t","|",$string_out);
	$rye = array($row_1, $row_2);
	//$out = explode("\t", $import);
	$expression = substr($expression, ($first_end + 1));	
	return array($rye, $expression, $end);
}

function macWrite($expression)
{
	$start=time();
	$first_end = strpos($expression, "\r");
	$import = substr($expression, 0, $first_end);
	$splitter = strpos($import, "\t");
	$row_1 = substr($import, 0, ($splitter));
	$row_2 = substr($import, ($splitter+1));
	$end = time() - $start;	
	//$start=time();
	//$row_2 = explode("\t", $row_2);
	//$string_out = roundAndStringify($row_2);
	//$end = time() - $start;
	//$out = str_replace("\t","|",$string_out);
	$rye = array($row_1, $row_2);
	//$out = explode("\t", $import);
	$expression = substr($expression, ($first_end + 1));		
	return array($rye, $expression, $end);
}

function createPHPconstants($db_name, $start_uids, $prefix)
{
	$myfile = fopen(($prefix . "/USER_CONSTANTS.php"), "w") or die("Unable to open file!");
	
	fwrite($myfile, "<?php\n");
	
	$txt =  '"' . $db_name . '"' . ";\n";
	fwrite($myfile, "\$database =");
	fwrite($myfile, $txt);
	
	//if(strlen($sampling) == 0)
	//{
		//$sampling = "0";
	//}
	
	//$txt = "\$sample_size =" . $sampling . ";\n";
	//fwrite($myfile, $txt);
	
	$txt = "\$test_uid1 =" . '"' . $start_uids[0] . '"' . ";\n";
	fwrite($myfile, $txt);
	$txt = "\$test_uid2 =" . '"' . $start_uids[1] . '"' . ";\n";
	fwrite($myfile, $txt);
	$txt = "\$test_uid3 =" . '"' . $start_uids[2] . '"' . ";\n";
	fwrite($myfile, $txt);
	$txt = "\$test_uid4 =" . '"' . $start_uids[3] . '"' . ";\n";
	fwrite($myfile, $txt);
	$txt = "\$test_uid5 =" . '"' . $start_uids[4] . '"' . ";\n";
	fwrite($myfile, $txt);

	$txt = "\$t1_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$t2_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$t3_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$t4_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$t5_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$col_array = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$g_array = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	
	$txt = "\$ch_col_array = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chX_col_array = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chW_g_array = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chX_g_array = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	
	$txt = "\$chWild1_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chWild2_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chWild3_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chWild4_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chWild5_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	
	$txt = "\$chX1_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chX2_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chX3_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chX4_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chX5_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	
	$txt = "\$test_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$ch_test_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	$txt = "\$chX_test_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	
	
	$txt = "\$check_return = json_encode(" . '"' . "0" . '"' . ");\n";
	fwrite($myfile, $txt);
	
	$txt = "\$TICKS_ALL_TABLE_out = json_encode(" . '"' . "abc" . '"' . ");\n";
	fwrite($myfile, $txt);
	
	fwrite($myfile, "?>");
	
	fclose($myfile);	
}

function writeColorFile($prefix)
{
	$myfile = fopen(($prefix . "/Colors.js"), "w") or die("Unable to open file!");
	$txt = "var ColorDict = [];\n";
	fwrite($myfile, $txt);
	
	$cur_color = "Aqua";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "CadetBlue";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DarkCyan";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DarkSlateGray";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Blue";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DarkBlue";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Purple";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DarkViolet";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Violet";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DeepPink";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "FireBrick";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Red";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "OrangeRed";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Orange";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Yellow";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "OliveDrab";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "LimeGreen";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#42f477";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Green";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DarkGreen";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Olive";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DarkGoldenRod";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Sienna";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Brown";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "BurlyWood";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Bisque";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#FFFFE2";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#E3FFFF";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#9DB9B9";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#BA9E9E";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#917691";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#264226";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#422642";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#3A5656";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#8A98A6";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#6ea4db";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#41c1e0";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#101dad";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#985fed";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#a3129c";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#9e8692";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#ff523b";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#d47b06";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#615d41";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#888c5b";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#a2ab43";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#aacc62";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#6ddb1f";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#1d7538";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#40c27f";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#32dbab";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#54ebdc";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#59aebd";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "#284f63";
	$cur_write = "ColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);

	$txt = "var chColorDict = [];\n";
	fwrite($myfile, $txt);

	$cur_color = "Aqua";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Blue";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Purple";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DeepPink";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Red";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Orange";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "OliveDrab";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "LimeGreen";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Green";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "DarkGreen";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	$cur_color = "Bisque";
	$cur_write = "chColorDict.push(" . '"' . $cur_color . '"' . ");\n";
	fwrite($myfile, $cur_write);
	fclose($myfile);
	
}

function copyNeeded()
{
	
}

?>