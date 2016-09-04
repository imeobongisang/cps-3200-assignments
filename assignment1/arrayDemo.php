<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css-files/arrayDemo.css">
  <title>Array Calculation</title>
  <meta charset="utf-8">
</head>
<body>

<div id="back" onclick="location.href='arrayDemo.html'">Back To Form</div>

  <?php

  function isempty($var) {
    if($var === NULL ||$var === undefined || $var === "" || $var === array()||$var===FALSE)
    return true;
  }

  if(isempty($_POST["arraysize"]) || isempty($_POST["minvalue"]) || isempty($_POST["maxvalue"])) {
    print "Error. Invalid form data1. Please enter integer data into every field.";
    return false;
  }

  if(!is_numeric($_POST["arraysize"])|| !is_numeric($_POST["minvalue"]) || !is_numeric($_POST["maxvalue"])) {
    print "Error. Invalid form data. Please enter integer data into every field.";
    return false;
  }
  if($_POST["arraysize"] < 1 ) {
    print "Please enter a valid array size.";
    return false;
  }
  if($_POST["arraysize"] > 10000) {
    print "Please enter a smaller array size.";
    return false;
  }
  if($_POST["minvalue"] >$_POST["maxvalue"]) {
    print "Error. Minimum value must be larger than maximum value.";
    return false;
  }





  $simpleArray = array();
  print "<h1>Array Table</h1>";
  print "<div id=\"table\">";
  print "<table style=\"width:100;\">
  <th>Column #</th>
  <th>Random #</th>
  <th>&radic;<span id=\"absvalue\" style =\"border-left: 2px solid; border-right: 2px solid; text-decoration: overline; font-weight:normal; \">x</span></th>
  <th>x<sup>2</sup></th>
  <th>x<sup>n</sup></th>
  <th>Positive/Negative</th>
  <th>&pi;x<sup>2</sup></th>
  <th><sup>4</sup>&frasl;<sub>3</sub>&pi;x<sup>3</sup></th>

  ";
  for($i = 0; $i < $_POST["arraysize"]; $i++) {
    $simpleArray[$i] = rand($_POST["minvalue"],$_POST["maxvalue"]);
    $calc1 = sqrt(abs($simpleArray[$i]));
    $calc2 = pow($simpleArray[$i],2);
    $calc3 = pow($simpleArray[$i],rand(0,5));
    $calc4 = 0;
    if($simpleArray[$i] > 0) {
      $calc4 = "postive";
    }
     if($simpleArray[$i] < 0) {
      $calc4 = "negative";
    }
    if($simpleArray[$i] == 0) {
      $calc4 = "zero";
    }
    $calc5 = pi()*pow($simpleArray[$i],2);
    $calc6 = (4/3)*pi()*pow((abs($simpleArray[$i])/2),3);

    $cNum = $i+1;
    print "<tr>";
    print "<td id=\"tNum\"> $cNum.</td>";
    print "<td>"; print$simpleArray[$i]; print "</td>";
    print "<td>";  print number_format($calc1, 3); print "</td>";
    print "<td> $calc2</td>" ;
    print "<td> $calc3</td>" ;
    print "<td> $calc4</td>" ;
    print "<td>";  print number_format($calc5, 3); print "</td>";
    print "<td>";  print number_format($calc6, 3); print "</td>";
    print "</tr>";
   }
   print "</div>"
?>

</body>
</html>
