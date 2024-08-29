<?php
if (isset($_GET['xml'])) {
    $xml = simplexml_load_string($_GET['xml']);
    $json = json_encode($xml, JSON_PRETTY_PRINT);
    $array = json_decode($json, false);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>XML to JSON Converter</title>

    <style>
        body {
            display: flex;
            gap: 1rem;
            padding: 1rem;
        }
        button {
            display: block;
            margin-top: 1rem;
        }
        textarea {
            width: 100%;
            height: 300px;
        }
    </style>
</head>
<body>
<form action="#" method="GET">
    <textarea name="xml" id="xml" placeholder="Enter XML here"><?php
        if (isset($xml) && $xml) {
            echo htmlspecialchars($_GET['xml']);
        }
        ?></textarea>

    <textarea name="json" id="json" readonly><?php
        if (isset($json) && $json) {
            echo htmlspecialchars($json);
        }
        ?></textarea>

    <button type="submit">Convert!</button>
</form>

