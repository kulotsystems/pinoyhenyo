<?php
	$responseText = "";
	if(isset($_GET['word']))
	{
		$rec_dir = "_records";
		if(file_exists($rec_dir)==false)
		{
			mkdir($rec_dir);
		}
		chdir($rec_dir);
		
		
		$word_file = "currentword.txt";
		$conv_file = "conversation.txt";
		$asker_file = "asker.txt";
		$answr_file = "answerer.txt";
		$mins_file = "minutes.txt";
		$secs_file = "seconds.txt";
		
		// get the previous word
		$prevWord = "";
		$fr = fopen($word_file, "r");
		while(!feof($fr))
		{
			$prevWord = $prevWord . trim(fgets($fr));
		}
		fclose($fr);
		
		// clear the conversation if the word was changed
		if(strtolower($prevWord) != strtolower($_GET['word']))
		{
			$fw = fopen($conv_file, "w");
			fwrite($fw, "");
			fclose($fw);
		}
		
		// record asker, answerer, and word
		
		$fw = fopen($word_file, "w");
		fwrite($fw, $_GET['word']);
		
		write_file($asker_file, $_GET['asker']);
		write_file($answr_file, $_GET['answerer']);
		write_file($word_file, $_GET['word']);
		write_file($mins_file, $_GET['minutes']);
		write_file($secs_file, $_GET['seconds']);
		fclose($fw);
		chdir("../");
		$responseText = $_GET['word'];
	}
	echo $responseText;
	
	
	// a function that writes $value to the $file
	function write_file($file, $value)
	{
		$fw = fopen($file, "w");
		fwrite($fw, $value);
		fclose($fw);
	}
?>