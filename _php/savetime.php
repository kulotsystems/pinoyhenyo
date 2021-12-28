<?php
	$responseText = "";
	if(isset($_GET['mins']))
	{
		$mins_file = "minutes.txt";
		$secs_file = "seconds.txt";
		chdir("_records");
		write_file($mins_file, $_GET['mins']);
		write_file($secs_file, $_GET['secs']);
		chdir("../");
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