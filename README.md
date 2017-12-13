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


#

#

#

#

#

# INFSCI 2710 Database Management

# Final Project Report

#

#

#

#

#

#

#

# Yu-Hsien Lee YUL198

# Chi-Heng Hung CHH162

# Chia-Jung Chang CHC276

# Ming-Hsuan Chiang MIC128

#

**Data Loading Strategy**

# Create table

# Create animal\_table for animal data

#    with animalID, name, age

# Create outcome\_table for outcome data

#    with departure time, outcome type

# Create breed\_table for breed data

#    with animal type, breeds

# Create color\_table for color data

#    with colors

# **Data Dictionary**

|
# animal\_table-type

# 1 Dog

# 0 Cat

# outcome\_table-type

# 0 Adoption

# 1 Transfer

# 2 Return\_to\_Owner

# 3 Euthanasia

# 4 Died
  |
# outcome\_age\_view

# 0 Less than 1 Weeks

# 1 1 Week to 1 Month

# 2 1 Month to 6 Months

# 3 6 Months to 1 Years

# 4 1 Year to 2 Years

# 5 2 Years to 5 Years

# 6 5 Years to 10 Years

# 7 More than 10 Years
  |
| --- | --- |

# **Load Data**

# Using python

-
# Split time from date
-
# Reconstruct date and time format
-
# Rename the outcomes
-
# Rename animal type
-
# Separate colors and breeds
-
# Reconstruct the age into days

# INSERT INTO

# animal\_table, outcome\_table, color\_table, breed\_table


# **\*\*DDL Shown in the end of the report\*\***


# **Conclusion: Stimulator**

# (Online Version: [http://www.upitt-dbms.tk/](http://www.upitt-dbms.tk/) )

# **DDL - Tables**

# CREATE TABLE `animal_table` (

#   `animalID` varchar(10) NOT NULL,

#   `name` varchar(20) DEFAULT NULL,

#   `age` int(20) DEFAULT NULL,

#   PRIMARY KEY (`animalID`)

# );

# CREATE TABLE `outcome_table` (

#   `animalID` varchar(10) NOT NULL,

#   `date` date DEFAULT NULL,

#   `time` time DEFAULT NULL,

#   `type` int(10) DEFAULT NULL,

#   PRIMARY KEY (`animalID`),

#   CONSTRAINT `animalID` FOREIGN KEY (`animalID`) REFERENCES `animal_table` (`animalID`) ON DELETE NO ACTION ON UPDATE NO ACTION

# );

# CREATE TABLE `breed_table` (

#         `animalID` varchar(10) NOT NULL,

#         `type` int(1) DEFAULT NULL,

#         `breed1` varchar(40) DEFAULT NULL,

#         `breed2` varchar(40) DEFAULT NULL,

#         `breed3` varchar(40) DEFAULT NULL,

#         PRIMARY KEY (`animalID`),

#         CONSTRAINT `animal_ID` FOREIGN KEY (`animalID`) REFERENCES `animal_table` (`animalID`) ON DELETE NO ACTION ON UPDATE NO ACTION

# );

# CREATE TABLE `color_table` (

#         `animalID` varchar(10) NOT NULL,

#         `color1` varchar(20) DEFAULT NULL,

#         `color2` varchar(20) DEFAULT NULL,

#         PRIMARY KEY (`animalID`),

#         CONSTRAINT `animal-ID` FOREIGN KEY (`animalID`) REFERENCES `animal_table` (`animalID`) ON DELETE NO ACTION ON UPDATE NO ACTION

# );

# **DDL - Views**

# CREATE VIEW num\_of\_dog\_cat AS

# SELECT

#         type,

#     count(\*) num

# FROM breed\_table

# GROUP BY type;

# CREATE VIEW overall\_outcome AS

# SELECT

#         type,

#     count(\*) num

# FROM outcome\_table

# GROUP By type;

# CREATE VIEW dog\_outcome AS

# SELECT

#         o.type type,

