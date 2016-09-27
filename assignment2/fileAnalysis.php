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
      $aliceFullStirng.= $aliceTemp;
    }
  }

  fclose($aliceHandle);
//  print("<p>$aliceFullStirng</p>");


  //file handle for words text
  $wordsHandle = fopen("words.txt", "r");

  //reading in the string per line for words.txt

  while(!feof($wordsHandle)) {
    $wordsTemp = fgets($wordsHandle);

    if(!feof($wordsHandle)) {
      $wordsFullString.=$wordsTemp;
    }
  }

  $frequencyHandle = fopen("frequency.txt",w);

  $record1 = "hi";
  $record2 = "no";
  $record3 = "really";
  
  fclose($aliceHanle);
  print("<p>$wordsFullString</p>");

?>
</body>
</html>
