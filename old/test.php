<?php

$url = "https://www.textmagic.com/app/api";
$username = "ilyaph";
$password = "123123";
$text = "Test+message";

for ($i=0;$i<2000;$i++){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "username=".$username."&password=".$password."&cmd=send&text=".$text."&phone=79136684323&unicode=0");
	curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	curl_exec($ch);
	curl_close($ch);
}