#     count(\*) num

# FROM breed\_table b

# LEFT OUTER JOIN outcome\_table o ON b.animalID=o.animalID

# WHERE b.type=1

# GROUP By o.type;

# CREATE VIEW cat\_outcome AS

# SELECT

#         o.type type,

#     count(\*) num

# FROM breed\_table b

# LEFT OUTER JOIN outcome\_table o ON b.animalID=o.animalID

# WHERE b.type=0

# GROUP By o.type;

# CREATE VIEW outcome\_age AS

# SELECT

#         o.type,

#         COUNT(CASE WHEN age &lt; 8 THEN 1 END) AS `0`,

#         COUNT(CASE WHEN age &lt; 31 AND age &gt; 7 THEN 1 END) AS `1`,

#         COUNT(CASE WHEN age &lt; 181 AND age &gt; 30 THEN 1 END) AS `2`,

#         COUNT(CASE WHEN age &lt; 366 AND age &gt; 180 THEN 1 END) AS `3`,

#         COUNT(CASE WHEN age &lt; 731 AND age &gt; 365 THEN 1 END) AS `4`,

#         COUNT(CASE WHEN age &lt; 1826 AND age &gt; 730 THEN 1 END) AS `5`,

#         COUNT(CASE WHEN age &lt; 3651 AND age &gt; 1825 THEN 1 END) AS `6`,

#         COUNT(CASE WHEN age &gt; 3650 THEN 1 END) AS `7`

# FROM animal\_table a

# LEFT OUTER JOIN outcome\_table o ON a.animalID=o.animalID

# GROUP BY o.type;

# CREATE VIEW outcome\_time AS

# SELECT

#         type,

#         COUNT(CASE WHEN HOUR(`time`) = 0 THEN 1 END) AS `0`,

#         COUNT(CASE WHEN HOUR(`time`) = 1 THEN 1 END) AS `1`,

#         COUNT(CASE WHEN HOUR(`time`) = 2 THEN 1 END) AS `2`,

#         COUNT(CASE WHEN HOUR(`time`) = 3 THEN 1 END) AS `3`,

#         COUNT(CASE WHEN HOUR(`time`) = 4 THEN 1 END) AS `4`,

#         COUNT(CASE WHEN HOUR(`time`) = 5 THEN 1 END) AS `5`,

#         COUNT(CASE WHEN HOUR(`time`) = 6 THEN 1 END) AS `6`,

#         COUNT(CASE WHEN HOUR(`time`) = 7 THEN 1 END) AS `7`,

#         COUNT(CASE WHEN HOUR(`time`) = 8 THEN 1 END) AS `8`,

#         COUNT(CASE WHEN HOUR(`time`) = 9 THEN 1 END) AS `9`,

#         COUNT(CASE WHEN HOUR(`time`) = 10 THEN 1 END) AS `10`,

#         COUNT(CASE WHEN HOUR(`time`) = 11 THEN 1 END) AS `11`,

#         COUNT(CASE WHEN HOUR(`time`) = 12 THEN 1 END) AS `12`,

#         COUNT(CASE WHEN HOUR(`time`) = 13 THEN 1 END) AS `13`,

#         COUNT(CASE WHEN HOUR(`time`) = 14 THEN 1 END) AS `14`,

#         COUNT(CASE WHEN HOUR(`time`) = 15 THEN 1 END) AS `15`,

#         COUNT(CASE WHEN HOUR(`time`) = 16 THEN 1 END) AS `16`,

#         COUNT(CASE WHEN HOUR(`time`) = 17 THEN 1 END) AS `17`,

#         COUNT(CASE WHEN HOUR(`time`) = 18 THEN 1 END) AS `18`,

#         COUNT(CASE WHEN HOUR(`time`) = 19 THEN 1 END) AS `19`,

#         COUNT(CASE WHEN HOUR(`time`) = 20 THEN 1 END) AS `20`,

