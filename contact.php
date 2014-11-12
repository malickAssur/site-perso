<?php 
$emailTo = 'elmn64@yahoo.fr';
$siteTitle = 'votre contact depuis mon site perso [malickas.free.fr]';

error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {
	
	// require a name from user
	if(trim($_POST['contactName']) === '') {
		$nameError =  'Merci de saisir votre nom !'; 
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}
	
	// need valid email
	if(trim($_POST['email']) === '')  {
		$emailError = 'Merci de saisir votre email.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'Votre adresse email est invalide.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
		
	// we need at least some content
	if(trim($_POST['comments']) === '') {
		$commentError = 'Merci de saisir votre message!';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}
		
	// upon no failure errors let's email now!
	if(!isset($hasError)) {
		
		$subject = 'Nouveau message de '.$siteTitle.' from '.$name;
		$sendCopy = trim($_POST['sendCopy']);
		$body = "Nom: $name \n\nEmail: $email \n\nMessage: $comments";
		$headers = 'From: ' .' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		
        //Autoresponse
		$respondSubject = 'Merci '.$siteTitle;
		$respondBody = "Votre message a été bien tranmis ! \n\n A bientôt.";
		$respondHeaders = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $emailTo;
		
		mail($email, $respondSubject, $respondBody, $respondHeaders);
		
        // set our boolean completion value to TRUE
		$emailSent = true;
	}
}
?>