<?php
$pattern = $_POST['pattern'] ?? '';
$template = $_POST['template'] ?? '';
$randomResponses = $_POST['random_response'] ?? [];

// check if there are random responses
$hasRandomResponses = !empty($randomResponses);

// write the AIML content to a file
$fileContent = "<category>\n";
$fileContent .= "  <pattern>{$pattern}</pattern>\n";

// add random responses
if ($hasRandomResponses) {
   	$fileContent .= "  <template>{$template}<random>\n";
	foreach ($randomResponses as $response) {
		// check if the response is not empty before adding
		if (!empty($response)) {
			$fileContent .= "    <li>{$response}</li>\n";
		}
	}
	$fileContent .= "  </random></template>\n";
} elseif (!empty($template)) {
	// if no random responses but theres a template, add it
	$fileContent .= "  <template>{$template}</template>\n";
} else {
	// no random responses or template, skip adding anything
}

$fileContent .= "</category>\n\n"; // add an empty line after each category

$file = fopen('demo.aiml', 'a'); //AIML file

if ($file) {
	fwrite($file, $fileContent);
	fclose($file);
	header('Location: index.html'); // reload page
	exit(); // make sure to exit after a header redirect
} else {
	echo "Failed to open AIML file";
}
?>
