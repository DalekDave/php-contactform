<?php
// This is an example page to showcase how to integrate Iris in a page.

// STEP 1: use, session and config code should be the first line of this page
use Iris\Config;
session_start();

require_once __DIR__ . '/iris/Config.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Collaboration Café Contact Form</title>
<!-- STEP 2: Include the following JS and stylesheet within the HEAD tag -->
<script src="iris/vendor/jquery/jquery-3.4.1.min.js"></script>
<?php if(Config::IRIS_THEME == "dark") { ?>
<link rel="stylesheet" type="text/css"
	href="iris/assets/css/dark-iris.css">
<?php } else { ?>
<link rel="stylesheet" type="text/css" href="iris/assets/css/iris.css">
<?php } ?>
<link rel="stylesheet" type="text/css" href="iris/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body class="m-2">
<?php
// STEP 3: include the Iris contact form UI in whichever place you need
//require_once __DIR__ . '/iris/form-ui-bootstrap.php';
require_once __DIR__ . '/iris/form-ui.php';
?>
</body>
</html>
