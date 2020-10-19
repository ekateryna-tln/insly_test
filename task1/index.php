<?php

	$binaryString = '01110000 01110010 01101001 01101110 01110100 00100000 01101111 01110101 01110100 00100000 01111001 01101111 01110101 01110010 00100000 01101110 01100001 01101101 01100101 00100000 01110111 01101001 01110100 01101000 00100000 01101111 01101110 01100101 00100000 01101111 01100110 00100000 01110000 01101000 01110000 00100000 01101100 01101111 01101111 01110000 01110011';
	$binaryArr = explode(' ', $binaryString);

	echo 'Binary String: ' . $binaryString . '<br /><br />Meaning: ';
	for ($i = 0; $i < count($binaryArr); $i++) {
		echo chr(bindec("$binaryArr[$i]"));
	};

	$name = 'Kateryna Yaroshenko';
	$binaryNameArr = [];
	echo '<br /><br />Name: ' . $name . '<br />Binary String: ';
	for ($i = 0; $i < strlen($name); $i++) {
		$binaryNameArr[] = sprintf( "%08d", decbin(ord($name[$i])));
	};
	echo implode(' ', $binaryNameArr);
	die;