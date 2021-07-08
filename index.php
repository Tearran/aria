<?php ?>
<!DOCTYPE html>
<html>
<head>
<title>ARIA</title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />

    <!-- see http://webdesign.tutsplus.com/tutorials/htmlcss-tutorials/quick-tip-dont-forget-the-viewport-meta-tag -->
    <!-- <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1"> -->
    <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1, user-scalable=no">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes, minimum-scale=1, maximum-scale=2"> -->
    <style>
      /* following two viewport lines are equivalent to meta viewport statement above, and is needed for Windows */
        /* see http://www.quirksmode.org/blog/archives/2014/05/html5_dev_conf.html and http://dev.w3.org/csswg/css-device-adapt/ */
    @-ms-viewport { width: 100vw ; min-zoom: 100% ; zoom: 100% ; }          @viewport { width: 100vw ; min-zoom: 100% zoom: 100% ; }
    @-ms-viewport { user-zoom: fixed ; min-zoom: 100% ; }                   @viewport { user-zoom: fixed ; min-zoom: 100% ; }
        /*@-ms-viewport { user-zoom: zoom ; min-zoom: 100% ; max-zoom: 200% ; }   @viewport { user-zoom: zoom ; min-zoom: 100% ; max-zoom: 200% ; }*/
    
html, body {
	background-color: #000000;
	color: #00FF00;
	height: 100vh;
	margin:0;
}
a:link {
  color: #ffffff;
}

/* visited link */
a:visited {
  color: #ffFFff;
}

/* mouse over link */
a:hover {
  color: hotpink;
}

/* selected link */
a:active {
  color: #ffffff;
}

fieldset{
  border-color: #0F0;
  border-style: solid;
}

input[type=button], input[type=submit], input[type=reset] {
  background-color: #333333;
  border: none;
  color: #00ff00;
  font-weight: bold;
  padding: 16px 32px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
}

input#message, input[type=text] {
	background-color: #333333;
	color: #00FF00;
	padding: 12px 20px;
	box-sizing: border-box;
	border: none;  
	width: 100%;
}

div#dialogue {
	overflow: auto;
	min-height: 50vh;
	height: 75vh;
	width: 100%;
}

div#debug {
	overflow: auto;
	max-height: 90vh;
	width: 100%;
}

code {
	font-family: monospace;
	color: #D00;
}

span.user {
	font-weight: bold;
	color: #CfC
}
span.bot {
	font-weight: bold;
	color: #CfC
}
	
table.input-table {
	border: 0px;
	border-collapse: separate;
	border-spacing: 4px;
	width: 100%;
}
table.input-table td.text-box {
	padding: 4px;
	text-align: left;
	vertical-align: middle;
}
table.input-table td.send-button {
	padding: 4px;
	text-align: center;
	vertical-align: middle;
	width: 10px;
}
	
	
	</style>
</head>


<body>

<div id="webpack-error" style="display: none; max-width: 500px">
	<h2 style="color: #F00">Loading Error: rivescript.js not found</h2>

	<p>
		There was a problem loading the <code>rivescript.js</code> script on this
		page. This most likely means the script was not found where this page was
		expecting it to be. If you're running this demo from the rivescript-js
		git project, maybe you forgot to run <code>npm run dist</code>?
	</p>

	<p>
		The original version of this page looks for it at the relative path
		<code>../../dist/rivescript.js</code>. This is expecting the path to
		<em>the current page</em> to be something like <code>/eg/web-client/chat.html</code>
		from a web server started at the root of the rivescript-js project.
		Double check that these path settings are correct.
	</p>

	<p>
		If you have uploaded the web-client demo to a web server such as Apache,
		ensure that the path is correct for where it looks for <code>rivescript.js</code>.
	</p>
</div>
<div id="local-file-error" style="display: none; max-width: 500px">
	<h2 style="color: #F00">Local Filesystem Detected</h2>

	<p>
		It appears you have opened this page by double-clicking it in your file
		browser: the URL of this page has a <code>file:///</code> URL scheme.
	</p>

	<p>
		Modern web browsers place security restrictions on locally opened web
		pages which prevent them from running ajax requests for other local
		files on your disk. Unfortunately, this means that the
		<code>RiveScript.loadFile()</code> function used on this page will
		probably not work when you open this page locally.
	</p>

	<p>
		See the <code>README.md</code> file for some tips on how to run this
		page in a web server environment. This will be required for the bot to
		load the <code>*.rive</code> files in a way that respects the Same
		Origin Policy enforced by the web browser.
	</p>
