<html>
<head>
	<?php require "_php/z_datareader.php"; ?>
	<title>Tagasagot (<?php echo $current_answerer;?>)</title>
	<link rel="stylesheet" type="text/css" href="_css/commonstyle.css">
	<link rel="stylesheet" type="text/css" href="_css/fades.css">
	<?php
		// get the time and save it to Javascript variables
		echo "<script>";
		echo "var mins = $current_minutes;";
		echo "var secs = $current_seconds;";
		echo "</script>";
	?>
	<script>
		var tmrConvAppender;
		var myXmlHttp;
		var myXmlHttp_Typing;
		var tmrTypedRetriever;
		var tblConversation;
		var spanTimer;
		
		
		var myTimer;
		var myTimer_Running = false;
		var myXmlHttp_TimeRecorder;
		
		var gotIt = false;
		
		// initializations
		function initialize()
		{
			tblConversation = document.getElementById("tblConversation");
			myXmlHttp = (window.ActiveXOject) ? new ActiveXObject("Microsoft.HTTP") : new XMLHttpRequest();
			
			myXmlHttp_Typing = (window.ActiveXOject) ? new ActiveXObject("Microsoft.HTTP") : new XMLHttpRequest();
			myXmlHttp_Typing.onreadystatechange = handleServerResponse;
			
			myXmlHttp_AppendMsg = (window.ActiveXOject) ? new ActiveXObject("Microsoft.HTTP") : new XMLHttpRequest();
			myXmlHttp_AppendMsg.onreadystatechange = handleAppendingMessage;
			
			tmrTypedRetriever = setInterval(function(){retrievingTyped();},60);
			tmrConvAppender = setInterval(function(){appendingMsg();}, 150);
			
			appendInput();
			positionDivs();
			
			// initialize timer values
			spanTimer = document.getElementById("spanTimer");
			spanTimer.innerHTML = format2digits(mins) + ":" + format2digits(secs);
			
			myXmlHttp_TimeRecorder = (window.ActiveXOject) ? new ActiveXObject("Microsoft.HTTP") : new XMLHttpRequest();
			
			
		}
		
		function retrievingTyped()
		{
			myXmlHttp_Typing.open("GET", "_php/typedretriever.php?retrieving=true", true);
			myXmlHttp_Typing.send(null);
		}
		
		function handleServerResponse()
		{
			if(myXmlHttp_Typing.readyState==4)
			{
				if(myXmlHttp_Typing.status==200)
				{
					var message = myXmlHttp_Typing.responseText;
					document.getElementById("typingQuestion").value = message;
				}
			}
		}
		
		function respond(r)
		{
			myXmlHttp.open("GET", "_php/responsesetter.php?response=" + encodeURIComponent(r), true);
			myXmlHttp.send(null);
		}
		
		function appendInput()
		{
			var tr = document.createElement("tr");
			tr.id = "trMonitoring";
			var td = document.createElement("td");
			var input = document.createElement("input");
			input.type = "text";
			input.disabled=true;
			input.id = "typingQuestion";
			td.appendChild(input);
			tr.appendChild(td);
			tblConversation.appendChild(tr);
			window.scrollBy(0, tblConversation.offsetHeight);
		}
		
		function removeInput()
		{
			tblConversation.removeChild(document.getElementById("trMonitoring"));
		}
		
		function positionDivs()
		{
			var divHeader = document.getElementById("divHeader");
			var divBody = document.getElementById("divConversation");
			
			var divHeaderHeight = divHeader.offsetHeight;
			divBody.style.paddingTop = divHeaderHeight.toString() + "px";
		}
		
		// a function that formats time in 2 digits
		function format2digits(val)
		{
			return (val<10) ? "0" + val.toString() : val.toString(); 
		}
		
		// a function that displays the timer
		function displayTime()
		{
			if(mins == 0 && secs == 0)
			{
					clearInterval(myTimer);
					myTimer_Running = false;
			}
			else
			{
				secs -= 1;
				if(secs == -1)
				{
					secs = 59;
					mins -= 1;
				}
				// save minutes and seconds
				myXmlHttp_TimeRecorder.open("GET", "_php/savetime.php?mins=" + encodeURIComponent(mins.toString()) + "&secs=" + encodeURIComponent(secs.toString()), true);
				myXmlHttp_TimeRecorder.send(null);
				spanTimer.innerHTML = format2digits(mins) + ":" + format2digits(secs);
			}
		}
		
		document.onkeydown = function keyboardPressed(e)
		{
			if(gotIt == false)
			{
				e = e || window.event;
				var kcode = e.keyCode;
				if(kcode==79)
					respond('Oo');
				else if(kcode==72)
					respond('Hindi');
				else if(kcode==80)
					respond('Pwede');
			}
		};
	</script>
	<script src="_js/msgretriever.js"></script>
</head>

<body onload="initialize()">
	<div id="divHeader" class="header">
		<table cellspacing="0">
			<tr>
				<td style="width:20%; padding:0px; padding-left:3px; font-size:30px" align="left"><?php echo $current_asker;?></td>
				<td style="width:40%; padding:0px" align="center">"<span style="text-transform:uppercase" id="wordToGuess"><?php require "_php/getword.php";?></span>"</td>
				<td style="width:20%; padding:0px; font-size:30px" align="right">
				<?php echo $current_answerer;?> (<span style="padding:0px" id="spanTimer">00:00</span>)
				</td>
			</tr>
		</table>
	</div>
	<div id="divConversation">
		<table id="tblConversation" cellspacing="3" align="center"></table>
		<!--<table cellapacing="0" align="center"><tr><td align="center">
			<button id="btnYes" onclick="respond('Oo')">Oo</button>
			<button id="btnMaybe" onclick="respond('Pwede')">Pwede</button>
			<button id="btnNo" onclick="respond('Hindi')">Hindi</button>
		</td></tr></table>
		!-->
		
	</div>
</body>
<script>window.onresize=function(){positionDivs()};</script>
</html>