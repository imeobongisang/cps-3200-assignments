<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css-files/arrayDemo.css">
</head>
<body>
  <div id="back"><a href="http://localhost:8888/assignment1/arrayDemo.html">Back to form</a></div>

  <?php
  if(($_POST["arraysize"]) < 1 ) {
    print "Please enter a valid array size.";
    return ;
  }
  if(($_POST["arraysize"] > 200)) {
    print "Please a smaller array size.";
    return ;
  }
  if($_POST["minvalue"] >$_POST["maxvalue"]) {
    print "Error. Minimum value must be larger than maximum value.";
    return ;
  }
  if(!is_numeric($_POST["arraysize"])|| !is_numeric($_POST["minvalue"]) || !is_numeric($_POST["maxvalue"])) {
    print "Error. Invalid form data. Please enter integer data into every field.";
    return;
  }
  if(empty($_POST["arraysize"]) || empty($_POST["minvalue"]) || empty($_POST["maxvalue"])) {
    print "Error. Invalid form data. Please enter integer data into every field.";
    return ;
  }



  $simpleArray = array();
  print "<div id=\"table\">";
  print "<table style=\"width:100;\">
  <th>Column #</th>
  <th>Random #</th>
  <th><math><msqrt><mi><span id=\"absvalue\" style =\"border-left: 2px solid black; border-right: 2px solid black \">x</span></mi></msqrt></math></th>
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
    print "<td style=\"background-color:rgb(189, 197, 255);min-width:20px;\"> $cNum.</td>";
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
