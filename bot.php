<?php
include 'config.php';

// paths to AIML files and logs
$aimlFilePath = 'demo.aiml';
$logFilePath = 'bot.log';

// function for reading AIML file and parsing its contents
function readAIMLFile($filename) {
	$aimlContent = file_get_contents($filename);
	$aimlData = [];
	$pattern = '/<pattern>(.*?)<\/pattern>\s*<template>(.*?)<\/template>/is';
	preg_match_all($pattern, $aimlContent, $matches, PREG_SET_ORDER);

	foreach ($matches as $match) {
		$aimlData[] = [
			'pattern' => $match[1],
			'template' => $match[2]
		];
	}

	return $aimlData;
}

// function for colculateeng the percantage of streeng motches using the Levenshtein algarithm for speling corection))0)
function levenshteinPercentage($str1, $str2) {
	$len1 = mb_strlen($str1, 'UTF-8');
	$len2 = mb_strlen($str2, 'UTF-8');

	$maxLen = max($len1, $len2);

	if ($maxLen === 0) {
		return 0;
	}

	$distance = levenshtein($str1, $str2);
	return (1 - ($distance / $maxLen)) * 100;
}

// function for processing user requests using AIML templates
function processAIML($message, $aimlData) {
	$message = trim($message);
	$message = mb_strtoupper($message, 'UTF-8');

	$bestMatchPercentage = 0;
	$bestTemplate = 'I dont understand 🙈';

	foreach ($aimlData as $aimlItem) {
		$pattern = mb_strtoupper($aimlItem['pattern'], 'UTF-8');
		$patternDistance = levenshteinPercentage($message, $pattern);

		if ($patternDistance >= 50 && $patternDistance > $bestMatchPercentage) {
			$bestMatchPercentage = $patternDistance;
			$bestTemplate = $aimlItem['template'];
		}
	}

	// process <random> and <li>
	$bestTemplate = processRandomAndLi($bestTemplate);

	return $bestTemplate;
}

function processRandomAndLi($template) {
	// pattern for searching <random> & </random>
	$randomPattern = '/<random>(.*?)<\/random>/is';
	preg_match_all($randomPattern, $template, $randomMatches);

	if (!empty($randomMatches[1])) {
		$randomContent = $randomMatches[1];
		$randomResponse = $randomContent[array_rand($randomContent)];  // choose a random element
		$liPattern = '/<li>(.*?)<\/li>/is';
		preg_match_all($liPattern, $randomResponse, $liMatches);

		if (!empty($liMatches[1])) {
			$randomResponse = $liMatches[1][array_rand($liMatches[1])];  // choose <li>
			$template = str_replace($randomMatches[0], $randomResponse, $template);
		}
	}

	return $template;
}

// function for logging information about requests and responses
function logMessage($fileName, $userId, $userName, $userMessage, $botResponse) {
	$logLine = $userName . ' (' . $userId . ') | ' . $userMessage . ' | ' . $botResponse . "\n";
	file_put_contents($fileName, $logLine, FILE_APPEND);
}

$update = json_decode(file_get_contents('php://input'), true);
$message = $update['message']['text'];
$chatId = $update['message']['chat']['id'];
$userName = $update['message']['from']['first_name'];
$userId = $update['message']['from']['id'];

$aimlData = readAIMLFile($aimlFilePath);

if (isset($message)) {
	$response = processAIML($message, $aimlData);
	sendMessage($chatId, $response);

	// loging
	logMessage($logFilePath, $userId, $userName, $message, $response);
}

// send message Telegram API
function sendMessage($chatId, $message) {
	global $config;
	$url = 'https://api.telegram.org/bot' . $config['telegram_token'] . '/sendMessage';
	$params = [
		'chat_id' => $chatId,
		'text' => $message
		];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
?>
