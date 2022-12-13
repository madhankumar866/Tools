<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

echo "<pre>";
function mailStream($host, $user, $pass){
	if ($mailbox = imap_open($host, $user, $pass)) {
		return $mailbox;
	} else {
		throw new Exception("Error: " . imap_last_error());
	}
}


try {
	
	$mailbox='INBOX';
	$host='{imap.gmail.com:993/imap/ssl}' . $mailbox;
	$user='sathishseedmail@gmail.com';
	$pass='syhinsnedbqmtjyb';
	$imap=mailStream($host,$user,$pass);
	
	$check = imap_check($imap);
	echo "Msg Count before append: ". $check->Nmsgs . "\n";
	
	//$cmailbox = imap_listmailbox($imap, '{imap.gmail.com:993/imap/ssl}', '*');
	//print_r($cmailbox);
	
	$eml_name="20180518-Fwd_-11539.eml";
	$eml_path="/var/www/zeroT/mk_work/$eml_name";
	$folder="{imap.gmail.com:993/imap/ssl}INBOX";
	$message=file_get_contents($eml_path);
  
	require_once('/var/www/zeroT/mk_work/MimeMailParser.class.php');
	$Parser=new MimeMailParser();
	$Parser->setPath($eml_path);
	$date=$Parser->getHeader('date');
	$date_fm=date_format(date_create($date),"d-M-Y H:i:s O");

	imap_append($imap,$folder,$message,"\\Seen",$date_fm);
	$check = imap_check($imap);
	echo "Date: $date \n\nFormat Date: $date_fm \n\nMsg Count before append: ". $check->Nmsgs . "\n";
	 
	
}catch(Exception $e) {
	echo 'Message: ' .$e->getMessage();
}



?>