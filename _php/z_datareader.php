<?php
	$current_asker = read_file("asker.txt");
	$current_answerer = read_file("answerer.txt");
	$current_word = read_file("currentword.txt");
	$current_minutes = read_file("minutes.txt");
	$current_seconds = read_file("seconds.txt");
		
	// a function that returns the $content of a $file
	function read_file($file)
	{
		$content = "";
		$file = "_php/_records/" . $file;
		if(file_exists($file))
		{
			$fr = fopen($file, "r");
			while(!feof($fr))
			{
				$line = trim(fgets($fr));
				$content = $content . $line;
			}
			fclose($fr);
		}
		return $content;
	}
?>