<?php
	$responseText="";
	if(isset($_GET[$type]))
	{
		$rec_dir = "_records";
		if(file_exists($rec_dir)==false)
		{
			mkdir($rec_dir);
		}
		
		chdir($rec_dir);
		$conv_file="conversation.txt";
		if(file_exists($conv_file)==false)
		{
			$fw = fopen($conv_file, "w");
			fclose($fw);
		}
		
		$fa = fopen($conv_file, "a");
		fwrite($fa, "$sender |*| " . $_GET[$type] . " |*| \n");
		fclose($fa);
		chdir("../");
	}
	echo $responseText;
?>