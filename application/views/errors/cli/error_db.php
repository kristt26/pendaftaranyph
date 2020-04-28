<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo "\nDatabase error: ",
// 	$heading,
// 	"\n\n",
// 	$message,
// 	"\n\n";
$message = preg_replace('/(<\/?p>)+/', ' ', $message);
throw new Exception("Database error occured with message : {$message}");
