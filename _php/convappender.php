<?php
	$responseText="";
	if(isset($_GET['prevline']))
	{
		$prev_line = intval($_GET['prevline']);
		$rec_dir = "_records";
		if(file_exists($rec_dir)==false)
		{
			mkdir($rec_dir);
		}
		
		chdir($rec_dir);
		$conv_file = "conversation.txt";
		if(file_exists($conv_file))
		{
			$line_number = 0;
			$fr = fopen($conv_file, "r");
			while(!feof($fr))
			{
				$line = trim(fgets($fr));
				$line_number += 1;
				if($line_number > $prev_line && strlen($line)>5)
				{
					$responseText = $responseText . $line_number . " |*| " . $line . " " . " |=*=| ";
					$prev_line = $line_number;
				}
			}
			fclose($fr);
		}
		chdir("../");
	}
	echo $responseText;
?>