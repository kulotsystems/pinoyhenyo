<?php
	$responseText="";
	if(isset($_GET['question']))
	{
		$rec_dir="_records";
		if(file_exists($rec_dir)==false)
		{
			mkdir($rec_dir);
		}
		chdir($rec_dir);
		$q_file = "currentquestion.txt";
		$fw = fopen($q_file, "w");
		fwrite($fw, $_GET['question']);
		fclose($fw);
		chdir("../");
		$responseText = $_GET['question'];
	}
	echo $responseText;
?>