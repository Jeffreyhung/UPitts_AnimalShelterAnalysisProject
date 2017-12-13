# UPitts_DatabaseManagement
First Semester Database Management

**Project description:**

The animal shelter data set contains 26,729 records.  Each record represents the moment an animal departed the shelter and the condition they were in at the time of their departure.

Your main goal is to take this data set from first normal form and normalize it into third normal form resulting in many new relations. You will then load the relations and create views to group the data so that you can describe what is happening to the animals in the shelter more clearly.  You will share your work and findings with the class in your presentation&#39;s conclusion.

**Steps to follow:**

- Plan how to normalize the shelter data into new relations
- Design your relations
- Load data into new relations
- Enforce referential integrity
- Create views for analysis on what is happening to the animals
- Give conclusion on what insights you have discovered

**Hint** : think of a shelter departure record as an online order.  It will have a time stamp, customer id, and the status of the order.  That should be the center of the ER diagram. Very similar to the batting data you have worked with.  You will have to normalize other relations and create the referential integrity.  After the normalization process you should have many tables created.

[**Design Deliverables**]

ER diagram that shows all relations and how they are related

DDL code for all database objects

Brief data dictionary (just describe what the tables are and if any of your other objects/formulas need clarification)

[**Extraction Transformation and Loading Deliverables**]

Data loading strategy

 What did you do?  Briefly explain and diagram how you loaded your data into the DBMS  from the very first table to the last

[**Data Exploration Deliverables**]

Create views to group records by animal type and outcome types to understand and convey to me what is happening to dogs and cats in the shelter.  Are more dogs surviving than cats or vice versa?   Give me some details on what you see in the data.  _Be creative here.  Try to find some insights to share(aggregate the data;)__)._

[**Conclusion Deliverables**]

Briefly explain based off your analysis what would happen if you were an animal in the shelter what would your outcome be?

**[Overall Deliverables]****:**You will submit a report document and a Powerpoint presentation which you will use to present in class.


INFSCI 2710 Database Management
Final Project Report

Yu-Hsien Lee YUL198
Chi-Heng Hung CHH162
Chia-Jung Chang CHC276
Ming-Hsuan Chiang MIC128

Data Loading Strategy
Create table
Create animal_table for animal data
   with animalID, name, age
Create outcome_table for outcome data
   with departure time, outcome type
Create breed_table for breed data
   with animal type, breeds
Create color_table for color data
   with colors

Data Dictionary
animal_table-type
1 Dog
0 Cat

outcome_table-type
0 Adoption
1 Transfer
2 Return_to_Owner
3 Euthanasia
4 Died

outcome_age_view
0 Less than 1 Weeks
1 1 Week to 1 Month
2 1 Month to 6 Months
3 6 Months to 1 Years
4 1 Year to 2 Years
5 2 Years to 5 Years
6 5 Years to 10 Years
7 More than 10 Years

Load Data
Using python
	Split time from date
	Reconstruct date and time format
	Rename the outcomes
	Rename animal type
	Separate colors and breeds
	Reconstruct the age into days
INSERT INTO 
animal_table, outcome_table, color_table, breed_table


