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
	//debug
	//print("<p>$aliceFullString</p>");
	
	//now that we have the full text as a string we need a
	//function that will match words from a string of the format
	// "any number of letters followed by ' or 's
	// must account for contractions
	// 'll 're 'm 't 'd 've 
	// any others? 'am
	// can we do OR with reg expressions?  or do we need to 
	// do several pattern matches
	// 1) get all words
	// 2) get all words with '
	// 3) get all words with 's 
	// 4) etc ...
	// *********hyphenated words are not handled yet**********
	// ****** Mr. and Jr. will match and keep Mr and Jr*******
	// ****** Proper name of a ship battlestar01
	// see page 533 for matching multiple copies of a pattern
	
	//matches need to be put into an array - which function does this?
	// we need to use preg_match_all() function
	
	//$matchCount = preg_match_all("/(?<![0-9a-zA-Z])[a-zA-Z]+(('ll)|('re)|('d)|('m)|('t)|('ve)|('s)|('S))?/", 
	//					$aliceFullString, $aliceMatchesArray);
	$matchCount = preg_match_all("/(?<![0-9a-zA-Z])[a-zA-Z]+('ll|'re|'d|'m|'t|'ve|'am|'s|'S)?/", 
						$aliceFullString, $aliceMatchesArray);
	//regular expression above will accept file names and extensions - 
	//we will accept this limitation - a real text for alice in wonderland
	//would not have file names 
						
	//debug
	//var_dump($matchCount);
	//var_dump($aliceMatchesArray);
	
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
	//use array $misspellings
	//use in_array function
	//Here we are going to flip the array and use isset() function instead
	//for hopefully faster results
	//from http://php.net/manual/en/function.in-array.php
	$flipped_haystack = array_flip($wordsArrayLower);
	for($i = 0; $i < sizeof($aliceMatchesLower); $i++) {
		$needle = $aliceMatchesLower[$i];
		if(!isset($flipped_haystack[$needle])) {
			$misspellings[$needle]++;
		}
	}
	
	/* //SUPER SLOW LOOP
	for($i = 0; $i< sizeof($aliceMatchesLower); $i++) {
		if(!in_array($aliceMatchesLower[$i], $wordsArrayLower, true )) {
			$misspellings2[$aliceMatchesLower[$i]]++;
		}
	}
	*/
	
	//debug
	//var_dump($misspellings);
	//var_dump($misspellings2);
	//To do in task 3 -- calculate frequencies of misspellings
	//write the data to a file.
	
	/*
	//testing of the in_array() function
	$a = array("cat", "dog", 0,1,2,3,4); //haystack
	$b = "kat"; //needle
	if(in_array($b, $a, true)) {
		print("found $b in haystack!");
	}
	*/
	
	//************************TASK 4****************************
	//search and replace.
	$misspellingsKeys = array_keys($misspellings);
	
	for ($i = 0; $i < sizeof($misspellingsKeys); $i++) {
		//take the first distance as the "smallest so far"
		$word = $misspellingsKeys[$i];
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
	//debug
	//var_dump($levenDistances);
	//TO DO:::
	//now must make replacements in the Alice text, and write it back to a file.
	
	
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
