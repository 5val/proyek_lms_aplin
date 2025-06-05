<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: lightblue;
            background-image: url("https://images.pexels.com/photos/2982449/pexels-photo-2982449.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2");
            background-repeat: no-repeat;
            background-size: cover;
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
                @csrf
                <div class="card text-center p-4" style="width: 25rem;">
                    <img style="align-self: center;" src="{{ asset('images/logo_sekolah2.png') }}"
                        class="rounded-circle mb-2" width="50%" height="50%">
                    <h2>Welcome to SMA Ovaldo</h2><br>

                    <div class="mb-3 text-start">
                        <label for="email" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <input type="submit" value="Login" class="btn btn-primary w-100"><br>
                    <!-- Don't have account ? <a href="signup.php">Sign Up</a> -->
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </form>

        </div>
    </div>
</body>

</html>