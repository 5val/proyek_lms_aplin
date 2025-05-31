<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forbidden</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            text-align: center;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 4em;
            color: #dc3545; /* Red color for error */
            margin-bottom: 0.5em;
        }
        p {
            font-size: 1.2em;
            margin-bottom: 1.5em;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>403</h1>
        <p>You don't have permission to access this page.</p>
        <p>Looks like you've stumbled upon a forbidden area.</p>
        <a href="{{ url('/') }}">Go to Homepage</a>
        @if(isset($exception) && $exception->getMessage())
            <p><small>Error: {{ $exception->getMessage() }}</small></p>
        @endif
    </div>
</body>
</html>