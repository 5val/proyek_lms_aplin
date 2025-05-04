<?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    header("Location: login.php");
//    exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: lightblue;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
            <form method="POST">
                <div class="card text-center p-4" style="width: 25rem;">
                    <h2>Sign Up</h2><br>
                    <div class="mb-3 text-start">
                        <label for="name" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="confpassword" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control" id="confpassword" name="confpassword" required>
                    </div>

                    <input type="submit" value="Sign Up" class="btn btn-primary w-100"><br>
                    Already have account ? <a href="login.php">Sign Up</a>
                    
                </div>
            </form>
        </div>
    </div>
</body>
</html>