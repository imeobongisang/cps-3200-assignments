<!DOCTYPE html>
<html>
<body>
  <$php
  $simpleArray = array();

  for($i = 0; $i < $_POST["arraysize"]; $i++) {
    $simpleArray[$i] = rand($_POST["minvalue"],$_POST["maxvalue"])
  }
  $>
</body>
</html>
