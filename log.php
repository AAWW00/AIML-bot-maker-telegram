<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" href="style.css">
	<!-- menu button -->
	<button type="button" onclick="document.location='index.html'" class="backmenu-button">menu 📰</button>
</head>
<body>
	<button type="button" onclick="document.location='index.html'" class="backmenu-button">menu 📰</button>
<div class="form">
	<table class="log-table" id="log-table">
		<tbody id="log-container">
<?php
$logFilePath = 'bot.log';
if (file_exists($logFilePath)) {
$lines = array_reverse(file($logFilePath, FILE_IGNORE_NEW_LINES)); // reversing the array

foreach ($lines as $line) {
	if (preg_match('/^(.*?) \((\d+)\) \| (.*?) \| (.*)$/', $line, $matches)) {
		$name = trim($matches[1]);
		$id = $matches[2];
		$question = $matches[3];
		$answer = $matches[4];

		echo '<tr>';
		echo '<td>' . $name . '</td>';
		echo '<td>' . $id . '</td>';
		echo '<td>' . $question . '</td>';
		echo '<td>' . $answer . '</td>';
		echo '</tr>';
		}
	}
} else {
	echo '<tr><td colspan="4">Error: Log file not found</td></tr>';
	}
?>
		</tbody>
	</table>
</div>
</body>
</html>
