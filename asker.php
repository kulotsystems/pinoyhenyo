<!DOCTYPE html>
<html>
<head>
	<?php require "_php/z_datareader.php"; ?>
	<title>Tagatanong (<?php echo $current_asker;?>)</title>
	<link rel="stylesheet" type="text/css" href="_css/commonstyle.css">
	<link rel="stylesheet" type="text/css" href="_css/fades.css">
	
	<script>
		var tmrConvAppender;
		var myXmlHttp;
		var txtQuestion;
		var tmrTypingSender;
		var prevQuestion = "";
		var tblConversation;
		var txtQuestion;
		var hiddenDiv;
		
		var myXmlHttp_Timer;
		var myXmlHttp_TimeSaver;
		
		var myXmlHttp_TimeRetriever;
		var mins=0;
		var secs=0;
		
		var myTimer;
		var myTimer_Running = true;
		
		var gotIt = false;
		
		
		
		function initialize()
		{
			txtQuestion = document.getElementById("txtQuestion");
			hiddenDiv = document.getElementById("hiddenDiv");
			myXmlHttp = (window.ActiveXObject) ? new ActiveXObject("Microsoft.HTTP") : new XMLHttpRequest();
			
			myXmlHttp_AppendMsg = (window.ActiveXOject) ? new ActiveXObject("Microsoft.HTTP") : new XMLHttpRequest();
			myXmlHttp_AppendMsg.onreadystatechange = handleAppendingMessage;
			
			tblConversation = document.getElementById("tblConversation");
			
			tmrTypingSender = setInterval(function(){sendingTyped();}, 150);
			tmrConvAppender = setInterval(function(){appendingMsg();}, 150);
			txtQuestion.select();
			positionDivs();
			
			myXmlHttp_TimeRetriever = (window.ActiveXOject) ? new ActiveXObject("Microsoft.HTTP") : new XMLHttpRequest();
			myXmlHttp_TimeRetriever.onreadystatechange = handleTimeResponse;
			myTimer = setInterval(function(){retrieveTime()}, 100);
		}
		
		// a function that sends request to retrieve time
		function retrieveTime()
		{
			myXmlHttp_TimeRetriever.open("GET", "_php/retrievetime.php?retrieving_time=true", true);
			myXmlHttp_TimeRetriever.send(null);
		}
		
		// a function that saves the retrieve time into javascript variable
		function handleTimeResponse()
		{
			if(myXmlHttp_TimeRetriever.readyState == 4)
			{
				if(myXmlHttp_TimeRetriever.status==200)
				{
					var message = myXmlHttp_TimeRetriever.responseText;
					var arrTime = message.split(":");
					if(arrTime.length == 2)
					{
						mins = parseInt(arrTime[0]);
						secs = parseInt(arrTime[1]);
						if(mins <= 0 && secs <= 0)
						{
							clearInterval(myTimer);
							txtQuestion.disabled = true;
							myXmlHttp.open("GET", "_php/questionsetter.php?question=" + encodeURIComponent("(*t~up*)"), true);
							myXmlHttp.send(null);
						}
						spanTimer.innerHTML = format2digits(mins) + ":" + format2digits(secs);
					}
					else
					{
						alert(message);
					}
				}
			}
		}
		
		// a function that formats time in 2 digits
		function format2digits(val)
		{
			return (val<10) ? "0" + val.toString() : val.toString(); 
		}
		
		
		function sendingTyped()
		{
			try
			{
				var q = txtQuestion.value.trim();
				if(q != prevQuestion)
				{
					myXmlHttp.open("GET", "_php/questionmonitoring.php?question=" + encodeURIComponent(q), true);
					myXmlHttp.send(null);
					prevQuestion = q;
				}
			}catch(e){}
		
		}
		
		document.onkeydown=function keyboardPressed(e)
		{
			e = e || e.event;
			var kcode = e.keyCode;
			if(kcode==13)
			{
				clearInterval(tmrTypingSender);
				prevQuestion = "";
				sendQuestion();
				tmrTypingSender = setInterval(function(){sendingTyped();}, 150);
				window.scrollBy(0, tblConversation.offsetHeight);
			}
		};
		
		function sendQuestion()
		{
			var q = txtQuestion.value.trim();
			if(q != "")
			{
				myXmlHttp.open("GET", "_php/questionsetter.php?question=" + encodeURIComponent(q), true);
				myXmlHttp.send(null);
			}
			txtQuestion.value = "";
			txtQuestion.select();
		}
		
		
		function appendInput()
		{
			var tr = document.createElement("tr");
			tr.id = "trMonitoring";
			var td = document.createElement("td");
			if(gotIt == true)
			{
				txtQuestion.disabled = true;
			}
			td.appendChild(txtQuestion);
			tr.appendChild(td);
			tblConversation.appendChild(tr);
			txtQuestion.focus();
			txtQuestion.select();
			window.scrollBy(0, tblConversation.offsetHeight);
		}
		
		function removeInput()
		{
			hiddenDiv.appendChild(txtQuestion);
			tblConversation.removeChild(document.getElementById("trMonitoring"));
		}
		
		function selectTextBox()
		{
			txtQuestion = document.getElementById("txtQuestion");
			if(txtQuestion.value.trim() == "")
			{
				txtQuestion.focus();
			}
		}
		
		function positionDivs()
		{
			var divHeader = document.getElementById("divHeader");
			var divBody = document.getElementById("divConversation");
			
			var divHeaderHeight = divHeader.offsetHeight;
			divBody.style.paddingTop = divHeaderHeight.toString() + "px";
		}
	</script>
	<script src="_js/msgretriever.js"></script>
</head>

<body onload="initialize()" onclick="selectTextBox()">
	<span id="wordToGuess" style="display:none"><?php require "_php/getword.php";?></span>
	<div id="divHeader" class="header" style="text-transform:none">
		<table cellspacing="0">
			<tr>
				<td style="width:20%; padding:0px; padding-left:3px; font-size:35px" align="left"><?php echo $current_asker;?></td>
				<td style="width:40%; padding:0px" align="center" id="spanTimer">00:00</td>
				<td style="width:20%; padding:0px; padding-left:3px; font-size:35px" align="right"><?php echo $current_answerer;?></td>
			</tr>
		</table>
	</div>
	<div id="divConversation">
		<table id="tblConversation" cellspacing="3" align="center"></table>
		<div align="center">
		<div id="hiddenDiv">
			<input type="text" id="txtQuestion">
		</div>
	</div>
</body>
<script>window.onresize=function(){positionDivs()};</script>
</html>