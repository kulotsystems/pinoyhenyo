<?php
	$type = "question";
	$sender = "q";
	require "z_convappender.php";
	
	// clear the current question
	$fw = fopen("_records/currentquestion.txt", "w");
	fwrite($fw, " ");
	fclose($fw);
?>