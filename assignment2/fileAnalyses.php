<html>

<head><title>Alice Analysis</title>
</head><body bgcolor="silver">
<body>
<pre>
<font size="+1">
<?php
	//file handle for alice text
	$aliceHandle = fopen("alice30.txt","r");
	//read in to a string the text for alice30
	while (!feof($aliceHandle)) {
		//foef works oddly so you have to do this:

		$aliceTemp = fgets($aliceHandle);
		if(!feof($aliceHandle)) {
			$aliceFullString .= $aliceTemp;
		}
	}
	fclose($aliceHandle); //close file

	$matchCount = preg_match_all("/(?<![0-9a-zA-Z])[a-zA-Z]+('ll|'re|'d|'m|'t|'ve|'am|'s|'S)?/",
						$aliceFullString, $aliceMatchesArray);

	//because sub matches are also returned I needed to do this
	$aliceMatchesArray = $aliceMatchesArray[0];
	//var_dump($aliceMatchesArray);

	//read in the dictionary file
	$wordsHandle = fopen("words.txt","r");

	while (!feof($wordsHandle)) {
		//foef works oddly so you have to do this:

		$wordTemp = fgets($wordsHandle);
		if(!feof($wordsHandle)) {
			$wordsFullString .= $wordTemp;
		}
	}
	fclose($wordsHandle); //close file
	//var_dump($wordsFullString); //debug
	//explode dictionary string into words
	$wordsArray = explode("\n", $wordsFullString);

	//var_dump($wordsArray); //debug
	//convert it all to lower case
	//from http://stackoverflow.com/questions/11008443/how-to-convert-array-values-to-lowercase-in-php
	$aliceMatchesLower = array_map('strtolower', $aliceMatchesArray);


	//**************TASK 2***************** WORD FREQUENCY*****************************
	for($i = 0; $i < sizeof($aliceMatchesLower); $i++) {
		//get the word
		$word = $aliceMatchesLower[$i];
		$aliceFrequency[$word]++; //increment the location
	}
	//sort by key
	ksort($aliceFrequency);
	$myfile = fopen("frequency.txt", "w") or die("Unable to open file!");
	$txt = "$aliceFrequency[$word]\n";
	fwrite($myfile, $txt);
	fclose($myfile);

	//now put the percentages into a second array
	while($key_value = each($aliceFrequency)) {
		$key = $key_value[0];
		//debug
		//echo $key;
		$aliceFrequencyPercentage[$key] = $aliceFrequency[$key] / sizeof($aliceMatchesLower);
	}
	reset($aliceFrequency);
	//debug
	//var_dump($aliceFrequencyPercentage);
	//NEXT must write the data from $aliceFrequency and $aliceFrequencyPercentage to
	//a file in the format a:32:.xxxxxx%
	$freqFile =fopen("frequency.txt","w");

	while($key_value = each($aliceFrequency)) {
		$key_value2 = each($aliceFrequencyPercentage);
		$field1 = $key_value[0];
		$field2 = $key_value[1];
		$field3 = number_format($key_value2[1], 6)*100 ."%";

		fputs($freqFile, "$field1:$field2:$field3\n");
	}
	fclose($freqFile);
	reset($aliceFrequency);
	reset($aliceFrequencyPercentage);

	//*********TASK 3*************** Find mispelled words **********
	//need a count of the times a word is mispelled
	//going to convert dictionary to lower case (all the entries start in upper case)
	$wordsArrayLower = array_map('strtolower', $wordsArray);

	//Here we are going to flip the array and use isset() function instead
	$flipped_haystack = array_flip($wordsArrayLower);
	for($i = 0; $i < sizeof($aliceMatchesLower); $i++) {
		//the word in alice
		$needle = $aliceMatchesLower[$i];
		//if the word in alice is not in the dictionary
		if(!isset($flipped_haystack[$needle])) {
			//add number of misspellings for that word
			$misspellings[$needle]++;
		}
	}

