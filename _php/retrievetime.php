<?php
	$responseText = "";
	if(isset($_GET['retrieving_time']))
	{
		$mins_file = "minutes.txt";
		$secs_file = "seconds.txt";
		chdir("_records");
		
		$minutes = read_file($mins_file);
		$seconds = read_file($secs_file);
		$responseText = $minutes . ":" . $seconds;
		read_file($mins_file);
		read_file($secs_file);
		
		chdir("../");
	}
	echo $responseText;
	

	// a function that returns the $content of a $file
	function read_file($file)
	{
		$content = "";
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