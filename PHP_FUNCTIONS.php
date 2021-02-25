<?php

function normCellAutocomplete($columns)
{
	try 
	{
				
		$cell_autocomplete_file = fopen("norm_cell_desc.json", "w") or die("Unable to open file!");
		
		fwrite($cell_autocomplete_file, "[\n");
		
		for($i = 0; $i < count($columns); $i++)
		{			
			fwrite($cell_autocomplete_file, "\t{\n");
			$write_string = "\t\t";
			$write_string = $write_string . '"desc": "' . $columns[$i] . '"';			
			fwrite($cell_autocomplete_file, $write_string);
			fwrite($cell_autocomplete_file, "\n");
			if($i != (count($columns) - 1))
			{
				fwrite($cell_autocomplete_file, "\t},\n");
			}
			else
			{
				fwrite($cell_autocomplete_file, "\t}\n");				
			}
		}

		fwrite($cell_autocomplete_file, "]");
		fclose($cell_autocomplete_file);
		

	} catch (Exception $e) 
	{
		return "Failed";
	}
	
}

function chCellAutocomplete($WILDcolumns, $MUTcolumns)
{
	try 
	{
		$cell_autocomplete_file = fopen("ch_cell_desc.json", "w") or die("Unable to open file!");
		
		fwrite($cell_autocomplete_file, "[\n");
		for($i = 0; $i < count($WILDcolumns); $i++)
		{			
			fwrite($cell_autocomplete_file, "\t{\n");
			$write_string = "\t\t";
			$write_string = $write_string . '"desc": "' . $WILDcolumns[$i] . '"';			
			fwrite($cell_autocomplete_file, $write_string);
			fwrite($cell_autocomplete_file, "\n");
			fwrite($cell_autocomplete_file, "\t},\n");		
		}

		for($i = 0; $i < count($MUTcolumns); $i++)
		{
			fwrite($cell_autocomplete_file, "\t{\n");
			$write_string = "\t\t";
			$write_string = $write_string . '"desc": "' . $MUTcolumns[$i] . '"';			
			fwrite($cell_autocomplete_file, $write_string);
			fwrite($cell_autocomplete_file, "\n");
			if($i != (count($MUTcolumns) - 1))
			{
				fwrite($cell_autocomplete_file, "\t},\n");
			}
			else
			{
				fwrite($cell_autocomplete_file, "\t}\n");				
			}			
		}
		fwrite($cell_autocomplete_file, "]");

	} catch (Exception $e) 
	{
		return "Failed";
	}
	
}

//Deprecated in the newest version since 02/19/2018
function columnConsolidatation($result)
{
	try 
	{
		$col_array = [];

		$cols = $result->numColumns();

		while ($row = $result->fetchArray()) 
		{ 
			for ($i = 1; $i < $cols; $i++) 
				{ 
					array_push($col_array, $result->columnName($i));
				} 
		} 
		
		return $col_array;
	} catch (Exception $e)
	{
		return "Failed";
	}
	
}

function columnFindAndMake()
{
	
}

function createColumnKeys($in_array, $columns, $write)
{
	//print_r($columns);
	$max_of_expression = 0;
	for($i = 0; $i < count($in_array); $i++)
	{
		try
		{
			$write[$columns[$i]] = $in_array[$i];
			if(((float)$in_array[$i]) > $max_of_expression)
			{
				$max_of_expression = $in_array[$i];
			}
		}
		catch(Exception $e)
		{
			continue;
		}
	}
	
	$write["MAX_VALUE"] = $max_of_expression;
	//print_r($out_array);
	
	return $write;
}

function finalizeExpressionFormat($result_object, $columns, $flag=0)
{
	if($result_object != "Failed")
	{
		$out_temp_array = array();
		$temp_array = $result_object->fetchArray(SQLITE3_ASSOC);
		$out_temp_array['uid'] = $temp_array['uid'];
		$cell_column_split = explode("\t", $temp_array['cells']);
		//print_r($cell_column_split);
		$final = createColumnKeys($cell_column_split, $columns, $out_temp_array);
		//print_r($final);
		//writeTempExpFile($final, $flag);
		return json_encode($final);
		//return json_encode($result_object->fetchArray(SQLITE3_ASSOC));
	}
	else
	{
		return json_encode("Failed");
	}
}

function finalizeTickFormat($result_object)
{
	if($result_object != "Failed")
	{
		return json_encode($result_object);
	}
	else
	{
		return json_encode("Failed");
	}	
}

function generic_tableCall($database_name, $table_name) 
{
	try
	{
		$result = $database_name->query("SELECT * FROM " . $table_name . " ORDER BY ROWID ASC LIMIT 1");
		return $result;
	} 
	catch (Exception $e)
	{
		return "Failed";
	}

}

function groupCall($database, $table_name)
{
	try 
	{
		$g = $database->query("SELECT * FROM " . $table_name ."");
		$g_array = array();
		$i = 0;

		while($res = $g->fetchArray(SQLITE3_ASSOC))
				{ 
					 if(!isset($res['cell_name'])) continue; 

					  $g_array[$i]['cell_name'] = $res['cell_name']; 
					  $g_array[$i]['group_num'] = $res['group_num']; 
					  $g_array[$i]['group_name'] = $res['group_name']; 
					  $i++; 
				} 
		
		return $g_array;
	} catch (Exception $e) 
	{
		return "Failed";
	}
	
}

