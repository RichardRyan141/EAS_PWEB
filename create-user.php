<?php
    session_start();
    include("config.php");

    // Define variables and set them empty initially
    $u_username = $u_email = $u_password = "";
    $error = "";

    // Process the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $u_username = validateInput($_POST["u_username"]);
        $u_email = validateInput($_POST["u_email"]);
        $u_password = validateInput($_POST["u_password"]);

        $insertQuery = "INSERT INTO User (u_username, u_email, u_password)
                        VALUES ('$u_username', '$u_email', '$u_password')";

        if (mysqli_query($db, $insertQuery)) {
            header("Location: home-list.php");
            exit();
        } else {
            $error = "Error registering user : " . mysqli_error($db);
        }
    }

    // Function to validate and sanitize input data
    function validateInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Tutoring</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }
        
        .content {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 90%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".menu-toggle").click(function() {
                $(".menu-bar").toggleClass("collapsed");
                $(".collapsed-menu-bar").toggleClass("collapsed");
                $(".menu-bar ul li").toggleClass("collapsed");
            });
        });
    </script>
</head>
<body>
    <div class="content">
        <h1>Register User</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div>
                <label for="u_username">Username:</label>
                <input type="text" id="u_username" name="u_username" required>
            </div>

            <div>
                <label for="u_email">Email:</label>
                <input type="email" id="u_email" name="u_email" required>
            </div>

            <div>
                <label for="u_password">Password:</label>
                <input type="password" id="u_password" name="u_password" required>
            </div>

            <div>
                <input type="submit" value="Register">
            </div>
        </form>
        <p><a href="login.php"> Back to Login Page</a></p>
        <?php
            if ($error) {
                echo "<p>Error: $error</p>";
            }
        ?>

    </div>
</body>
</html>
