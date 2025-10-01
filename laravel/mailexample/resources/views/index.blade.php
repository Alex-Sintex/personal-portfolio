<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send me emails</title>
    <style>
        a {
            text-decoration: none;
            background-color: cadetblue;
            padding: 15px;
            border-radius: 10px;
            color: #333;
            cursor: pointer;
        }

        a:hover {
            background-color: aquamarine;
        }
    </style>
</head>

<body>
    <a href="{{ route('mailMe') }}">Mail me</a>
</body>

</html>