#         COUNT(CASE WHEN HOUR(`time`) = 21 THEN 1 END) AS `21`,

#         COUNT(CASE WHEN HOUR(`time`) = 22 THEN 1 END) AS `22`,

#         COUNT(CASE WHEN HOUR(`time`) = 23 THEN 1 END) AS `23`

# FROM outcome\_table

# GROUP BY type;

# CREATE VIEW outcome\_age\_total AS

# SELECT

#         COUNT(CASE WHEN age &lt; 8 THEN 1 END) AS one,

#         COUNT(CASE WHEN age &lt; 31 AND age &gt; 7 THEN 1 END) AS two,

#         COUNT(CASE WHEN age &lt; 181 AND age &gt; 30 THEN 1 END) AS three,

#         COUNT(CASE WHEN age &lt; 366 AND age &gt; 180 THEN 1 END) AS four,

#         COUNT(CASE WHEN age &lt; 731 AND age &gt; 365 THEN 1 END) AS five,

#         COUNT(CASE WHEN age &lt; 1826 AND age &gt; 730 THEN 1 END) AS six,

#         COUNT(CASE WHEN age &lt; 3651 AND age &gt; 1825 THEN 1 END) AS seven,

#         COUNT(CASE WHEN age &gt; 3650 THEN 1 END) AS eight

# FROM animal\_table a

# LEFT OUTER JOIN outcome\_table o ON a.animalID=o.animalID;

# CREATE VIEW have\_name AS

# SELECT

#         if(isnull(name),&#39;NO&#39;,&#39;YES&#39;) name,

#     count(if(isnull(name),&#39;NULL&#39;,&#39;NOT NULL&#39;)) num

# FROM animal\_table

# GROUP BY  if(isnull(name),&#39;NULL&#39;,&#39;NOT NULL&#39;);

# CREATE VIEW outcome\_age\_percentage AS

# SELECT

#         o.type,

#         COUNT(CASE WHEN age &lt; 8 THEN 1 END)\*100/total.one AS `0`,

#         COUNT(CASE WHEN age &lt; 31 AND age &gt; 7 THEN 1 END)\*100/total.two AS `1`,

#         COUNT(CASE WHEN age &lt; 181 AND age &gt; 30 THEN 1 END)\*100/total.three AS `2`,

#         COUNT(CASE WHEN age &lt; 366 AND age &gt; 180 THEN 1 END)\*100/total.four AS `3`,

#         COUNT(CASE WHEN age &lt; 731 AND age &gt; 365 THEN 1 END)\*100/total.five AS `4`,

#         COUNT(CASE WHEN age &lt; 1826 AND age &gt; 730 THEN 1 END)\*100/total.six AS `5`,

#         COUNT(CASE WHEN age &lt; 3651 AND age &gt; 1825 THEN 1 END)\*100/total.seven AS `6`,

#         COUNT(CASE WHEN age &gt; 3650 THEN 1 END)\*100/total.eight AS `7`

# FROM

#         outcome\_age\_total as total,

#         animal\_table a

# LEFT OUTER JOIN outcome\_table o ON a.animalID=o.animalID

# GROUP BY o.type;

# CREATE VIEW outcome\_age\_dog\_total AS

# SELECT

#         COUNT(CASE WHEN age &lt; 8 THEN 1 END) AS one,

#         COUNT(CASE WHEN age &lt; 31 AND age &gt; 7 THEN 1 END) AS two,

#         COUNT(CASE WHEN age &lt; 181 AND age &gt; 30 THEN 1 END) AS three,

#         COUNT(CASE WHEN age &lt; 366 AND age &gt; 180 THEN 1 END) AS four,

#         COUNT(CASE WHEN age &lt; 731 AND age &gt; 365 THEN 1 END) AS five,

#         COUNT(CASE WHEN age &lt; 1826 AND age &gt; 730 THEN 1 END) AS six,

#         COUNT(CASE WHEN age &lt; 3651 AND age &gt; 1825 THEN 1 END) AS seven,