function tableCall($database_name, $table_name, $gene_name) 
{
	try
	{
	$result = $database_name->query("SELECT * FROM " . $table_name . " WHERE (uid='" . $gene_name . "')");
	return $result;
	} catch (Exception $e)
	{
		return "Failed";
	}
	
}

function tickWrite($database_name, $table_name, $columns)
{
	try 
	{
		$result = $database_name->query("SELECT * FROM " . $table_name . " ");
		$tick_out = array();
		$i = 0;
		$clean_columns = array();
		while($res = $result->fetchArray(SQLITE3_ASSOC))
			{ 
				$out_temp_array = array();
				if($res["GroupName"] == "cells")
				{
					$clean_columns = explode("\t", $res["values"]);
					continue;
				}
				$out_temp_array["GroupName"] = $res["GroupName"];
				$in_array = explode("\t", $res["values"]);
				$out_temp_array = createColumnKeys($in_array, $clean_columns, $out_temp_array);
				$tick_out[$i] = $out_temp_array;				
				$i++; 
			} 
		
		return $tick_out;

	} catch (Exception $e) 
	{
		return "Failed";
	}

}


function writeAutocomplete($database_name, $table_name)
{
	try 
	{
		$result = $database_name->query("SELECT uid FROM " . $table_name . " ");
		$autocomplete_data = array();
		$i = 0;
		while($res = $result->fetchArray(SQLITE3_NUM))
			{ 
				$autocomplete_data[$i] = $res; 
				$i++; 
			} 
				
		$autocomplete_file = fopen("gene_desc.json", "w") or die("Unable to open file!");
		
		fwrite($autocomplete_file, "[\n");
		
		$autocomplete_data_length = count($autocomplete_data);
		
		for($i = 0; $i < $autocomplete_data_length; $i++)
		{			
			fwrite($autocomplete_file, "\t{\n");
			$write_string = "\t\t";
			$write_string = $write_string . '"desc": "' . $autocomplete_data[$i][0] . '"';			
			fwrite($autocomplete_file, $write_string);
			fwrite($autocomplete_file, "\n");
			if($i != ($autocomplete_data_length - 1))
			{
				fwrite($autocomplete_file, "\t},\n");
			}
			else
			{
				fwrite($autocomplete_file, "\t}\n");				
			}
		}

		fwrite($autocomplete_file, "]");
		fclose($autocomplete_file);
		

	} catch (Exception $e) 
	{
		echo "Autocomplete Failed!";
		return "Failed";
	}
	
}

function startJSON($filename)
{
	$file = fopen($filename, "w");
	fwrite($file,"[");
	fwrite($file,"\n");
	fclose($file);
}

function endJSON($filename)
{
	$file = fopen($filename, "a");
	fwrite($file,"]");
	fclose($file);	
}

function writeTempExpFile($expression_array, $flag)
{
	$temp_exp_file = fopen("temp_exp_file.json", "a");
	fwrite($temp_exp_file, "\t");
	fwrite($temp_exp_file, "{");
	fwrite($temp_exp_file, "\n");
	fwrite($temp_exp_file, "\t\t");
	fwrite($temp_exp_file, '"Expression": ');	
	$bar_array = implode("|", $expression_array);
	$bar_array = str_replace("\n", "", $bar_array);
	$bar_array = '"' . $bar_array . '"';
	fwrite($temp_exp_file, $bar_array);
	fwrite($temp_exp_file, "\n");
	fwrite($temp_exp_file, "\t");
	fwrite($temp_exp_file, "}");
	if($flag == 0)
	{
		fwrite($temp_exp_file, ",");
		fwrite($temp_exp_file, "\n");
	}
	else
	{
		fwrite($temp_exp_file, "\n");
	}
	fclose($temp_exp_file);
	
}

function writeTempGroupFile($g_array)
{
	$g_array_length = count($g_array);

	$temp_group_file = fopen("temp_group_file.json", "a");
	//fwrite($temp_group_file, "\t");
	//fwrite($temp_group_file, "{");
	//fwrite($temp_group_file, "\n");
	//fwrite($temp_group_file, "\t\t");
	for($i = 0; $i < $g_array_length; $i++)
	{
		fwrite($temp_group_file, "\t");
		fwrite($temp_group_file, "{");
		fwrite($temp_group_file, "\n");
		fwrite($temp_group_file, "\t\t");
		fwrite($temp_group_file, '"Cell_name": ');
		fwrite($temp_group_file, ('"*' . $g_array[$i]['cell_name'] . '*"'));
		fwrite($temp_group_file, ",");
		fwrite($temp_group_file, "\n");
		fwrite($temp_group_file, "\t\t");
		fwrite($temp_group_file, '"Group_num": ');
		fwrite($temp_group_file, ('"*' . $g_array[$i]['group_num'] . '*"'));
		fwrite($temp_group_file, ",");
		fwrite($temp_group_file, "\n");
		fwrite($temp_group_file, "\t\t");
		fwrite($temp_group_file, '"Group_name": ');	
		fwrite($temp_group_file, ('"*' . $g_array[$i]['group_name'] . '*"'));
		fwrite($temp_group_file, "\n");
		fwrite($temp_group_file, "\t");
		fwrite($temp_group_file, "}");
		if($i != ($g_array_length-1))
		{
			fwrite($temp_group_file, ",");
		}
		fwrite($temp_group_file, "\n");
		
	}
	
}

?>