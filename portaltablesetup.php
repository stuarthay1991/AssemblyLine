<?php

function getDateLastModified($dpath_in, $dbname)
{
	$file_in_question = $dpath_in . $dbname . ".db";
	if(file_exists($file_in_question))
	{
		$retval = date("F d Y H:i:s.", filemtime($file_in_question));
		return $retval;
	}
	else
	{
		return "NA";
	}
}

?>