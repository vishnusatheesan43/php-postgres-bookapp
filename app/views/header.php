<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Catalog App</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        form { max-width: 400px; }
        input, button { display: block; width: 100%; margin-bottom: 10px; padding: 8px; }
        button { background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
        .error { color: red; }
        .env-badge {
            display: inline-block;
            font-size: 12px;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 12px;
            margin-left: 10px;
            vertical-align: middle;
            background: #e7f3ff;
            color: #0366d6;
        }
    </style>
</head>
<body>
    <h1>Book Catalog
        <span class="env-badge"><?php echo htmlspecialchars(ENVIRONMENT_NAME); ?> · v<?php echo htmlspecialchars(APP_VERSION); ?></span>
    </h1>
    <a href="index.php?action=add"><button>Add New Book</button></a>
    <hr>