<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0d1b36;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .login-header {
            font-weight: 600;
            font-size: 28px;
            margin-bottom: 1rem;
        }
        .text-white h2 {
            font-weight: 600;
            font-size: 30px;
        }
        label {
            font-weight: 400;
            font-size: 16px;
        }
        .form-control{
            font-weight: 400;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="text-white position-absolute" style="top: 64px; left: 80px;">
        <h2>BadminZone</h2>
    </div>
    <div class="login-container">
        <h3 class="login-header">Login to your account</h3>
        <form>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <div class="row w-100">
                    <div class="col">
                        <label for="password">Password</label>
                    </div>
                    <div class="col text-right mr-0 pr-0">
                        <a href="#" class="text-primary">Forgot ?</a>
                    </div>
                </div>
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-primary btn-block" style="font-weight: 600; font-size: 14px; background-color: #1570EF;">Login now</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