#         COUNT(CASE WHEN age &gt; 3650 THEN 1 END) AS eight

# FROM animal\_table a

# LEFT OUTER JOIN breed\_table b ON a.animalID=b.animalID

# LEFT OUTER JOIN outcome\_table o ON b.animalID=o.animalID

# WHERE b.type=1;

# CREATE VIEW outcome\_age\_dog\_percentage AS

# SELECT

#         o.type,

#         COUNT(CASE WHEN age &lt; 8 THEN 1 END)\*100/total.one AS `0`,

#         COUNT(CASE WHEN age &lt; 31 AND age &gt; 7 THEN 1 END)\*100/total.two AS `1`,

#         COUNT(CASE WHEN age &lt; 181 AND age &gt; 30 THEN 1 END)\*100/total.three AS `2`,

#         COUNT(CASE WHEN age &lt; 366 AND age &gt; 180 THEN 1 END)\*100/total.four AS `3`,

#         COUNT(CASE WHEN age &lt; 731 AND age &gt; 365 THEN 1 END)\*100/total.five AS `4`,

#         COUNT(CASE WHEN age &lt; 1826 AND age &gt; 730 THEN 1 END)\*100/total.six AS `5`,

#         COUNT(CASE WHEN age &lt; 3651 AND age &gt; 1825 THEN 1 END)\*100/total.seven AS `6`,

#         COUNT(CASE WHEN age &gt; 3650 THEN 1 END)\*100/total.eight AS `7`

# FROM

#         outcome\_age\_dog\_total as total,

#         animal\_table a

# LEFT OUTER JOIN breed\_table b ON a.animalID=b.animalID

# LEFT OUTER JOIN outcome\_table o ON b.animalID=o.animalID

# WHERE b.type=1

# GROUP BY o.type;



# CREATE VIEW outcome\_month\_cat AS

# SELECT

#         o.type,

#         COUNT(CASE WHEN MONTH(`date`) = 1 THEN 1 END) AS `1`,

#         COUNT(CASE WHEN MONTH(`date`) = 2 THEN 1 END) AS `2`,

#         COUNT(CASE WHEN MONTH(`date`) = 3 THEN 1 END) AS `3`,

#         COUNT(CASE WHEN MONTH(`date`) = 4 THEN 1 END) AS `4`,

#         COUNT(CASE WHEN MONTH(`date`) = 5 THEN 1 END) AS `5`,

#         COUNT(CASE WHEN MONTH(`date`) = 6 THEN 1 END) AS `6`,

#         COUNT(CASE WHEN MONTH(`date`) = 7 THEN 1 END) AS `7`,

#         COUNT(CASE WHEN MONTH(`date`) = 8 THEN 1 END) AS `8`,

#         COUNT(CASE WHEN MONTH(`date`) = 9 THEN 1 END) AS `9`,

#         COUNT(CASE WHEN MONTH(`date`) = 10 THEN 1 END) AS `10`,

#         COUNT(CASE WHEN MONTH(`date`) = 11 THEN 1 END) AS `11`,

#         COUNT(CASE WHEN MONTH(`date`) = 12 THEN 1 END) AS `12`

# FROM outcome\_table o

# LEFT OUTER JOIN breed\_table b ON o.animalID=b.animalID

# WHERE b.type=0

# GROUP BY o.type;

# CREATE VIEW outcome\_age\_cat\_percentage AS

# SELECT

#         o.type,

#         COUNT(CASE WHEN age &lt; 8 THEN 1 END)\*100/total.one AS `0`,

#         COUNT(CASE WHEN age &lt; 31 AND age &gt; 7 THEN 1 END)\*100/total.two AS `1`,

#         COUNT(CASE WHEN age &lt; 181 AND age &gt; 30 THEN 1 END)\*100/total.three AS `2`,

#         COUNT(CASE WHEN age &lt; 366 AND age &gt; 180 THEN 1 END)\*100/total.four AS `3`,

