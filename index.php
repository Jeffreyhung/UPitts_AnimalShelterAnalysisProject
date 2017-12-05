<?php
	//$conn = mysqli_connect("*", "*", "*","*");
	$conn = mysqli_connect("*", "*", "*","*");
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
<html>
	<head>
		<title>Animal Shelter</title>
		<link rel="Shortcut Icon" type="image/x-icon" href="css/load.png" />
		<meta charset="UTF8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
		<script type="text/javascript" src="js/jquery.fullPage.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.fullPage.css" />
		<script src="js/jquery.canvasjs.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
					$('#fullpage').fullpage({
						'navigation': true,
						'navigationPosition': 'right',
						'scrollBar': false,
					});
				});
		</script>
		<?php
			$month_array = array ('','Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		//num of dogs and cats
			$num_of_dog = mysqli_query($conn, "SELECT num FROM num_of_dog_cat WHERE type=1");
			$numofdog_row=mysqli_fetch_assoc($num_of_dog);
			$num_of_cat = mysqli_query($conn, "SELECT num FROM num_of_dog_cat WHERE type=0");
			$numofcat_row=mysqli_fetch_assoc($num_of_cat);
		//num of names
			$num_of_name = mysqli_query($conn, "SELECT num FROM have_name WHERE name='YES'");
			$numofname_row=mysqli_fetch_assoc($num_of_name);
			$num_of_noname = mysqli_query($conn, "SELECT num FROM have_name WHERE name='NO'");
			$numofnoname_row=mysqli_fetch_assoc($num_of_noname);
		//overall_outcome
			$overall_outcome_data = array(0,0,0,0,0);
			$overall_outcome = mysqli_query($conn, "SELECT * FROM overall_outcome");
			$i=0;
			while($row = mysqli_fetch_assoc($overall_outcome)) {
				$overall_outcome_data[$i] = (int)$row["num"];
				$i += 1;
			}
		//dog_outcome
			$dog_outcome_data = array(0,0,0,0,0);
			$dog_outcome = mysqli_query($conn, "SELECT * FROM dog_outcome");
			$i =0;
			while($row = mysqli_fetch_assoc($dog_outcome)) {
				$dog_outcome_data[$i] = (int)$row["num"];
				$i += 1;
			}
		//cat_outcome
			$cat_outcome_data = array(0,0,0,0,0);
			$cat_outcome = mysqli_query($conn, "SELECT * FROM cat_outcome");
			$i =0;
			while($row = mysqli_fetch_assoc($cat_outcome)) {
				$cat_outcome_data[$i] = (int)$row["num"];
				$i += 1;
			}
		//relation of outcome and time
			$time_outcome_data = array();
			$outcome_time = mysqli_query($conn, "SELECT * FROM outcome_time");
			$j=0;
			$temp2 =0;
			while($row = mysqli_fetch_assoc($outcome_time)) {
				$temp = array();
				for($i=0; $i<24; $i++){
					$temp2 = (int) $row[$i];
					$point = array("x" => $i,"y" => $temp2);
					array_push($temp, $point);
				}
				$time_outcome_data[$j]=$temp;
				$j += 1;				
			}
		//adoption_age
			$adopt_age_data = array();
			$adopt_age = mysqli_query($conn, "SELECT * FROM outcome_age_percentage WHERE type='0'");
			while($row = mysqli_fetch_assoc($adopt_age)) {
				$adopt_age_data = $row;
			}
		//adoption_age_dog
			$adopt_age_data_dog = array();
			$adopt_age_dog = mysqli_query($conn, "SELECT * FROM outcome_age_dog_percentage WHERE type='0'");
			while($row = mysqli_fetch_assoc($adopt_age_dog)) {
				$adopt_age_data_dog = $row;
			}
		//adoption_age_cat
			$adopt_age_data_cat = array();
			$adopt_age_cat = mysqli_query($conn, "SELECT * FROM outcome_age_cat_percentage WHERE type='0'");
			while($row = mysqli_fetch_assoc($adopt_age_cat)) {
				$adopt_age_data_cat = $row;
			}
		//adoption_month
			$adopt_month_data = array();
			$adoption_month = mysqli_query($conn, "SELECT * FROM outcome_month WHERE type='0'");
			$temp =0;
			while($row = mysqli_fetch_assoc($adoption_month)) {
				for($i=1; $i<13; $i++){
					$temp = (int) $row[$i];
					$point = array("label" =>$month_array[$i],"y" => $temp);
					array_push($adopt_month_data, $point);
				}
			}	
		//return_age
			$return_age_data = array();
			$return_age = mysqli_query($conn, "SELECT * FROM outcome_age_percentage WHERE type='2'");
			while($row = mysqli_fetch_assoc($return_age)) {
				$return_age_data = $row;
			}
		//return_age_dog
			$return_age_data_dog = array();
			$return_age_dog = mysqli_query($conn, "SELECT * FROM outcome_age_dog_percentage WHERE type='2'");
			while($row = mysqli_fetch_assoc($return_age_dog)) {
				$return_age_data_dog = $row;
			}
		//return_age_cat
			$return_age_data_cat = array();
			$return_age_cat = mysqli_query($conn, "SELECT * FROM outcome_age_cat_percentage WHERE type='2'");
			while($row = mysqli_fetch_assoc($return_age_cat)) {
				$return_age_data_cat = $row;
			}
		//euthanasia_age
			$euthanasia_age_data = array();
			$euthanasia_age = mysqli_query($conn, "SELECT * FROM outcome_age WHERE type='3'");
			while($row = mysqli_fetch_assoc($euthanasia_age)) {
				$euthanasia_age_data = $row;
			}
		//died_month
			$died_month_data = array();
			$died_month = mysqli_query($conn, "SELECT * FROM outcome_month WHERE type='4'");
			$temp = 0;
			while($row = mysqli_fetch_assoc($died_month)) {
				for($i=1; $i<13; $i++){
					$temp = (int) $row[$i] ;
					$point = array("label" => $month_array[$i],"y" => $temp);
					array_push($died_month_data, $point);
				}
			}
		//died_month_dog
			$died_month_data_dog = array();
			$died_month_dog = mysqli_query($conn, "SELECT * FROM outcome_month_dog WHERE type='4'");
			$temp = 0;
			while($row = mysqli_fetch_assoc($died_month_dog)) {
				for($i=1; $i<13; $i++){
					$temp = (int) $row[$i] ;
					$point = array("label" => $month_array[$i],"y" => $temp);
					array_push($died_month_data_dog, $point);
				}
			}
		//died_month_cat
			$died_month_data_cat = array();
			$died_month_cat = mysqli_query($conn, "SELECT * FROM outcome_month_cat WHERE type='4'");
			$temp = 0;
			while($row = mysqli_fetch_assoc($died_month_cat)) {
				for($i=1; $i<13; $i++){
					$temp = (int) $row[$i] ;
					$point = array("label" => $month_array[$i],"y" => $temp);
					array_push($died_month_data_cat, $point);
				}
			}
		?>
		<script type="text/javascript">
			window.onload = function () {
			//num of dogs and cats
				var chart = new CanvasJS.Chart("dogvscat",{
					theme: "theme2",
					backgroundColor: "",
					title:{
						text: "Number of Dogs and Cats",
					},
					data: [
					{
						type: "pie",
						showInLegend: true,
						toolTipContent: "{y} - #percent %",
						legendText: "{indexLabel} - #percent %",
						dataPoints: [
							{ y: <?php echo $numofdog_row["num"] ?>, indexLabel:"Dog"},
							{ y: <?php echo $numofcat_row["num"] ?>, indexLabel:"Cat"}
						]
					}
					]
				});
				chart.render();
			//num of names
				var chart0 = new CanvasJS.Chart("nameornot",{
					title:{
						text: "Percentage of animal with name"
					},
					backgroundColor: "",
					data: [
					{
						type: "pie",
						showInLegend: true,
						toolTipContent: "{y} - #percent %",
						legendText: "{indexLabel} - #percent %",
						dataPoints: [
							{ y: <?php echo $numofname_row["num"] ?>, indexLabel:"With Name"},
							{ y: <?php echo $numofnoname_row["num"] ?>, indexLabel:"Without Name"}
						]
					}
					]
				});
				chart0.render();
			//overall_outcome
				var chart1 = new CanvasJS.Chart("overall_outcome", {
					theme: "theme2",
					backgroundColor: "",
					title:{
						text: "Overall Outcome"
					},
					data: [
					{
						type: "pie",
						showInLegend: true,
						toolTipContent: "{y} - #percent %",
						legendText: "{indexLabel}",
						dataPoints: [
							{y: <?php echo $overall_outcome_data[0] ?>,indexLabel:"Adoption"},
							{y: <?php echo $overall_outcome_data[1] ?>,indexLabel:"Transfer"},
							{y: <?php echo $overall_outcome_data[2] ?>,indexLabel:"Return to Owner"},
							{y: <?php echo $overall_outcome_data[3] ?>,indexLabel:"Euthanasia"},
							{y: <?php echo $overall_outcome_data[4] ?>,indexLabel:"Died"},
						]
					}
					]
				});
				chart1.render();
			//dog_outcome
				var chart2 = new CanvasJS.Chart("dog_outcome", {
					title:{
						text: "Dog outcome"
					},
					backgroundColor: "",
					data: [
					{
						type: "pie",
						toolTipContent: "{y} - #percent %",
						dataPoints: [
							{y: <?php echo $dog_outcome_data[0] ?>,indexLabel:"Adoption"},
							{y: <?php echo $dog_outcome_data[1] ?>,indexLabel:"Transfer"},
							{y: <?php echo $dog_outcome_data[2] ?>,indexLabel:"Return to Owner"},
							{y: <?php echo $dog_outcome_data[3] ?>,indexLabel:"Euthanasia"},
							{y: <?php echo $dog_outcome_data[4] ?>,indexLabel:"Died"},
						]
					}
					]
				});
				chart2.render();
			//cat_outcome
				var chart3 = new CanvasJS.Chart("cat_outcome", {
					title:{
						text: "Cat outcome"
					},
					backgroundColor: "",
					data: [
					{
						type: "pie",
						toolTipContent: "{y} - #percent %",
						dataPoints: [
							{y: <?php echo $cat_outcome_data[0] ?>,indexLabel:"Adoption"},
							{y: <?php echo $cat_outcome_data[1] ?>,indexLabel:"Transfer"},
							{y: <?php echo $cat_outcome_data[2] ?>,indexLabel:"Return to Owner"},
							{y: <?php echo $cat_outcome_data[3] ?>,indexLabel:"Euthanasia"},
							{y: <?php echo $cat_outcome_data[4] ?>,indexLabel:"Died"},
						]
					}
					]
				});
				chart3.render();
			//relation of outcome and time
				var chart4 = new CanvasJS.Chart("relationofoutcome", {
					backgroundColor: "",
					axisX: {
						title: "Hours of Day",
					},
					axisY: {
						title: "Numbers",
						includeZero: true,
					},
					toolTip:{
						shared: true
					},
					title:{
						text: "Relation between Outcome and Time"
					},
					data: [
					{
						name: "Adoption",
						type: "spline",
						showInLegend: true,
						toolTipContent:"Adoption:{y}",
						legendText: "Adoption",
						dataPoints: <?php echo json_encode($time_outcome_data[0]); ?>
					},
					{
						name: "Transfer",
						type: "spline",
						showInLegend: true,
						toolTipContent: "Transfer:{y}",
						legendText: "Transfer",
						dataPoints: <?php echo json_encode($time_outcome_data[1]); ?>
					},
					{
						name: "Return_to_Owner",
						type: "spline",
						showInLegend: true,
						toolTipContent: "Return to Owner:{y}",
						legendText: "Return to Owner",
						dataPoints: <?php echo json_encode($time_outcome_data[2]); ?>
					},
					{
						name: "Euthanasia",
						type: "spline",
						showInLegend: true,
						toolTipContent: "Euthanasia:{y}",
						legendText: "Euthanasia",
						dataPoints: <?php echo json_encode($time_outcome_data[3]); ?>
					},
					{
						name: "Died",
						type: "spline",
						showInLegend: true,
						toolTipContent: "Died:{y}",
						legendText: "Died",
						dataPoints: <?php echo json_encode($time_outcome_data[4]); ?>
					}
					
					]
				});
				chart4.render();
			//relation of adopt and age
				var chart5 = new CanvasJS.Chart("relationofadoptandage", {
					backgroundColor: "",
					axisY: {
						title: "Percentage",
						includeZero: true,
						ValueFormatString:"0.00 '%'",
						maximum: 100
					},
					title:{
						text: "Relation between Adoption and Age"
					},
					data: [
					{
						type: "column",
						yValueFormatString:"0.00 '%'",
						legendMarkerColor: "grey",
						indexLabel: "{y}",
						dataPoints: [
							{y: <?php echo $adopt_age_data['0'] ?>, label:"Less than 1 Weeks"},
							{y: <?php echo $adopt_age_data['1'] ?>, label:"1 Week to 1 Month"},
							{y: <?php echo $adopt_age_data['2'] ?>, label:"1 Month to 6 Months"},
							{y: <?php echo $adopt_age_data['3'] ?>, label:"6 Months to 1 Years"},
							{y: <?php echo $adopt_age_data['4'] ?>, label:"1 Year to 2 Years"},
							{y: <?php echo $adopt_age_data['5'] ?>, label:"2 Years to 5 Years"},
							{y: <?php echo $adopt_age_data['6'] ?>, label:"5 Years to 10 Years"},
							{y: <?php echo $adopt_age_data['7'] ?>, label:"More than 10 Years"}
						]
					}
					]
				});
				chart5.render();
			//relation of adopt and age dog
				var chart11 = new CanvasJS.Chart("relationofadoptandage_dog", {
					backgroundColor: "",
					axisY: {
						title: "Percentage",
						includeZero: true,
						maximum: 100
					},
					title:{
						text: "Relation between Adoption and Age of Dog"
					},
					data: [
					{
						type: "column",  
						yValueFormatString:"0.00 '%'",
						indexLabel: "{y}",
						legendMarkerColor: "grey",
						dataPoints: [
							{y: <?php echo $adopt_age_data_dog['0'] ?>, label:"Less than 1 Weeks"},
							{y: <?php echo $adopt_age_data_dog['1'] ?>, label:"1 Week to 1 Month"},
							{y: <?php echo $adopt_age_data_dog['2'] ?>, label:"1 Month to 6 Months"},
							{y: <?php echo $adopt_age_data_dog['3'] ?>, label:"6 Months to 1 Years"},
							{y: <?php echo $adopt_age_data_dog['4'] ?>, label:"1 Year to 2 Years"},
							{y: <?php echo $adopt_age_data_dog['5'] ?>, label:"2 Years to 5 Years"},
							{y: <?php echo $adopt_age_data_dog['6'] ?>, label:"5 Years to 10 Years"},
							{y: <?php echo $adopt_age_data_dog['7'] ?>, label:"More than 10 Years"}
						]
					}
					]
				});
				chart11.render();
			//relation of adopt and age cat
				var chart11 = new CanvasJS.Chart("relationofadoptandage_cat", {
					backgroundColor: "",
					axisY: {
						title: "Percentage",
						includeZero: true,
						maximum: 100
					},
					title:{
						text: "Relation between Adoption and Age of Cat"
					},
					data: [
					{
						type: "column",
						yValueFormatString:"0.00 '%'",
						indexLabel: "{y}",
						legendMarkerColor: "grey",
						dataPoints: [
							{y: <?php echo $adopt_age_data_cat['0'] ?>, label:"Less than 1 Weeks"},
							{y: <?php echo $adopt_age_data_cat['1'] ?>, label:"1 Week to 1 Month"},
							{y: <?php echo $adopt_age_data_cat['2'] ?>, label:"1 Month to 6 Months"},
							{y: <?php echo $adopt_age_data_cat['3'] ?>, label:"6 Months to 1 Years"},
							{y: <?php echo $adopt_age_data_cat['4'] ?>, label:"1 Year to 2 Years"},
							{y: <?php echo $adopt_age_data_cat['5'] ?>, label:"2 Years to 5 Years"},
							{y: <?php echo $adopt_age_data_cat['6'] ?>, label:"5 Years to 10 Years"},
							{y: <?php echo $adopt_age_data_cat['7'] ?>, label:"More than 10 Years"}
						]
					}
					]
				});
				chart11.render();
			//relation of adopt and Month
				var chart8 = new CanvasJS.Chart("relationofadoptandmonth", {
					backgroundColor: "",
					axisY: {
						title: "Numbers",
						includeZero: true,
					},
					title:{
						text: "Relation between Adoption and Month"
					},
					data: [
					{	
						type: "column",  
						legendMarkerColor: "grey",
						indexLabel: "{y}",
						dataPoints: <?php echo json_encode($adopt_month_data); ?>
					}
					]
				});
				chart8.render();
			//relation of return and age
				var chart5 = new CanvasJS.Chart("relationofreturnandage", {
					backgroundColor: "",
					axisY: {
						title: "Percentage",
						includeZero: true,
						maximum: 100
					},
					title:{
						text: "Relation between Return to Owner and Age"
					},
					data: [
					{
						type: "column",
						yValueFormatString:"0.00 '%'",
						indexLabel: "{y}",
						legendMarkerColor: "grey",
						dataPoints: [
							{y: <?php echo $return_age_data['0'] ?>, label:"Less than 1 Weeks"},
							{y: <?php echo $return_age_data['1'] ?>, label:"1 Week to 1 Month"},
							{y: <?php echo $return_age_data['2'] ?>, label:"1 Month to 6 Months"},
							{y: <?php echo $return_age_data['3'] ?>, label:"6 Months to 1 Years"},
							{y: <?php echo $return_age_data['4'] ?>, label:"1 Year to 2 Years"},
							{y: <?php echo $return_age_data['5'] ?>, label:"2 Years to 5 Years"},
							{y: <?php echo $return_age_data['6'] ?>, label:"5 Years to 10 Years"},
							{y: <?php echo $return_age_data['7'] ?>, label:"More than 10 Years"}
						]
					}
					]
				});
				chart5.render();
			//relation of return and age dog
				var chart11 = new CanvasJS.Chart("relationofreturnandage_dog", {
					backgroundColor: "",
					axisY: {
						title: "Percentage",
						includeZero: true,
						maximum: 100
					},
					title:{
						text: "Relation between Return to Owner and Age of Dog"
					},
					data: [
					{
						type: "column",
						yValueFormatString:"0.00 '%'",
						indexLabel: "{y}",
						legendMarkerColor: "grey",
						dataPoints: [
							{y: <?php echo $return_age_data_dog['0'] ?>, label:"Less than 1 Weeks"},
							{y: <?php echo $return_age_data_dog['1'] ?>, label:"1 Week to 1 Month"},
							{y: <?php echo $return_age_data_dog['2'] ?>, label:"1 Month to 6 Months"},
							{y: <?php echo $return_age_data_dog['3'] ?>, label:"6 Months to 1 Years"},
							{y: <?php echo $return_age_data_dog['4'] ?>, label:"1 Year to 2 Years"},
							{y: <?php echo $return_age_data_dog['5'] ?>, label:"2 Years to 5 Years"},
							{y: <?php echo $return_age_data_dog['6'] ?>, label:"5 Years to 10 Years"},
							{y: <?php echo $return_age_data_dog['7'] ?>, label:"More than 10 Years"}
						]
					}
					]
				});
				chart11.render();
			//relation of return and age cat
				var chart11 = new CanvasJS.Chart("relationofreturnandage_cat", {
					backgroundColor: "",
					axisY: {
						title: "Percentage",
						includeZero: true,
						maximum: 100
					},
					title:{
						text: "Relation between Return to Owner and Age of Cat"
					},
					data: [
					{
						type: "column",
						yValueFormatString:"0.00 '%'",
						indexLabel: "{y}",
						legendMarkerColor: "grey",
						dataPoints: [
							{y: <?php echo $return_age_data_cat['0'] ?>, label:"Less than 1 Weeks"},
							{y: <?php echo $return_age_data_cat['1'] ?>, label:"1 Week to 1 Month"},
							{y: <?php echo $return_age_data_cat['2'] ?>, label:"1 Month to 6 Months"},
							{y: <?php echo $return_age_data_cat['3'] ?>, label:"6 Months to 1 Years"},
							{y: <?php echo $return_age_data_cat['4'] ?>, label:"1 Year to 2 Years"},
							{y: <?php echo $return_age_data_cat['5'] ?>, label:"2 Years to 5 Years"},
							{y: <?php echo $return_age_data_cat['6'] ?>, label:"5 Years to 10 Years"},
							{y: <?php echo $return_age_data_cat['7'] ?>, label:"More than 10 Years"}
						]
					}
					]
				});
				chart11.render();
			//relation of euthanasia and age
				var chart9 = new CanvasJS.Chart("relationofeuthanasiaandage", {
					backgroundColor: "",
					axisY: {
						title: "Numbers",
						includeZero: true,
					},
					title:{
						text: "Relation between Euthanasia and Age"
					},
					data: [
					{
						type: "column",  
						legendMarkerColor: "grey",
						indexLabel: "{y}",
						dataPoints: [
							{y: <?php echo $euthanasia_age_data['0'] ?>, label:"Less than 1 Weeks"},
							{y: <?php echo $euthanasia_age_data['1'] ?>, label:"1 Week to 1 Month"},
							{y: <?php echo $euthanasia_age_data['2'] ?>, label:"1 Month to 6 Months"},
							{y: <?php echo $euthanasia_age_data['3'] ?>, label:"6 Months to 1 Years"},
							{y: <?php echo $euthanasia_age_data['4'] ?>, label:"1 Year to 2 Years"},
							{y: <?php echo $euthanasia_age_data['5'] ?>, label:"2 Years to 5 Years"},
							{y: <?php echo $euthanasia_age_data['6'] ?>, label:"5 Years to 10 Years"},
							{y: <?php echo $euthanasia_age_data['7'] ?>, label:"More than 10 Years"}
						]
					}
					]
				});
				chart9.render();
			//relation of died and Month
				var chart10 = new CanvasJS.Chart("relationofdiedandmonth", {
					backgroundColor: "",
					axisY: {
						title: "Number",
						includeZero: true,
						maximum: 30
					},
					title:{
						text: "Relation between Died and Month"
					},
					data: [
					{
						type: "column",  
						legendMarkerColor: "grey",
						indexLabel: "{y}",
						dataPoints: <?php echo json_encode($died_month_data); ?>
					}
					]
				});
				chart10.render();
			//relation of died and Month dog
				var chart13 = new CanvasJS.Chart("relationofdiedandmonth_dog", {
					backgroundColor: "",
					axisY: {
						title: "Number",
						includeZero: true,
						maximum: 30
					},
					title:{
						text: "Relation between Died and Month of Dog"
					},
					data: [
					{
						type: "column",  
						legendMarkerColor: "grey",
						indexLabel: "{y}",
						dataPoints: <?php echo json_encode($died_month_data_dog); ?>
					}
					]
				});
				chart13.render();
			//relation of died and Month cat
				var chart12 = new CanvasJS.Chart("relationofdiedandmonth_cat", {
					backgroundColor: "",
					axisY: {
						title: "Number",
						includeZero: true,
						maximum: 30
					},
					title:{
						text: "Relation between Died and Month of Cat"
					},
					data: [
					{
						type: "column",  
						legendMarkerColor: "grey",
						indexLabel: "{y}",
						dataPoints: <?php echo json_encode($died_month_data_cat); ?>
					}
					]
				});
				chart12.render();
			//dog_outcome_2
				var chart22 = new CanvasJS.Chart("dog_outcome2", {
					title:{
						text: "Dog outcome"
					},
					backgroundColor: "",
					data: [
					{
						type: "pie",
						toolTipContent: "{y} - #percent %",
						dataPoints: [
							{y: <?php echo $dog_outcome_data[0] ?>,indexLabel:"Adoption"},
							{y: <?php echo $dog_outcome_data[1] ?>,indexLabel:"Transfer"},
							{y: <?php echo $dog_outcome_data[2] ?>,indexLabel:"Return to Owner"},
							{y: <?php echo $dog_outcome_data[3] ?>,indexLabel:"Euthanasia"},
							{y: <?php echo $dog_outcome_data[4] ?>,indexLabel:"Died"},
						]
					}
					]
				});
				chart22.render();
			//cat_outcome_2
				var chart32 = new CanvasJS.Chart("cat_outcome2", {
					title:{
						text: "Cat outcome"
					},
					backgroundColor: "",
					data: [
					{
						type: "pie",
						toolTipContent: "{y} - #percent %",
						dataPoints: [
							{y: <?php echo $cat_outcome_data[0] ?>,indexLabel:"Adoption"},
							{y: <?php echo $cat_outcome_data[1] ?>,indexLabel:"Transfer"},
							{y: <?php echo $cat_outcome_data[2] ?>,indexLabel:"Return to Owner"},
							{y: <?php echo $cat_outcome_data[3] ?>,indexLabel:"Euthanasia"},
							{y: <?php echo $cat_outcome_data[4] ?>,indexLabel:"Died"},
						]
					}
					]
				});
				chart32.render();
			//dog_outcome_3
				var chart23 = new CanvasJS.Chart("dog_outcome3", {
					title:{
						text: "Dog outcome"
					},
					backgroundColor: "",
					data: [
					{
						type: "pie",
						toolTipContent: "{y} - #percent %",
						dataPoints: [
							{y: <?php echo $dog_outcome_data[0] ?>,indexLabel:"Adoption"},
							{y: <?php echo $dog_outcome_data[1] ?>,indexLabel:"Transfer"},
							{y: <?php echo $dog_outcome_data[2] ?>,indexLabel:"Return to Owner"},
							{y: <?php echo $dog_outcome_data[3] ?>,indexLabel:"Euthanasia"},
							{y: <?php echo $dog_outcome_data[4] ?>,indexLabel:"Died"},
						]
					}
					]
				});
				chart23.render();
			//cat_outcome_3
				var chart33 = new CanvasJS.Chart("cat_outcome3", {
					title:{
						text: "Cat outcome"
					},
					backgroundColor: "",
					data: [
					{
						type: "pie",
						toolTipContent: "{y} - #percent %",
						dataPoints: [
							{y: <?php echo $cat_outcome_data[0] ?>,indexLabel:"Adoption"},
							{y: <?php echo $cat_outcome_data[1] ?>,indexLabel:"Transfer"},
							{y: <?php echo $cat_outcome_data[2] ?>,indexLabel:"Return to Owner"},
							{y: <?php echo $cat_outcome_data[3] ?>,indexLabel:"Euthanasia"},
							{y: <?php echo $cat_outcome_data[4] ?>,indexLabel:"Died"},
						]
					}
					]
				});
				chart33.render();
			};
		</script>
		
		<style>
			#dog_outcome, #cat_outcome, #dog_outcome2, #cat_outcome2, #dog_outcome3, #cat_outcome3 {
				width: 40%;
				padding: 20px;
				display: inline-block;
			}
			body {
				background-image: url("css/bg.png");
				background-color:#F0F2F4 ;
			}
			#fp-nav ul li a span, .fp-slidesNav ul li a span, fp-tooltip {
				background: #000;
			}
			.section, .slide  {
				background-size: cover;
			}
			#title {
				margin-left: 4cm;
			}	
			#content {
				margin-left: 89px;
			}
			h1 {
				font-size:70px;
			}
			h2 {
				font-size:40px;
			}
			h3 {
				text-align: left;
				font-size: 1.6em;
				line-height: 1.6em;
			}
			h4 {
				margin-left: 25cm;
			}
			.rightside {
				top: 50%;
				width: 50%;
				float:right;
			}
			.leftside {
				position: absolute;
				margin-top: -50px;
				width: 50%;
				float:left;	
			}
		</style>
	</head>
	<body>	
		<div id="fullpage">
			<div class="section" id="title">
				<h1>DBMS Final Project<p style="font-size:0.5em; line-height: 0.5em;">Animal Shelter</p></h1>
				<h4 style="margin-bottom:px;">
					Chi-Heng, Hung &nbsp;&nbsp;	CHH162@pitt.edu<br/>
					Yu-Hsien, Lee &nbsp;&nbsp; YUL198@pitt.edu<br/>
					Chia-Jung, Chang &nbsp;&nbsp; CHC276@pitt.edu<br/>
					Ming-Hsuan, Chiang &nbsp;&nbsp; MIC128@pitt.edu<br/>
				</h4>
			</div>
			<div class="section" id="loading">
				<div class="slide" id="head"><h2><center> Data Loading Strategy</center></h2></div>
				<div class="slide" style="overflow:auto;">
					<div class="leftside" id="content">
						<h2>Create table </h2>
						<h3>
						Create animal_table for animal data<br/>
						&nbsp;&nbsp;&nbsp;with animalID, name, age<br/>
						Create outcome_table for outcome data<br/>
						&nbsp;&nbsp;&nbsp;with departure time, outcome type<br/>
						Create breed_table for breed data<br/>
						&nbsp;&nbsp;&nbsp;with animal type, breeds<br/>
						Create color_table for color data<br/>
						&nbsp;&nbsp;&nbsp;with colors<br/>
						</h3>
					</div>
					<div class="rightside" style="height: 400px; width: 50%; float:right;"><img src="css/data_lineage-1.png" style="height: 100%; margin-left:20px;"/></div>
				</div>
				<div class="slide" style="overflow:auto;">
					<div class="leftside" id="content">
					<h2>Load Data</h2>
					<h3>
						Using python<br/>
						&bull;&nbsp;Split time from date<br/>
						&bull;&nbsp;Reconstruct date and time format<br/>
						&bull;&nbsp;Rename the outcomes<br/>
						&bull;&nbsp;Rename animal type<br/>
						&bull;&nbsp;Separate colors and breeds<br/>
						&bull;&nbsp;Reconstruct the age into days<br/>
						INSERT INTO <br/>
						animal_table, outcome_table, color_table, breed_table
					</h3></div>
					<div class="rightside" style="height: 400px; width: 50%; float:right;"><img src="css/data_lineage-2.png" style="height: 140%; margin-top:-70px; margin-left:-10px;"/></div>
				</div>
			</div>
			<div class="section" id="diagram" style="overflow:auto;">
				<div class="slide" id="diagram">
					<div class="leftside" id="content" style="margin-top:250px; margin-left:6cm;">
						<h2>ER-Diagram</h2>
					</div>
					<div class="rightside" style="margin-top:100px;"><img src="css/ER-diagram.png"/></div>
				</div>
				<div class="slide" id="diagram">
					<div><img src="css/data_lineage-3.png" style="height: 100%; margin-left:0px;"/></div>
				</div>
			</div>
			<div class="section" id="exploration"><h2><center> What we found from the Animal Shelter data</center></h2></div>
		<!--Overall -->
			<div class="section" id="sect1"><p id="dogvscat" style="height: 500px; width: 100%;"></p></div>
			<div class="section" id="sect2"><p id="nameornot" style="height: 500px; width: 100%;"></p></div>
			<div class="section" id="sect3">
				<div class="slide" id="slide1"><p id="overall_outcome" style="height: 500px; width: 100%;"></p></div>
				<div class="slide" id="slide2"><p id="dog_outcome" style="height: 400px; width: 40%; margin-left: 20px;"></p><p id="cat_outcome" style="height: 400px; width: 40%; margin-left: 20px;"></p></div>
			</div>
			<div class="section" id="slide"><center><p id="relationofoutcome" style="height: 500px; width: 85%;"></p></center></div>
		<!--Adoption -->
			<div class="section" id="sect5">
				<div class="slide" id="slide"><center><p id="relationofadoptandage" style="height: 500px; width: 85%;"></p></center></div>
				<div class="slide" id="slide"><center><p id="relationofadoptandage_dog" style="height: 500px; width: 85%;"></p></center></div>
				<div class="slide" id="slide"><center><p id="relationofadoptandage_cat" style="height: 500px; width: 85%;"></p></center></div>
			</div>
			<div class="section" id="slide"><center><p id="relationofadoptandmonth" style="height: 500px; width: 85%;"></p></center></div>
		<!--ReturnToOwner-->
			<div class="section" id="sect11">
				<div class="slide" id="slide"><center><p id="relationofreturnandage" style="height: 500px; width: 85%;"></p></center></div>
				<div class="slide" id="slide"><center><p id="relationofreturnandage_dog" style="height: 500px; width: 85%;"></p></center></div>
				<div class="slide" id="slide"><center><p id="relationofreturnandage_cat" style="height: 500px; width: 85%;"></p></center></div>
				<div class="slide" id="slide2"><p id="dog_outcome2" style="height: 400px; width: 40%; margin-left: 20px;"></p><p id="cat_outcome2" style="height: 400px; width: 40%; margin-left: 20px;"></p></div>
			</div>
		<!--Euthanasia-->
			<div class="section" id="slide"><center><p id="relationofeuthanasiaandage" style="height: 500px; width: 85%;"></p></center></div>
		<!-- Died -->
			<div class="section" id="sect10">
				<div class="slide" id="slide"><center><p id="relationofdiedandmonth" style="height: 500px; width: 85%;"></p></center></div>
				<div class="slide" id="slide"><center><p id="relationofdiedandmonth_dog" style="height: 500px; width: 85%;"></p></center></div>
				<div class="slide" id="slide"><center><p id="relationofdiedandmonth_cat" style="height: 500px; width: 85%;"></p></center></div>
				<div class="slide" id="slide2"><p id="dog_outcome3" style="height: 400px; width: 40%; margin-left: 20px;"></p><p id="cat_outcome3" style="height: 400px; width: 40%; margin-left: 20px;"></p></div>
			</div>
			<div class="section" id="stimulation"><h2><center>What would happen if we were animals in the shelter ? </center></h2></div>
			<div class="section" id="stimulate">
				<iframe name="stimulate" id="stimulate" src="search.html" style="border: 0; width: 100%; height: 100%; margin-top:150px;" ></iframe>
			</div>
			<div class="section" id="end"><h1><center>THANK YOU</center></h1></div>
		</div>
	</body>
</html>
<!--
0 Animal
1 Name
2 Date
3 Time
4 Outcome_Type
5 Animal_Type
6 Ages(day)
7 Breed (list)
8 Color (list)

Animal_Type
1 Dog
0 Cat

Outcome_Type
0 Adoption
1 Transfer
2 Return_to_Owner
3 Euthanasia
4 Died
*/
-->