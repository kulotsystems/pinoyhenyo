var myXmlHttp_AppendMsg;
var convLineNum = 0;
var timeIsUp = false;

function handleAppendingMessage()
{
	if(myXmlHttp_AppendMsg.readyState==4)
	{
		if(myXmlHttp_AppendMsg.status==200)
		{
			var message = myXmlHttp_AppendMsg.responseText;
			if(message!="")
			{
				var arr_lines = message.split(" |=*=| ");
				var totalLines = arr_lines.length;
				var wordToGuess = document.getElementById("wordToGuess");
				for(var i=0; i<(totalLines-1); i++)
				{
					var arr_line = arr_lines[i].split(" |*| ");
					var lineNum = arr_line[0];
					var lineSender = arr_line[1];
					var lineMsg = arr_line[2];
					convLineNum = parseInt(lineNum);
				
					try{removeInput();}catch(e){};
				
					var tr = document.createElement("tr");
					var td = document.createElement("td");
					td.align = (lineSender=="q") ? "left" : "right";
					
					if(timeIsUp == false)
					{
						if(lineMsg == "(*t~up*)")
						{
							lineMsg = '"' + wordToGuess.innerHTML.toUpperCase() + '"';
							timeIsUp = true;
							td.className = "timesup";
						}
					}
					
					else
					{
						if(lineMsg == "(*t~up*)")
						{
							continue;
						}
					}
					td.innerHTML = lineMsg;
					
					if(lineSender=="a")
					{
						if(lineMsg.toLowerCase()=="yes" || lineMsg.toLowerCase()=="oo")
						{
							// blue
							td.className="fade-Oo";
						}
						else if(lineMsg.toLowerCase()=="no" || lineMsg.toLowerCase()=="hindi")
						{
							// red
							td.className="fade-Hindi";
						}
						else
						{
							// green
							td.className="fade-Pwede";
						}
					}
					try
					{
						if(wordToGuess.innerHTML.toLowerCase() == removeQuestionMark(lineMsg).toLowerCase())
						{
							// got it!
							clearInterval(myTimer);
							td.style.backgroundColor="yellow";
							gotIt = true;
							if(td.className != "timesup")
							{
								td.innerHTML = td.innerHTML + "&nbsp;&nbsp;&nbsp;&nbsp;<small style='color:orange'>" + format2digits(mins) + ":" + format2digits(secs) + "</small>";
							}
						}
				
					}catch(e){}
					tr.appendChild(td);
					document.getElementById("tblConversation").appendChild(tr);
				
					try{appendInput();}catch(e){}
					
					// run the timer
					if(myTimer_Running==false && gotIt == false)
					{
						myTimer_Running = true;
						myTimer = setInterval(function(){displayTime()}, 1000);
					}
				}
			}
		}
	}
}	
function appendingMsg()
{
	myXmlHttp_AppendMsg.open("GET", "_php/convappender.php?prevline=" + encodeURIComponent(convLineNum.toString()), true);
	myXmlHttp_AppendMsg.send(null);
}

// a function that removes the question mark in a string
function removeQuestionMark(str)
{
	var str_len = str.length;
	var filtered_str = "";
	for(var i=0; i<str_len; i++)
	{
		var c = str.substr(i, 1);
		if(c != "?")
		{
			filtered_str = filtered_str + c;
		}
	}
	return filtered_str;
}