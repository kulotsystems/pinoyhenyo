<html>
<head>
	<?php require "_php/z_datareader.php"; ?>
	<title>Set Game</title>
	<link rel="stylesheet" type="text/css" href="_css/commonstyle.css">
	<link rel="stylesheet" type="text/css" href="_css/numberinput.css">
	<style>
		td{
			color:#888;
		}
		
		#txtAsker, #txtAnswerer, #txtWord, #txtMinutes, #txtSeconds{
			border-bottom:2px solid #cccccc;
			padding:3px;
		}
		
		@keyframes prompt-save{
			0%{color:green;}
			100%{color:transparent;}
		}
		@-moz-keyframes prompt-save{
			0%{color:green;}
			100%{color:transparent;}
		}
		@-webkit-keyframes prompt-save{
			0%{color:green;}
			100%{color:transparent;}
		}
		@-o-keyframes prompt-save{
			0%{color:green;}
			100%{color:transparent;}
		}
		
		.hide-save-prompt
		{
			visibility:hidden;
		}
		
		.show-save-prompt
		{
			display:block;
			animation: prompt-save 3.1s;
			-moz-animation: prompt-save 3.1s;
			-webkit-animation: prompt-save 3.1s;
			-o-animation: prompt-save 3.1s;
		}
	</style>
	<script>
		var myXmlHttp;
		var txtWord, txtAsker, txtAnswerer, txtMinutes, txtSeconds, spanChangesSaved;
		var word = "";
		var asker = "";
		var answerer = "";
		
		var tmrTimeOut;
		
		// variable initializations
		function initialize()
		{
			txtAsker = document.getElementById("txtAsker");
			txtAnswerer = document.getElementById("txtAnswerer");
			txtWord = document.getElementById("txtWord");
			txtMinutes = document.getElementById("txtMinutes");
			txtSeconds = document.getElementById("txtSeconds");
			spanChangesSaved = document.getElementById("spanChangesSaved");
			txtWord.select();
			myXmlHttp = (window.ActiveXObject) ? new ActiveXObject("Microsoft.HTTP") : new XMLHttpRequest();
			myXmlHttp.onreadystatechange = handleServerResponse;
		}
		
		// a function that receives response from the server
		function handleServerResponse()
		{
			if(myXmlHttp.readyState==4)
			{
				if(myXmlHttp.status==200)
				{
					var message = myXmlHttp.responseText;
					if(message==word)
					{
						// prompt save
						spanChangesSaved.className="show-save-prompt";
						tmrTimeOut = setTimeout(function(){spanChangesSaved.className="hide-save-prompt";},3000);
					}
				}
			}	
		}
		
		// a function that handles the submission of data to the server
		function submitData()
		{
			word = txtWord.value.trim();
			var asker = txtAsker.value.trim();
			var answerer = txtAnswerer.value.trim();
			var minutes = txtMinutes.value.trim();
			var seconds = txtSeconds.value.trim();
			if(word != "")
			{
				myXmlHttp.open("GET", "_php/gamesetter.php?word=" + encodeURIComponent(word) + "&asker=" + encodeURIComponent(asker) + "&answerer=" + encodeURIComponent(answerer) + "&minutes=" + encodeURIComponent(minutes) + "&seconds=" + encodeURIComponent(seconds), true);
				myXmlHttp.send(null);
			}
			else
			{
				txtWord.value="";
				txtWord.select();
			}
		}
		
		// a function that invokes the submitData function when ENTER key is pressed
		document.onkeydown = function keyboardPressed(e)
		{
			e = e || window.event;
			var kcode = e.keyCode;
			if(kcode==13)
			{
				clearTimeout(tmrTimeOut);
				submitData();
			}
		};
	</script>
</head>

<body onload="initialize()">
	<table style="width:100%;height:100%"><tr><td align="center">
		<table cellspacing="0">
			<tr>
				<td>Asker</td>
				<td><input type="text" id="txtAsker" value="<?php echo $current_asker;?>"></td>
			</tr>
			<tr>
				<td>Answerer</td>
				<td><input type="text" id="txtAnswerer" value="<?php echo $current_answerer;?>"></td>
			</tr>
			<tr>
				<td>Word</td>
				<td><input type="text" id="txtWord" value="<?php echo $current_word;?>"></td>
			</tr>
			<tr>
				<td>Minutes</td>
				<td><input type="number" id="txtMinutes" value="<?php echo $current_minutes;?>"></td>
			</tr>
			<tr>
				<td>Seconds</td>
				<td><input type="number" id="txtSeconds" value="<?php echo $current_seconds;?>"></td>
			</tr>
			<tr>
				<td colspan="2" align="right"><span id="spanChangesSaved" class="hide-save-prompt">Saved!</span></td>
			</tr>
		</table>
		<button onclick="submitData()">OK</button>
	</td></tr></table>
</body>
</html>