<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
  //file handle for alice text
  $aliceHandle = fopen ("alice30.txt", "r");
  //read in to a string the text for alice30

  while(!feof($aliceHandle)) {
    $aliceTemp = fgets($aliceHandle);

    if(!feof($aliceHandle)) {
      $aliceFullStirng.= aliceTemp;
    }
  }

  fclose($aliceHandle);
  print("<p>$aliceFullStirng</p>");
?>
</body>
</html>
