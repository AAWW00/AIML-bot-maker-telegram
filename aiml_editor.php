<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="viewport" content="width=device-width, user-scalable=no">
	<link rel="stylesheet" href="style.css">
	<!-- menu button -->
	<button type="button" onclick="document.location='index.html'" class="backmenu-button">menu 📰</button>
</head>

<body>

<?php
	$file_path = 'demo.aiml'; //AIML file
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aiml_content'])) {
		$aiml_content = $_POST['aiml_content'];
		file_put_contents($file_path, $aiml_content);
}
?>

<form method="post">
	<textarea name="aiml_content" placeholder="You AIML code 🖋" class="editor"><?php
	if (file_exists($file_path)) {
		echo htmlspecialchars(file_get_contents($file_path));
	}
?></textarea>
	<input type="submit" name="save" value="Save 💾" class="save-button">
</form>

<a href="demo.aiml" download="demo.aiml"> <!-- AIML file -->
	<button class="download-button">Download AIML 📥</button>
</a>

</body>
</html>
