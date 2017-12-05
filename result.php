<html>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
		<script src="js/jquery.canvasjs.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=YES">
		<style>
			body{
					background-color:#f8f9fa ;
			}
		</style>
		<?php
			error_reporting(E_ERROR);
			//$conn = mysqli_connect("*", "*", "*","*");
			$conn = mysqli_connect("*", "*", "*","*");
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
			
			$type=""; $age=""; $color=""; $breed=""; $name="";
			$tsql=""; $asql=""; $csql=""; $bsql=""; $nsql="";
			
			if (empty($_POST["type"])) {
				$tsql="";
			} else {
				$type = test_input($_POST["type"]);
				$type_num=$type[0] -1;
				$tsql = "AND type='".$type_num."' ";
			}
			
			if (empty($_POST["age"])) {
				$asql="";
			} else {
				$age = test_input($_POST["age"]);
				$age_num=$age[0];
				switch($age_num){
					case 1:
						$asql="AND age < 8 ";
						break;
					case 2:
						$asql="AND age < 31 AND age > 7 "; 
						break;
					case 3:
						$asql="AND age < 181 AND age > 30 "; 
						break;
					case 4:
						$asql="AND age < 366 AND age > 180 "; 
						break;
					case 5:
						$asql="AND age < 731 AND age > 365 "; 
						break;
					case 6:
						$asql="AND age < 1826 AND age > 730 "; 
						break;
					case 7:
						$asql="AND age < 3651 AND age > 1825 "; 
						break;
					case 8:
						$asql="AND age > 3650 "; 
						break;
				}
			}
			
			if (empty($_POST["color"])) {
				$csql="";
			} else {
				$color = test_input($_POST["color"]);
				foreach( $color as $value){
					$csql .= "AND (color1 LIKE '%".$value."%' OR color2 LIKE '%".$value."%') ";
				}
			}
			
			if (empty($_POST["breed"])) {
				$bsql="";
			} else {
				$breed = test_input($_POST["breed"]);
				foreach($breed as $value){
					$bsql = "AND (breed1 LIKE '%".$value."%' OR breed2 LIKE '%".$value."%' OR breed3 LIKE '%".$value."%') ";
				}
			}
			
			if (empty($_POST["name"])) {
				$nsql="";
			} else {
				$name = test_input($_POST["name"]);
				foreach($name as $value){
					$nsql = "AND name LIKE '%".$value."%' ";
				}
			}

			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				$data = str_replace("-", ' ', $data);
				$data = str_replace("_", ' ', $data);
				$data = preg_replace('/[^A-Za-z0-9\-]/', ' ', $data);
				$data_split = explode(" ", $data);
				return $data_split;
			}
			
			$query = "SELECT outcome, count(*) AS num FROM total WHERE animalID != 'NULL' ";
			$query2 = "GROUP BY outcome ";
			$sqlString=$query.$tsql.$asql.$csql.$bsql.$nsql.$query2;
			$result = mysqli_query($conn,$sqlString);
			$outcome_data = array(0,0,0,0,0);
			$i=0;
			
			while($row = mysqli_fetch_assoc($result)) {
				
				$outcome_data[(int)$row["outcome"]] = (int)$row["num"];
				$i += 1;
			}
			if (mysqli_num_rows($result)==0){
				echo "<br/><br/><center><h1>No Similar Result Found</h1></center>";
				echo '<script type="text/javascript"> window.stop(); </script>';
			}else {
				;
			}
		?>
		<script type="text/javascript">
			window.onload = function () {
			//overall_outcome
				var chart1 = new CanvasJS.Chart("overall_outcome", {
					theme: "theme2",
					backgroundColor: "",
					animationEnabled: true,
					animationDuration: 300,
					data: [
					{
						type: "pie",
						indexLabelFontSize: 10,
						showInLegend: true,
						toolTipContent: "{y} - #percent %",
						legendText: "{indexLabel}",
						dataPoints: [
							{y: <?php echo $outcome_data[0] ?>,indexLabel:"Adoption"},
							{y: <?php echo $outcome_data[1] ?>,indexLabel:"Transfer"},
							{y: <?php echo $outcome_data[2] ?>,indexLabel:"Return to Owner"},
							{y: <?php echo $outcome_data[3] ?>,indexLabel:"Euthanasia"},
							{y: <?php echo $outcome_data[4] ?>,indexLabel:"Died"},
						]
					}
					]
				});
				chart1.render();
			};
		</script>
	</head>
	<body>  
		
		<div id="result"><center><p id="overall_outcome" style="  width: 100%"></p></center></div>
				
	</body>
</html>