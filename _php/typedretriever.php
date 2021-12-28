<?php
	$responseText="";
	if(isset($_GET['retrieving']))
	{
		$rec_dir="_records";
		if(file_exists($rec_dir))
		{
			chdir($rec_dir);
			$q_file = "currentquestion.txt";
			if(file_exists($q_file))
			{
				$fr = fopen($q_file, "r");
				while(!feof($fr))
				{
					$line=fgets($fr);
					$responseText = $responseText . $line;
				}
				fclose($fr);
			}
			chdir("../");
		}
	}
	echo $responseText;
?>