<?php
	chdir("_php");
	chdir("_records");
	$rec_file = "currentword.txt";
	if(file_exists($rec_file))
	{
		$word = "";
		$fr = fopen($rec_file, "r");
		while(!feof($fr))
		{
			$word = $word . trim(fgets($fr));
		}
		fclose($fr);
		echo $word;
	}
	chdir("../../");
?>