#         COUNT(CASE WHEN age &lt; 731 AND age &gt; 365 THEN 1 END)\*100/total.five AS `4`,

#         COUNT(CASE WHEN age &lt; 1826 AND age &gt; 730 THEN 1 END)\*100/total.six AS `5`,

#         COUNT(CASE WHEN age &lt; 3651 AND age &gt; 1825 THEN 1 END)\*100/total.seven AS `6`,

#         COUNT(CASE WHEN age &gt; 3650 THEN 1 END)\*100/total.eight AS `7`

# FROM

#         outcome\_age\_cat\_total as total,

#         animal\_table a

# LEFT OUTER JOIN breed\_table b ON a.animalID=b.animalID

# LEFT OUTER JOIN outcome\_table o ON b.animalID=o.animalID

# WHERE b.type=0

# GROUP BY o.type;

# CREATE VIEW outcome\_month AS

# SELECT

#         type,

#         COUNT(CASE WHEN MONTH(`date`) = 1 THEN 1 END) AS `1`,

#         COUNT(CASE WHEN MONTH(`date`) = 2 THEN 1 END) AS `2`,

#         COUNT(CASE WHEN MONTH(`date`) = 3 THEN 1 END) AS `3`,

#         COUNT(CASE WHEN MONTH(`date`) = 4 THEN 1 END) AS `4`,

#         COUNT(CASE WHEN MONTH(`date`) = 5 THEN 1 END) AS `5`,

#         COUNT(CASE WHEN MONTH(`date`) = 6 THEN 1 END) AS `6`,

#         COUNT(CASE WHEN MONTH(`date`) = 7 THEN 1 END) AS `7`,

#         COUNT(CASE WHEN MONTH(`date`) = 8 THEN 1 END) AS `8`,

#         COUNT(CASE WHEN MONTH(`date`) = 9 THEN 1 END) AS `9`,

#         COUNT(CASE WHEN MONTH(`date`) = 10 THEN 1 END) AS `10`,

#         COUNT(CASE WHEN MONTH(`date`) = 11 THEN 1 END) AS `11`,

#         COUNT(CASE WHEN MONTH(`date`) = 12 THEN 1 END) AS `12`

# FROM outcome\_table

# GROUP BY type;

# CREATE VIEW outcome\_month\_dog AS

# SELECT

#         o.type,

#         COUNT(CASE WHEN MONTH(`date`) = 1 THEN 1 END) AS `1`,

#         COUNT(CASE WHEN MONTH(`date`) = 2 THEN 1 END) AS `2`,

#         COUNT(CASE WHEN MONTH(`date`) = 3 THEN 1 END) AS `3`,

#         COUNT(CASE WHEN MONTH(`date`) = 4 THEN 1 END) AS `4`,

#         COUNT(CASE WHEN MONTH(`date`) = 5 THEN 1 END) AS `5`,

#         COUNT(CASE WHEN MONTH(`date`) = 6 THEN 1 END) AS `6`,

#         COUNT(CASE WHEN MONTH(`date`) = 7 THEN 1 END) AS `7`,

#         COUNT(CASE WHEN MONTH(`date`) = 8 THEN 1 END) AS `8`,

#         COUNT(CASE WHEN MONTH(`date`) = 9 THEN 1 END) AS `9`,

#         COUNT(CASE WHEN MONTH(`date`) = 10 THEN 1 END) AS `10`,

#         COUNT(CASE WHEN MONTH(`date`) = 11 THEN 1 END) AS `11`,

#         COUNT(CASE WHEN MONTH(`date`) = 12 THEN 1 END) AS `12`

# FROM outcome\_table o

# LEFT OUTER JOIN breed\_table b ON o.animalID=b.animalID

# WHERE b.type=1

# GROUP BY o.type;

# CREATE VIEW outcome\_age\_cat\_total AS

# SELECT

#         COUNT(CASE WHEN age &lt; 8 THEN 1 END) AS one,

