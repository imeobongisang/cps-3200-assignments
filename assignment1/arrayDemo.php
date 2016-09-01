<!DOCTYPE html>
<html>
<body>
  <$php
  $simpleArray = array();

  for($i = 0; $i < $_POST["arraysize"]; $i++) {
    $simpleArray[$i] = rand($_POST["minvalue"],$_POST["maxvalue"]);
    $calc1 = sqrt(abs($simpleArray[$i]));
    $calc2 = pow($simpleArray[$i],2);
    $calc3 = pow($simpleArray[$i],rand(0,5));
    $calc4 = 0;
    if($simpleArray[$i] > 0) {
      $calc4 = "postive";
    }
    else if($simpleArray[$i] < 0) {
      $calc4 = "negative";
    }
    else {
      $calc4 = "zero";
    }
    $calc5 = pi()*pow($simpleArray[$i],2);
    $calc6 = (4/3)*pi()*pow((abs($simpleArray[$i])/2),3);
  }
  $>
</body>
</html>