</div>


<form action="index.php" method="post " onSubmit="return sendMessage()">

	<fieldset id="InputUser">
		<legend>Send a Message</legend>

		<table class="input-table">
			<tr>
				<td class="text-box">
					<input type="text" name="message" id="message" autocomplete="off" disabled placeholder="Please wait... loading...">
				</td>
				<td class="send-button">
					<input type="submit" value="Send">
				</td>
			</tr>
		</table>
	</fieldset>
</form>
<fieldset id="ChatLog">
	<legend>Chat Log</legend>
	<div id="dialogue"></div>
</fieldset>


<!--<fieldset>
	<legend>Debugger</legend>

	<input type="button" value="Debug Mode" id="toggle" onClick="toggleDebug()">
	<input type="button" value="Clear Log" onClick="$('#debug').empty()">
	<input type="button" value="Dump Data Structure" onClick="DumperPopup(rs)">

	<div id="debug"></div>
</fieldset>//-->


	<script
		src="https://code.jquery.com/jquery-1.12.4.min.js"
		integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
		crossorigin="anonymous">
	</script>
	
	<script 	
		src="https://unpkg.com/rivescript@latest/dist/rivescript.min.js"
		crossorigin="anonymous"> 
	</script>
	
<script type="text/javascript" src="datadumper.js"></script>
<script type="text/javascript">
// Handle the debug mode query string parameter.
var debugMode = false;
if (window.location.search.indexOf("debug=1") > -1) {
	$("#toggle").val("Disable Debug Mode");
	debugMode = true;
} else {
	$("#toggle").val("Enable Debug Mode");
}

// Warn the user if they opened the page locally that it will probably
// experience ajax errors.
if (window.location.protocol === "file:") {
	document.querySelector("#local-file-error").style.display = "block";
}

// Problem loading rivescript.js?
var rs;
if (window.RiveScript === undefined) {
	document.querySelector("#webpack-error").style.display = "block";
} else {
	// Create our RiveScript interpreter.
	rs = new RiveScript({
		debug:   debugMode,
		onDebug: onDebug
	});

	// This won't work on the web!
	//rs.loadDirectory("brain");

	// Load our files from the brain/ folder.
	rs.loadFile([
		"base.rive",
		//"formtools.rive",
		//"brain/begin.rive",
		//"brain/admin.rive",
		//"brain/clients.rive",
		//"brain/eliza.rive",
		//"brain/myself.rive",
		//"brain/rpg.rive",
		//"brain/javascript.rive"
	]).then(onReady).catch(onError);

	// You can register objects that can then be called
	// using <call></call> syntax
	rs.setSubroutine('fancyJSObject', function(rs, args){
		// doing complex stuff here
	});
}

function onReady() {
	$("#dialogue").append("<div><center> Welcome, this is an Automated Inqirey Response Aid (ARIA™) version 0 alpha 1 + RS " + rs.version() + ", ready to Respond!<BR> Type a expression.</center></div>");
	$("#message").removeAttr("disabled");
	$("#message").attr("placeholder", "Send message");
	$("#message").focus();

	// Now to sort the replies!
	rs.sortReplies();
}

function onError(err, filename, lineno) {
	$("#dialogue").append('<div><span class="bot">Error:</span> ' + err + '</div>');
}

// Handle sending a message to the bot.
function sendMessage () {
	var text = $("#message").val();
	$("#message").val("");
	$("#dialogue").append("<fieldset id=\"bubble\"><legend class='user'>You:</legend> " + text + "</div></fieldset>");

	rs.reply("soandso", text, this).then(function(reply) {
		reply = reply.replace(/\n/g, "<br>");
		$("#dialogue").append("<fieldset id=\"bubble\"><legend class='bot'>ARIA:</legend> " + reply + "</div></fieldset>");
		$("#dialogue").animate({ scrollTop: $("#dialogue").height() }, 1000);
	}).catch(function(e) {
		window.alert(e.message + "\n" + e.line);
		console.log(e);
	});

	return false;
}

// Button that turns debugging on and off.
function toggleDebug () {
	if (debugMode) {
		window.location = "?debug=0";
	} else {
		window.location = "?debug=1";
	}
}

function onDebug(message) {
	if (debugMode) {
		$("#debug").append("<div>[RS] " + escapeHtml(message) + "</div>");
	}
}

function escapeHtml(text) {
	return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
}

</script>
</body>
</html>