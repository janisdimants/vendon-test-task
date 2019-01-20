<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Page</title>
</head>
<body>
    <?php require('nav.php'); ?>
    <?php 
        if (isset($_SESSION['errors'])) {
            $GLOBALS['errors'] = $_SESSION['errors'];
            unset($_SESSION['errors']);
        } else {
            $GLOBALS['errors'] = [];
        }
    ?>