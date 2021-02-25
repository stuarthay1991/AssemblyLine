<html>
<head>
<link rel="stylesheet" href="main.css" charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="Script.js"></script>
<style>
</style>
</head>

<body style="background-color: #e6e6e6;">
<div class="container" style="position: fixed; border-bottom: 3px solid #4E4D5C; width: 100%; height: 50px; display: block; background-color: #aeacb9; z-index: 1;">
<span class="c_title"><strong>AltAnalyze Expression Viewer Portal</strong></span>
<span class="c_divider">|</span>
<span class="c_off" onclick="onSelectCreate();">Create<i class="glyphicon glyphicon-plus" style="margin: 5px;"></i></span>
<span class="c_on">Go<i class="glyphicon glyphicon-arrow-right" style="margin: 5px;"></i></span>
</div>	
<div class="container" style="position: relative; top: 75px;">
	<h2>Expression Viewer List</h2>
	<div class="panel panel-default" style="background-color: #f2f2f2; opacity: 1; max-height: 1600px;">
		<table id="table" class="customTable">
			<thead><th>Database Name</th><th>Author</th><th>Last Update</th><th>Link</th></thead>
			<?php
				require '/var/www/AltAnalyze/ICGS/AssemblyLine/portaltablesetup.php';
				$root_dir = scandir("../Public");
				for($i = 3; $i < count($root_dir); $i++)
				{
					$thing = $root_dir[$i];
					$dirpath = "../Public/" . $thing . "/";
					$detailtxt = $dirpath . "details.txt";
					$detailfile = fopen($detailtxt,"r");
					$detailfile_line1 = fgets($detailfile);
					$detailfile_line1 = preg_replace("/\r|\n/", "", $detailfile_line1);
					$dlm = getDateLastModified($dirpath, $thing);
					//Start outputting to table
					echo "<tr><td>";
					echo $thing;
					echo "</td>";
					echo "<td>";
					echo $detailfile_line1;
					echo "</td>";
					echo "<td>";
					echo $dlm;
					echo "</td>";
					echo "<td>";
					$output1 = "<a href=http://www.altanalyze.org/ICGS/Public/" . $thing . "/User.php>" . "http://www.altanalyze.org/ICGS/Public/" . $thing . "/User.php</a>";
					echo $output1;
					echo "</td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>

</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#table').DataTable( {
        "order": [[ 1, "desc" ]]
    } );
} );	
</script>
</body>
</html>