#         COUNT(CASE WHEN age &lt; 31 AND age &gt; 7 THEN 1 END) AS two,

#         COUNT(CASE WHEN age &lt; 181 AND age &gt; 30 THEN 1 END) AS three,

#         COUNT(CASE WHEN age &lt; 366 AND age &gt; 180 THEN 1 END) AS four,

#         COUNT(CASE WHEN age &lt; 731 AND age &gt; 365 THEN 1 END) AS five,

#         COUNT(CASE WHEN age &lt; 1826 AND age &gt; 730 THEN 1 END) AS six,

#         COUNT(CASE WHEN age &lt; 3651 AND age &gt; 1825 THEN 1 END) AS seven,

#         COUNT(CASE WHEN age &gt; 3650 THEN 1 END) AS eight

# FROM animal\_table a

# LEFT OUTER JOIN breed\_table b ON a.animalID=b.animalID

# LEFT OUTER JOIN outcome\_table o ON b.animalID=o.animalID

# WHERE b.type=0;

# CREATE TABLE total AS

# SELECT

#         a.animalID AS animalID,

#     a.name AS name,

#     a.age AS age,

#     b.type AS type,

#     o.type AS outcome,

#     o.date AS date,

#     o.time AS time,

#     c.color1 AS color1,

#     c.color2 AS color2,

#     b.breed1 AS breed1,

#     b.breed2 AS breed2,

#     b.breed3 AS breed3

# FROM

#         animal\_table AS a

# LEFT OUTER JOIN outcome\_table AS o ON o.animalID=a.animalID

# LEFT OUTER JOIN color\_table AS c ON c.animalID=a.animalID

# LEFT OUTER JOIN breed\_table AS b ON b.animalID=a.animalID;

# **Python Data Load Code**

# import csv

# import MySQLdb

# db = MySQLdb.connect(&quot;localhost&quot;, &quot;root&quot;, &quot;root&quot;, &quot;dbms\_final&quot;)

# cursor = db.cursor()

# with open(&#39;animal\_shelter\_data.csv&#39;) as f:

#     content = f.readlines()

# content = [x.strip() for x in content]

# datestr = str

# i = 0

# for x in content:

#     lines = x.split(&#39;,&#39;)

#     lines\_new = [None] \* 9

#     breed\_split = [None] \* 2

#     color\_split = [None] \* 2

#     lines\_new[0] = lines[0]

#     lines\_new[1] = lines[1]

#     time\_split = lines[2].split(&#39; &#39;)

#     date\_split = time\_split[0].split(&quot;/&quot;)

#     datestr = &#39;&#39;

#     datestr = date\_split[2] + &#39;-&#39; + date\_split[0] + &#39;-&#39; + date\_split[1]

#     lines\_new[2] = datestr

#     lines\_new[3] = time\_split[1]

#     if lines[3] == &#39;Adoption&#39;:

#         lines\_new[4] = 0

#     elif lines[3] == &#39;Transfer&#39;:

#         lines\_new[4] = 1

#     elif lines[3] == &#39;Return\_to\_owner&#39;:

#         lines\_new[4] = 2

#     elif lines[3] == &#39;Euthanasia&#39;:

#         lines\_new[4] = 3

#     elif lines[3] == &#39;Died&#39;:

#         lines\_new[4] = 4

#     if lines[4] == &#39;Dog&#39;:

#         lines\_new[5] = 1

#     elif lines[4] == &#39;Cat&#39;:

#         lines\_new[5] = 0

#     age\_split = lines[5].split(&#39; &#39;)

#     if age\_split[0] == &#39;&#39;:

#         lines\_new[6] = &#39;&#39;

#     elif (age\_split[1] == &#39;year&#39;) or (age\_split[1] == &#39;years&#39;):

#         lines\_new[6] = int(age\_split[0]) \* 365

#     elif (age\_split[1] == &#39;month&#39;) or (age\_split[1] == &#39;months&#39;):

#         lines\_new[6] = int(age\_split[0]) \* 30

