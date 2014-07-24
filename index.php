<?php
require("class.phpmailer.php");
$mail = new PHPMailer();
$mail = new PHPMailer();
if(isset($_POST["smtp"]) && $_POST["smtp"]=="on"){
$mail->isSMTP();
$mail->SMTPDebug = 0;
//Set the hostname of the mail server
$mail->Host = $_POST["smtp_server"];
$mail->Port = $_POST["smtp_port"];

if($_POST["ssl"]!="on"){$mail->SMTPSecure = 'tls';}else{$mail->SMTPSecure = 'ssl';}
$mail->SMTPAuth = true;
$mail->Username = $_POST["smtp_user"];
$mail->Password = $_POST["smtp_pass"];
}
else{$mail->isSendmail();}

?>
<html>
<head><title>PHP-SMTP Mailer</title>
<style>body,html{width:100%;padding:0;margin:0}html{overflow:scroll;min-height:100%;background:radial-gradient(#ccc,#54958A,#2C3A4E)}
.topBar{width:75%;color:#fafafa;background:rgba(0,0,0,.75);padding:15px;overflow:hidden;margin:0 auto;border-bottom-right-radius:150px;border-bottom-left-radius:150px;box-shadow:0 0 15px rgba(0,0,0,.75),0 0 15px rgba(0,0,0,.75);text-shadow:-1px 2px 3px rgba(255,255,255,.75);font-family:Audiowide,cursive;font-size:35px;text-align:center;font-weight:700}form{width:500px;margin:10% auto 0;background:rgba(0,0,0,.75);padding:15px;border-radius:15px;box-shadow:0 0 15px rgba(0,0,0,.75),0 0 15px rgba(0,0,0,.75);font-family:Play}form>fieldset>label,form>label{display:inline-block;width:40%;color:#fff;font-weight:700}form>input,fieldset>input{display:inline-block;width:40%;width:150px;margin-right:10px;background:rgba(0,0,0,.3);outline:0;padding:4px;font-size:13px;color:#fff;text-shadow:1px 1px 1px rgba(0,0,0,.3);border:1px solid rgba(0,0,0,.3);border-radius:4px;box-shadow:inset 0 -5px 45px rgba(100,100,100,.2),0 1px 1px rgba(255,255,255,.2);-webkit-transition:box-shadow .5s ease;-moz-transition:box-shadow .5s ease;-o-transition:box-shadow .5s ease;-ms-transition:box-shadow .5s ease;transition:box-shadow .5s ease}button{background-image:linear-gradient(to bottom,#f5f5f5,#aaa);padding:15px;border:0;border-radius:15px;color:rgba(78,154,0,.5);text-shadow:0 .02em .08em #ccc,0 0 0 #000,0 .02em .02em #fff;font-family:Audiowide;font-weight:700;font-size:22px;text-align:center;display:block;margin:10px auto 0}</style>
<link href="http://fonts.googleapis.com/css?family=Play|Audiowide" rel="stylesheet" type="text/css">
</head>
	<body><script>
	function senden(){if(text!=null){document.getElementById('text').value = ace.edit('mailtext').getSession().getValue();document.forms["myform"].submit();}}</script>
	<h2 class="topBar">Mail senden</h2>
		<form name="myform" action="" method="post" onsubmit="event.preventDefault();senden();">

			<label for="from">Absender Mail</label><input id="from" type="text" name="from"><br/>
			<label for="subject">Betreff</label><input id="subject" type="text" name="subject"><br>
			<hr><fieldset><legend>SMTP</legend>
			<label for="smtp">SMTP</label><input id="smtp" name="smtp" type="checkbox" class="checkbox"><br/>
			<label for="smtp_server">Server</label><input id="smtp_server" name="smtp_server" type="text"><br/>
			<label for="smtp_port">Port</label><input id="smtp_port" name="smtp_port" type="text"><br/>
			<label for="smtp_user">Benutzer</label><input id="smtp_user" name="smtp_user" type="text"><br/>
			<label for="smtp_pass">Passwort</label><input id="smtp_pass" name="smtp_pass" type="password"><br/>
			<label for="ssl">SSL</label><input id="ssl" name="ssl" type="checkbox" class="checkbox"><br/>
			</fieldset>
			<!--<label for="smtp_user">Benutzer</label><input id="smtp_user" name="smtp_user" type="text"><br/>-->

			<div id="mailtext"></div>
			<input type="hidden" id="text" name="text" value="">
			<br>
			<input type="submit"name="send" value="Absenden"/>
		</form>
		<style type="text/css" media="screen">fieldset{color:white;width:75%;float:right;border:0px solid; box-shadow:2px 3px 15px rgba(0,0,0,0.75) inset; padding:15px;border-radius:7px;margin-bottom:25px;}
		legend{text-align:center;font-weight:bold;position:relative;top:20px;}
		#mailtext{width: 100%;height: 250px;}#editor{position: absolute;top: 0;right: 0;bottom: 0;left: 0;}h3{font-family: 'Audiowide';margin-bottom: 0px;color: lightgray;text-shadow: -1px 2px 3px rgba(0,0,0,0.75);}
		.label--checkbox{position:relative;margin:.5rem;font-family:Arial,sans-serif;line-height:135%;cursor:pointer}

		</style>
		<script src="js/ace.js" type="text/javascript" charset="utf-8"></script>
		<script>var editor = ace.edit("mailtext");editor.setTheme("ace/theme/solarized_dark");editor.getSession().setMode("ace/mode/html");editor.setValue("HTML HIER EINFÜGEN");</script>
	</body>
</html>

<?php

if(isset($_POST['send']))
{
	$header = 'From: '.$_POST['from'];
	$mail->setFrom($_POST["from"], $_POST["from"]);
	foreach(explode("\n", file_get_contents('list.txt')) as $mails)
	{
		$mail->addAddress($mails, $mails);
		$mail->Subject = $_POST["subject"];
		$mail->msgHTML($_POST["text"]);
		$mail->AltBody = $_POST["text"];
		if (!$mail->send()) {echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $mail->ErrorInfo . '<br />';break;}
		else {echo "Message sent to :" . $mails ,'<br />';}
		$mail->clearAddresses();
		$mail->clearAttachments();



		if (!$mail->send()) {echo "Mailer Error: " . $mail->ErrorInfo.'<br/>';} else {echo "Message sent!<br/>";}

	}
}

?>