Conclusion: Stimulator
(Online Version: http://www.upitt-dbms.tk/ )

DDL - Tables
CREATE TABLE `animal_table` (
  `animalID` varchar(10) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `age` int(20) DEFAULT NULL,
  PRIMARY KEY (`animalID`)
);

CREATE TABLE `outcome_table` (
  `animalID` varchar(10) NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `type` int(10) DEFAULT NULL,
  PRIMARY KEY (`animalID`),
  CONSTRAINT `animalID` FOREIGN KEY (`animalID`) REFERENCES `animal_table` 
(`animalID`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE TABLE `breed_table` (
	`animalID` varchar(10) NOT NULL,
	`type` int(1) DEFAULT NULL,
	`breed1` varchar(40) DEFAULT NULL,
	`breed2` varchar(40) DEFAULT NULL,
	`breed3` varchar(40) DEFAULT NULL,
	PRIMARY KEY (`animalID`),
	CONSTRAINT `animal_ID` FOREIGN KEY (`animalID`) REFERENCES `animal_table` 
(`animalID`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

CREATE TABLE `color_table` (
	`animalID` varchar(10) NOT NULL,
	`color1` varchar(20) DEFAULT NULL,
	`color2` varchar(20) DEFAULT NULL,
	PRIMARY KEY (`animalID`),
	CONSTRAINT `animal-ID` FOREIGN KEY (`animalID`) REFERENCES `animal_table` 
(`animalID`) ON DELETE NO ACTION ON UPDATE NO ACTION
);


DDL - Views
CREATE VIEW num_of_dog_cat AS
SELECT 
	type,
    count(*) num
FROM breed_table
GROUP BY type;

CREATE VIEW overall_outcome AS
SELECT
	type,
    count(*) num
FROM outcome_table
GROUP By type;

CREATE VIEW dog_outcome AS
SELECT
	o.type type,
    count(*) num
FROM breed_table b 
LEFT OUTER JOIN outcome_table o ON b.animalID=o.animalID
WHERE b.type=1
GROUP By o.type;

CREATE VIEW cat_outcome AS
SELECT
	o.type type,
    count(*) num
FROM breed_table b 
LEFT OUTER JOIN outcome_table o ON b.animalID=o.animalID
WHERE b.type=0
GROUP By o.type;

CREATE VIEW outcome_age AS
SELECT 
	o.type,
	COUNT(CASE WHEN age < 8 THEN 1 END) AS `0`,
	COUNT(CASE WHEN age < 31 AND age > 7 THEN 1 END) AS `1`,
	COUNT(CASE WHEN age < 181 AND age > 30 THEN 1 END) AS `2`,
	COUNT(CASE WHEN age < 366 AND age > 180 THEN 1 END) AS `3`,
	COUNT(CASE WHEN age < 731 AND age > 365 THEN 1 END) AS `4`,
	COUNT(CASE WHEN age < 1826 AND age > 730 THEN 1 END) AS `5`,
	COUNT(CASE WHEN age < 3651 AND age > 1825 THEN 1 END) AS `6`,
	COUNT(CASE WHEN age > 3650 THEN 1 END) AS `7`
FROM animal_table a
LEFT OUTER JOIN outcome_table o ON a.animalID=o.animalID
GROUP BY o.type;

CREATE VIEW outcome_time AS
SELECT 
	type,
	COUNT(CASE WHEN HOUR(`time`) = 0 THEN 1 END) AS `0`,
	COUNT(CASE WHEN HOUR(`time`) = 1 THEN 1 END) AS `1`,
	COUNT(CASE WHEN HOUR(`time`) = 2 THEN 1 END) AS `2`,
	COUNT(CASE WHEN HOUR(`time`) = 3 THEN 1 END) AS `3`,
	COUNT(CASE WHEN HOUR(`time`) = 4 THEN 1 END) AS `4`,
	COUNT(CASE WHEN HOUR(`time`) = 5 THEN 1 END) AS `5`,
	COUNT(CASE WHEN HOUR(`time`) = 6 THEN 1 END) AS `6`,
	COUNT(CASE WHEN HOUR(`time`) = 7 THEN 1 END) AS `7`,
	COUNT(CASE WHEN HOUR(`time`) = 8 THEN 1 END) AS `8`,
	COUNT(CASE WHEN HOUR(`time`) = 9 THEN 1 END) AS `9`,
	COUNT(CASE WHEN HOUR(`time`) = 10 THEN 1 END) AS `10`,
	COUNT(CASE WHEN HOUR(`time`) = 11 THEN 1 END) AS `11`,
	COUNT(CASE WHEN HOUR(`time`) = 12 THEN 1 END) AS `12`,
	COUNT(CASE WHEN HOUR(`time`) = 13 THEN 1 END) AS `13`,
	COUNT(CASE WHEN HOUR(`time`) = 14 THEN 1 END) AS `14`,
	COUNT(CASE WHEN HOUR(`time`) = 15 THEN 1 END) AS `15`,
	COUNT(CASE WHEN HOUR(`time`) = 16 THEN 1 END) AS `16`,
	COUNT(CASE WHEN HOUR(`time`) = 17 THEN 1 END) AS `17`,
	COUNT(CASE WHEN HOUR(`time`) = 18 THEN 1 END) AS `18`,
	COUNT(CASE WHEN HOUR(`time`) = 19 THEN 1 END) AS `19`,
	COUNT(CASE WHEN HOUR(`time`) = 20 THEN 1 END) AS `20`,
	COUNT(CASE WHEN HOUR(`time`) = 21 THEN 1 END) AS `21`,
	COUNT(CASE WHEN HOUR(`time`) = 22 THEN 1 END) AS `22`,
	COUNT(CASE WHEN HOUR(`time`) = 23 THEN 1 END) AS `23`
FROM outcome_table
GROUP BY type;

CREATE VIEW outcome_age_total AS
SELECT
	COUNT(CASE WHEN age < 8 THEN 1 END) AS one,
	COUNT(CASE WHEN age < 31 AND age > 7 THEN 1 END) AS two,
	COUNT(CASE WHEN age < 181 AND age > 30 THEN 1 END) AS three,
	COUNT(CASE WHEN age < 366 AND age > 180 THEN 1 END) AS four,
	COUNT(CASE WHEN age < 731 AND age > 365 THEN 1 END) AS five,
	COUNT(CASE WHEN age < 1826 AND age > 730 THEN 1 END) AS six,
	COUNT(CASE WHEN age < 3651 AND age > 1825 THEN 1 END) AS seven,
	COUNT(CASE WHEN age > 3650 THEN 1 END) AS eight
FROM animal_table a
LEFT OUTER JOIN outcome_table o ON a.animalID=o.animalID;


CREATE VIEW have_name AS
SELECT 
	if(isnull(name),'NO','YES') name,
    count(if(isnull(name),'NULL','NOT NULL')) num
FROM animal_table
GROUP BY  if(isnull(name),'NULL','NOT NULL');

CREATE VIEW outcome_age_percentage AS
SELECT 
	o.type,
	COUNT(CASE WHEN age < 8 THEN 1 END)*100/total.one AS `0`,
	COUNT(CASE WHEN age < 31 AND age > 7 THEN 1 END)*100/total.two AS `1`,
	COUNT(CASE WHEN age < 181 AND age > 30 THEN 1 END)*100/total.three AS `2`,
	COUNT(CASE WHEN age < 366 AND age > 180 THEN 1 END)*100/total.four AS `3`,
	COUNT(CASE WHEN age < 731 AND age > 365 THEN 1 END)*100/total.five AS `4`,
	COUNT(CASE WHEN age < 1826 AND age > 730 THEN 1 END)*100/total.six AS `5`,
	COUNT(CASE WHEN age < 3651 AND age > 1825 THEN 1 END)*100/total.seven AS 
`6`,
	COUNT(CASE WHEN age > 3650 THEN 1 END)*100/total.eight AS `7`
FROM 
	outcome_age_total as total,
	animal_table a
LEFT OUTER JOIN outcome_table o ON a.animalID=o.animalID
GROUP BY o.type;

CREATE VIEW outcome_age_dog_total AS
SELECT
	COUNT(CASE WHEN age < 8 THEN 1 END) AS one,
	COUNT(CASE WHEN age < 31 AND age > 7 THEN 1 END) AS two,
	COUNT(CASE WHEN age < 181 AND age > 30 THEN 1 END) AS three,
	COUNT(CASE WHEN age < 366 AND age > 180 THEN 1 END) AS four,
	COUNT(CASE WHEN age < 731 AND age > 365 THEN 1 END) AS five,
	COUNT(CASE WHEN age < 1826 AND age > 730 THEN 1 END) AS six,
	COUNT(CASE WHEN age < 3651 AND age > 1825 THEN 1 END) AS seven,
	COUNT(CASE WHEN age > 3650 THEN 1 END) AS eight
FROM animal_table a
LEFT OUTER JOIN breed_table b ON a.animalID=b.animalID
LEFT OUTER JOIN outcome_table o ON b.animalID=o.animalID
WHERE b.type=1;

CREATE VIEW outcome_age_dog_percentage AS
SELECT 
	o.type,
	COUNT(CASE WHEN age < 8 THEN 1 END)*100/total.one AS `0`,
	COUNT(CASE WHEN age < 31 AND age > 7 THEN 1 END)*100/total.two AS `1`,
	COUNT(CASE WHEN age < 181 AND age > 30 THEN 1 END)*100/total.three AS `2`,
	COUNT(CASE WHEN age < 366 AND age > 180 THEN 1 END)*100/total.four AS `3`,
	COUNT(CASE WHEN age < 731 AND age > 365 THEN 1 END)*100/total.five AS `4`,
	COUNT(CASE WHEN age < 1826 AND age > 730 THEN 1 END)*100/total.six AS `5`,
	COUNT(CASE WHEN age < 3651 AND age > 1825 THEN 1 END)*100/total.seven AS 
`6`,
	COUNT(CASE WHEN age > 3650 THEN 1 END)*100/total.eight AS `7`
FROM 
	outcome_age_dog_total as total,
	animal_table a
LEFT OUTER JOIN breed_table b ON a.animalID=b.animalID
LEFT OUTER JOIN outcome_table o ON b.animalID=o.animalID
WHERE b.type=1
GROUP BY o.type;

CREATE VIEW outcome_month_cat AS
SELECT
	o.type,
	COUNT(CASE WHEN MONTH(`date`) = 1 THEN 1 END) AS `1`,
	COUNT(CASE WHEN MONTH(`date`) = 2 THEN 1 END) AS `2`,
	COUNT(CASE WHEN MONTH(`date`) = 3 THEN 1 END) AS `3`,
	COUNT(CASE WHEN MONTH(`date`) = 4 THEN 1 END) AS `4`,
	COUNT(CASE WHEN MONTH(`date`) = 5 THEN 1 END) AS `5`,
	COUNT(CASE WHEN MONTH(`date`) = 6 THEN 1 END) AS `6`,
	COUNT(CASE WHEN MONTH(`date`) = 7 THEN 1 END) AS `7`,
	COUNT(CASE WHEN MONTH(`date`) = 8 THEN 1 END) AS `8`,
	COUNT(CASE WHEN MONTH(`date`) = 9 THEN 1 END) AS `9`,
	COUNT(CASE WHEN MONTH(`date`) = 10 THEN 1 END) AS `10`,
	COUNT(CASE WHEN MONTH(`date`) = 11 THEN 1 END) AS `11`,
	COUNT(CASE WHEN MONTH(`date`) = 12 THEN 1 END) AS `12`
FROM outcome_table o
LEFT OUTER JOIN breed_table b ON o.animalID=b.animalID
WHERE b.type=0
GROUP BY o.type;

CREATE VIEW outcome_age_cat_percentage AS
SELECT 
	o.type,
	COUNT(CASE WHEN age < 8 THEN 1 END)*100/total.one AS `0`,
	COUNT(CASE WHEN age < 31 AND age > 7 THEN 1 END)*100/total.two AS `1`,
	COUNT(CASE WHEN age < 181 AND age > 30 THEN 1 END)*100/total.three AS `2`,
	COUNT(CASE WHEN age < 366 AND age > 180 THEN 1 END)*100/total.four AS `3`,
	COUNT(CASE WHEN age < 731 AND age > 365 THEN 1 END)*100/total.five AS `4`,
	COUNT(CASE WHEN age < 1826 AND age > 730 THEN 1 END)*100/total.six AS `5`,
	COUNT(CASE WHEN age < 3651 AND age > 1825 THEN 1 END)*100/total.seven AS 
`6`,
	COUNT(CASE WHEN age > 3650 THEN 1 END)*100/total.eight AS `7`
FROM 
	outcome_age_cat_total as total,
	animal_table a
LEFT OUTER JOIN breed_table b ON a.animalID=b.animalID
LEFT OUTER JOIN outcome_table o ON b.animalID=o.animalID
WHERE b.type=0
GROUP BY o.type;

CREATE VIEW outcome_month AS
SELECT
	type,
	COUNT(CASE WHEN MONTH(`date`) = 1 THEN 1 END) AS `1`,
	COUNT(CASE WHEN MONTH(`date`) = 2 THEN 1 END) AS `2`,
	COUNT(CASE WHEN MONTH(`date`) = 3 THEN 1 END) AS `3`,
	COUNT(CASE WHEN MONTH(`date`) = 4 THEN 1 END) AS `4`,
	COUNT(CASE WHEN MONTH(`date`) = 5 THEN 1 END) AS `5`,
	COUNT(CASE WHEN MONTH(`date`) = 6 THEN 1 END) AS `6`,
	COUNT(CASE WHEN MONTH(`date`) = 7 THEN 1 END) AS `7`,
	COUNT(CASE WHEN MONTH(`date`) = 8 THEN 1 END) AS `8`,
	COUNT(CASE WHEN MONTH(`date`) = 9 THEN 1 END) AS `9`,
	COUNT(CASE WHEN MONTH(`date`) = 10 THEN 1 END) AS `10`,
	COUNT(CASE WHEN MONTH(`date`) = 11 THEN 1 END) AS `11`,
	COUNT(CASE WHEN MONTH(`date`) = 12 THEN 1 END) AS `12`
FROM outcome_table
GROUP BY type;
CREATE VIEW outcome_month_dog AS
SELECT
	o.type,
	COUNT(CASE WHEN MONTH(`date`) = 1 THEN 1 END) AS `1`,
	COUNT(CASE WHEN MONTH(`date`) = 2 THEN 1 END) AS `2`,
	COUNT(CASE WHEN MONTH(`date`) = 3 THEN 1 END) AS `3`,
	COUNT(CASE WHEN MONTH(`date`) = 4 THEN 1 END) AS `4`,
	COUNT(CASE WHEN MONTH(`date`) = 5 THEN 1 END) AS `5`,
	COUNT(CASE WHEN MONTH(`date`) = 6 THEN 1 END) AS `6`,
	COUNT(CASE WHEN MONTH(`date`) = 7 THEN 1 END) AS `7`,
	COUNT(CASE WHEN MONTH(`date`) = 8 THEN 1 END) AS `8`,
	COUNT(CASE WHEN MONTH(`date`) = 9 THEN 1 END) AS `9`,
	COUNT(CASE WHEN MONTH(`date`) = 10 THEN 1 END) AS `10`,
	COUNT(CASE WHEN MONTH(`date`) = 11 THEN 1 END) AS `11`,
	COUNT(CASE WHEN MONTH(`date`) = 12 THEN 1 END) AS `12`
FROM outcome_table o
LEFT OUTER JOIN breed_table b ON o.animalID=b.animalID
WHERE b.type=1
GROUP BY o.type;

CREATE VIEW outcome_age_cat_total AS
SELECT
	COUNT(CASE WHEN age < 8 THEN 1 END) AS one,
	COUNT(CASE WHEN age < 31 AND age > 7 THEN 1 END) AS two,
	COUNT(CASE WHEN age < 181 AND age > 30 THEN 1 END) AS three,
	COUNT(CASE WHEN age < 366 AND age > 180 THEN 1 END) AS four,
	COUNT(CASE WHEN age < 731 AND age > 365 THEN 1 END) AS five,
	COUNT(CASE WHEN age < 1826 AND age > 730 THEN 1 END) AS six,
	COUNT(CASE WHEN age < 3651 AND age > 1825 THEN 1 END) AS seven,
	COUNT(CASE WHEN age > 3650 THEN 1 END) AS eight
FROM animal_table a
LEFT OUTER JOIN breed_table b ON a.animalID=b.animalID
LEFT OUTER JOIN outcome_table o ON b.animalID=o.animalID
WHERE b.type=0;

CREATE TABLE total AS
SELECT 
	a.animalID AS animalID,
    a.name AS name,
    a.age AS age,
    b.type AS type,
    o.type AS outcome,
    o.date AS date,
    o.time AS time,
    c.color1 AS color1,
    c.color2 AS color2,
    b.breed1 AS breed1,
    b.breed2 AS breed2,
    b.breed3 AS breed3
FROM
	animal_table AS a 
LEFT OUTER JOIN outcome_table AS o ON o.animalID=a.animalID
LEFT OUTER JOIN color_table AS c ON c.animalID=a.animalID
LEFT OUTER JOIN breed_table AS b ON b.animalID=a.animalID;



Python Data Load Code
import csv
import MySQLdb

db = MySQLdb.connect("localhost", "root", "root", "dbms_final")
cursor = db.cursor()

with open('animal_shelter_data.csv') as f: 
    content = f.readlines()
content = [x.strip() for x in content]

datestr = str
i = 0
for x in content:
    lines = x.split(',')
    lines_new = [None] * 9
    breed_split = [None] * 2
    color_split = [None] * 2
    lines_new[0] = lines[0]
    lines_new[1] = lines[1]
    time_split = lines[2].split(' ')
    date_split = time_split[0].split("/")
    datestr = ''
    datestr = date_split[2] + '-' + date_split[0] + '-' + date_split[1]
    lines_new[2] = datestr
    lines_new[3] = time_split[1]
    if lines[3] == 'Adoption':
        lines_new[4] = 0
    elif lines[3] == 'Transfer':
        lines_new[4] = 1
    elif lines[3] == 'Return_to_owner':
        lines_new[4] = 2
    elif lines[3] == 'Euthanasia':
        lines_new[4] = 3
    elif lines[3] == 'Died':
        lines_new[4] = 4
    if lines[4] == 'Dog':
        lines_new[5] = 1
    elif lines[4] == 'Cat':
        lines_new[5] = 0
    age_split = lines[5].split(' ')
    if age_split[0] == '':
        lines_new[6] = ''
    elif (age_split[1] == 'year') or (age_split[1] == 'years'):
        lines_new[6] = int(age_split[0]) * 365
    elif (age_split[1] == 'month') or (age_split[1] == 'months'):
        lines_new[6] = int(age_split[0]) * 30
    elif (age_split[1] == 'week') or (age_split[1] == 'weeks'):
        lines_new[6] = int(age_split[0]) * 7
    else:
        lines_new[6] = int(age_split[0])
    breed_split = lines[6].split('/')
    j = 0
    for z in breed_split:
        breed_split[j] = breed_split[j].replace(" ", "_")
        breed_split[j] = breed_split[j].replace(".", "")
        j += 1
    lines_new[7] = breed_split
    j = 0
    color_split = lines[7].split('/')
    j=0
    for z in color_split:
        color_split[j] = color_split[j].replace(" ","_")
        j += 1
    lines_new[8] = color_split

    breed_split.sort()
    color_split.sort()

    cursor.execute("INSERT INTO animal_table (animalID, name, age) VALUES (%s, %s, %s)",(lines_new[0], 
lines_new[1], lines_new[6]))
    cursor.execute("INSERT INTO outcome_table (animalID, date, time, type) VALUES (%s, %s, %s, %s)", 
(lines_new[0], lines_new[2], lines_new[3], lines_new[4]))

    if len(breed_split) == 2:
        cursor.execute("INSERT INTO breed_table (animalID, type, breed1, breed2) VALUES (%s, %s, %s, 
%s)", (lines_new[0], lines_new[5], breed_split[0], breed_split[1]))
    elif len(breed_split) == 3:
        cursor.execute("INSERT INTO breed_table (animalID, type, breed1, breed2, breed3) VALUES (%s, %s, 
%s, %s, %s)", (lines_new[0], lines_new[5], breed_split[0], breed_split[1], breed_split[2]))
    else:
        cursor.execute("INSERT INTO breed_table (animalID, type, breed1) VALUES (%s, %s, %s)", 
(lines_new[0], lines_new[5], breed_split[0]))

    if len(color_split) > 1:
        cursor.execute("INSERT INTO color_table (animalID, color1, color2) VALUES (%s, %s, %s)", 
(lines_new[0], color_split[0], color_split[1]))
    else:
        cursor.execute("INSERT INTO color_table (animalID, color1) VALUES (%s, %s)", (lines_new[0], 
color_split[0]))

db.commit()
cursor.close()
db.close()
?
Stimulator PHP Code
$conn = mysqli_connect("localhost", "root", "root","dbms_final");
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
		$bsql = "AND (breed1 LIKE '%".$value."%' OR breed2 LIKE '%".$value."%' OR breed3 LIKE 
'%".$value."%') ";
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
