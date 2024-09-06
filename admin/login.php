<?php
session_start();
if (isset($_SESSION['admin_user_id'])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - New RK Stores</title>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            height: 310px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .login-form .form-control {
            border-radius: 25px;
        }

        .login-form .btn-primary {
            border-radius: 25px;
            padding: 10px;
            background-color: #8c1519;
            border: none;
            transition: background-color 0.3s ease;
            margin-top: 5px;
        }

        .login-form .btn-primary:hover {
            background-color: #a31e23;
        }

        .login-form .form-group {
            margin-bottom: 20px;
        }

        .login-form .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-form .form-header h2 {
            margin: 0;
            font-weight: 700;
            color: #333;
        }

        .error-text {
            color: #dc3545;
            font-size: 0.875em;
            margin: 0 5px;
            margin-top: -10px;
        }
        .hidden{
            visibility: hidden;
        }
    </style>
</head>

<body>

    <div class="login-form">
        <div class="form-header">
            <h2>Admin Login</h2>
        </div>
        <form id="myForm">
            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="error-text hidden">i</div>
            <button class="btn btn-primary btn-block w-100" onclick="submitForm()">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    function submitForm() {
        event.preventDefault();
        const errorText = document.querySelector('.error-text');
        
        const form = document.getElementById('myForm');
        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/admin-login.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Request was successful
                    const response = xhr.response;
                    if (response === "success") {
                        location.href = "index.php";
                    } else {
                        console.log(errorText);
                        errorText.innerHTML = response;
                        errorText.classList.remove("hidden");
                    }
                } else {
                    // Request failed
                    errorText.innerHTML = 'Error occurred.';
                    errorText.classList.remove("hidden");
                }
            }
        };

        // Convert FormData to JSON
        xhr.send(formData);
    }
</script>

</html>