//	now put the percentages into a second array
	while($key_value3 = each($misspellings)) {
		$key2 = $key_value3[0];

		$misspellingsPercentage[$key2] = $misspellings[$key2] / sizeof($aliceMatchesLower);
	}
	reset($misspellings);
	reset($aliceMatchesLower);

	$misspellingsFiles =fopen("misspellings.txt","w");

	while($key_value3 = each($misspellings)) {
		$key_value4 = each($misspellingsPercentage);
		$field4 = $key_value3[0];
		$field5 = $key_value3[1];
		$field6 = number_format($key_value4[1], 6)*100 ."%";

		fputs($misspellingsFiles, "$field4:$field5:$field6\n");
	}
	fclose($misspellingsFiles);
	reset($misspellings);
	reset($misspellingsPercentage);
	reset($aliceMatchesLower);
	reset($wordsArrayLower);

	//************************TASK 4****************************
	//search and replace.

	for ($i = 0; $i < sizeof($aliceMatchesLower); $i++) {
		//take the first distance as the "smallest so far"
		$word = $aliceMatchesLower[$i];
		$levenDistances[$word] = //$word is the misspelled word, $wordsArrayLower[0] -> dictionary word
					array($wordsArrayLower[0], levenshtein($word, $wordsArrayLower[0]));
		for($j = 1; $j < sizeof($wordsArrayLower); $j++) {
			//if the new distance is smaller
			$word2 = $wordsArrayLower[$j]; //grab next candidate word from dictionary
			$newDist = levenshtein($word, $word2); //misspelled word and dictionary word
			if( $newDist < $levenDistances[$word][1]) {
				//replace it in the array
				$levenDistances[$word] = array($word2, $newDist);
			}
		}
	}
	print($levenDistances);

	//****************************TASK 5
	//The keys from the $aliceFrequency array will be the words
	//we want to use for the next task
	$aliceUniqueWords = array_keys($aliceFrequency);

	//first generate the keys
	for($i = 0; $i < sizeof($aliceUniqueWords); $i++) {
		$word = $aliceUniqueWords[$i];
		$soundexKeys[$word] = soundex($word);
		$metaphoneKeys[$word] = metaphone($word);
	}
	//debug
	//var_dump($soundexKeys);
	//var_dump($metaphoneKeys);
	//now we generate a 2D array where each key (word) will map to
	//a 1D array of words that "sound like" the key


	//going to make a copy of the keys and values

	$soundexWords = array_keys($soundexKeys);
	$soundexKeyValues = array_values($soundexKeys);
	while($key_value = each($soundexKeys)) {
		$word = $key_value[0];
		$soundexKey = $key_value[1];
		for($j = 0; $j < sizeof($soundexWords); $j++) {
			if($soundexKey === $soundexKeyValues[$j]) { //match!!
				$soundexSoundsLike[$word][] = $soundexWords[$j]; //add an element to matches
			}
		}

	}
	//debug
	//var_dump($soundexSoundsLike);



	/*

	$aliceArray = explode(" ", $aliceFullString);
	for($i = 0; $i < sizeof($aliceArray); $i++ ) {
		print("<p>$aliceArray[$i]</p>");
	}
	*/
	/*
	$string1 = "Once upon a time, there were three little pigs...";
	$string2 = "Once upon a time, there were three bears...";

	print("<p></p>");
	print "similar_text()<br>";
	print "First string: $string1\n<br>";
	print "Second string: $string2\n<br>";
	$number=similar_text("$string1", "$string2", $percent);
	print "There are $number of the same characters in the two strings.\n";
	echo "The strings are similar by " . number_format($percent, 0). "%.<br>";

	print("<p></p>");
	print "Levenshtein Distance<br>";
	$string1 = "I attended a funeral.";
	$string2 = "He attended a fun rally.";
	print "First string: $string1\n<br>";
	print "Second string: $string2\n<br>";
	$distance=levenshtein("$string1", "$string2");
	print "It would take $distance changes to transform
					string1 into string2.<br>";
	*/
?>
</font>
</pre>
</body>
</html>
