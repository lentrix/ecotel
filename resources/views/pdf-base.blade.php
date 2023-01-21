<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
            color: black;
            font-size: 10pt;
        }
        h1 {
            font-size: 18pt;
        }

        table.bordered {
            border-collapse: collapse;
            width:100%;
        }

        table.bordered td,
        table.bordered th {
            border: 1px solid #777;
            padding: 2px;
        }
    </style>
</head>
<body>

@yield('content')

</body>
</html>
