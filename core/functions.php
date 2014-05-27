<?php

function escape($string) {
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function tidyWord($word) {
	$word = preg_replace('/_/', ' ', $word);
	$word = ucwords($word);
	return $word;
}

function unTidyWord($word) {
	$word = preg_replace('/ /', '_', $word);
	$word = strtolower($word);
	return $word;
}