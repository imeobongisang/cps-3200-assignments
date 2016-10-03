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


  fclose($aliceHandle);
//  print("<p>$wordsFullString</p>");


///////part2////


// the count of all words in alice in wonderland
$aliceWordsMatchCount = preg_match_all("/(?<![0-9a-zA-Z])[a-zA-Z]+('ll|'re|'d|'m|'t|'ve|'am|'s|'S)?/",
          $aliceFullStirng, $aliceMatchesArray);
          print("<p>$aliceWordsMatchCount</p>");

//set all the wordcs that are in the alice matches array to lowercase
$aliceToLowerCase = array_map('strtolower', $aliceMatchesArray);

//frequncy ouputfile
$frequencyHandle = fopen("frequency.txt",w);

for( $x = 0; $x < sizeof($aliceToLowerCase); $x++) {
  // read a word from the array into an associative array
  $aliceWordFrequency[$aliceToLowerCase[$x]] += 1;
}

//sort by key
ksort($aliceWordFrequency);
$myfile = fopen("frequency.txt", "w") or die("Unable to open file!");
$txt = "$aliceWordFrequency[$word]\n";
fwrite($myfile, $txt);
fclose($myfile);

//now put the percentages into a second array
while($key_value = each($aliceFrequency)) {
  $key = $key_value[0];
  //debug
  //echo $key;
  $aliceFrequencyPercentage[$key] = $aliceFrequency[$key] / sizeof($aliceMatchesLower);

fclose($frequencyHandle);


?>
</body>
</html>