#     elif (age\_split[1] == &#39;week&#39;) or (age\_split[1] == &#39;weeks&#39;):

#         lines\_new[6] = int(age\_split[0]) \* 7

#     else:

#         lines\_new[6] = int(age\_split[0])

#     breed\_split = lines[6].split(&#39;/&#39;)

#     j = 0

#     for z in breed\_split:

#         breed\_split[j] = breed\_split[j].replace(&quot; &quot;, &quot;\_&quot;)

#         breed\_split[j] = breed\_split[j].replace(&quot;.&quot;, &quot;&quot;)

#         j += 1

#     lines\_new[7] = breed\_split

#     j = 0

#     color\_split = lines[7].split(&#39;/&#39;)

#     j=0

#     for z in color\_split:

#         color\_split[j] = color\_split[j].replace(&quot; &quot;,&quot;\_&quot;)

#         j += 1

#     lines\_new[8] = color\_split

#     breed\_split.sort()

#     color\_split.sort()

#     cursor.execute(&quot;INSERT INTO animal\_table (animalID, name, age) VALUES (%s, %s, %s)&quot;,(lines\_new[0], lines\_new[1], lines\_new[6]))

#     cursor.execute(&quot;INSERT INTO outcome\_table (animalID, date, time, type) VALUES (%s, %s, %s, %s)&quot;, (lines\_new[0], lines\_new[2], lines\_new[3], lines\_new[4]))

#     if len(breed\_split) == 2:

#         cursor.execute(&quot;INSERT INTO breed\_table (animalID, type, breed1, breed2) VALUES (%s, %s, %s, %s)&quot;, (lines\_new[0], lines\_new[5], breed\_split[0], breed\_split[1]))

#     elif len(breed\_split) == 3:

#         cursor.execute(&quot;INSERT INTO breed\_table (animalID, type, breed1, breed2, breed3) VALUES (%s, %s, %s, %s, %s)&quot;, (lines\_new[0], lines\_new[5], breed\_split[0], breed\_split[1], breed\_split[2]))

#     else:

#         cursor.execute(&quot;INSERT INTO breed\_table (animalID, type, breed1) VALUES (%s, %s, %s)&quot;, (lines\_new[0], lines\_new[5], breed\_split[0]))

#     if len(color\_split) &gt; 1:

#         cursor.execute(&quot;INSERT INTO color\_table (animalID, color1, color2) VALUES (%s, %s, %s)&quot;, (lines\_new[0], color\_split[0], color\_split[1]))

#     else:

#         cursor.execute(&quot;INSERT INTO color\_table (animalID, color1) VALUES (%s, %s)&quot;, (lines\_new[0], color\_split[0]))

# db.commit()

# cursor.close()

# db.close()

#

# **Stimulator PHP Code**

# $conn = mysqli\_connect(&quot;localhost&quot;, &quot;root&quot;, &quot;root&quot;,&quot;dbms\_final&quot;);

# if (!$conn) {

#         die(&quot;Connection failed: &quot; . mysqli\_connect\_error());

# }

# $type=&quot;&quot;; $age=&quot;&quot;; $color=&quot;&quot;; $breed=&quot;&quot;; $name=&quot;&quot;;

# $tsql=&quot;&quot;; $asql=&quot;&quot;; $csql=&quot;&quot;; $bsql=&quot;&quot;; $nsql=&quot;&quot;;

# if (empty($\_POST[&quot;type&quot;])) {

#         $tsql=&quot;&quot;;

# } else {

#         $type = test\_input($\_POST[&quot;type&quot;]);

#         $type\_num=$type[0] -1;

#         $tsql = &quot;AND type=&#39;&quot;.$type\_num.&quot;&#39; &quot;;

# }

# if (empty($\_POST[&quot;age&quot;])) {

#         $asql=&quot;&quot;;

# } else {

#         $age = test\_input($\_POST[&quot;age&quot;]);

#         $age\_num=$age[0];

#         switch($age\_num){

#                 case 1:

#                         $asql=&quot;AND age &lt; 8 &quot;;

#                         break;

#                 case 2:

#                         $asql=&quot;AND age &lt; 31 AND age &gt; 7 &quot;;

#                         break;

#                 case 3:

#                         $asql=&quot;AND age &lt; 181 AND age &gt; 30 &quot;;

#                         break;

#                 case 4:

#                         $asql=&quot;AND age &lt; 366 AND age &gt; 180 &quot;;

#                         break;

#                 case 5:

#                         $asql=&quot;AND age &lt; 731 AND age &gt; 365 &quot;;

#                         break;

#                 case 6:

#                         $asql=&quot;AND age &lt; 1826 AND age &gt; 730 &quot;;

#                         break;

#                 case 7:

#                         $asql=&quot;AND age &lt; 3651 AND age &gt; 1825 &quot;;

#                         break;

#                 case 8:

#                         $asql=&quot;AND age &gt; 3650 &quot;;

#                         break;

#         }

# }

# if (empty($\_POST[&quot;color&quot;])) {

#         $csql=&quot;&quot;;

# } else {

#         $color = test\_input($\_POST[&quot;color&quot;]);

#         foreach( $color as $value){

#                 $csql .= &quot;AND (color1 LIKE &#39;%&quot;.$value.&quot;%&#39; OR color2 LIKE &#39;%&quot;.$value.&quot;%&#39;) &quot;;

#         }

# }

# if (empty($\_POST[&quot;breed&quot;])) {

#         $bsql=&quot;&quot;;

# } else {

#         $breed = test\_input($\_POST[&quot;breed&quot;]);

#         foreach($breed as $value){

#                 $bsql = &quot;AND (breed1 LIKE &#39;%&quot;.$value.&quot;%&#39; OR breed2 LIKE &#39;%&quot;.$value.&quot;%&#39; OR breed3 LIKE &#39;%&quot;.$value.&quot;%&#39;) &quot;;

#         }

# }

# if (empty($\_POST[&quot;name&quot;])) {

#         $nsql=&quot;&quot;;

# } else {

#         $name = test\_input($\_POST[&quot;name&quot;]);

#         foreach($name as $value){

#                 $nsql = &quot;AND name LIKE &#39;%&quot;.$value.&quot;%&#39; &quot;;

#         }

# }

# function test\_input($data) {

#         $data = trim($data);

#         $data = stripslashes($data);

#         $data = htmlspecialchars($data);

#         $data = str\_replace(&quot;-&quot;, &#39; &#39;, $data);

#         $data = str\_replace(&quot;\_&quot;, &#39; &#39;, $data);

#         $data = preg\_replace(&#39;/[^A-Za-z0-9\-]/&#39;, &#39; &#39;, $data);

#         $data\_split = explode(&quot; &quot;, $data);

#         return $data\_split;

# }

# $query = &quot;SELECT outcome, count(\*) AS num FROM total WHERE animalID != &#39;NULL&#39; &quot;;

# $query2 = &quot;GROUP BY outcome &quot;;

# $sqlString=$query.$tsql.$asql.$csql.$bsql.$nsql.$query2;

# $result = mysqli\_query($conn,$sqlString);

# $outcome\_data = array(0,0,0,0,0);

# $i=0;

# while($row = mysqli\_fetch\_assoc($result)) {

#

#         $outcome\_data[(int)$row[&quot;outcome&quot;]] = (int)$row[&quot;num&quot;];

#         $i += 1;

# }

# if (mysqli\_num\_rows($result)==0){

#         echo &quot;&lt;br/&gt;&lt;br/&gt;&lt;center&gt;&lt;h1&gt;No Similar Result Found&lt;/h1&gt;&lt;/center&gt;&quot;;

#         echo &#39;&lt;script type=&quot;text/javascript&quot;&gt; window.stop(); &lt;/script&gt;&#39;;

# }else {

#         ;

# }
