<?php
    session_start();
    include("config.php");

    // Define variables and set them empty initially
    $con_email = $con_detail = "";
    $error = "";

    // Process the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $con_email = validateInput($_POST["con_email"]);
        $con_detail = validateInput($_POST["con_detail"]);

        $insertQuery = "INSERT INTO Contacts (con_email, con_detail) VALUES ('$con_email', '$con_detail')";

        if (mysqli_query($db, $insertQuery)) {
            header("Location: home.php");
            exit();
        } else {
            $error = "Error contacting : " . mysqli_error($db);
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
    <link rel="stylesheet" href="style.css">
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
    <div class="top-bar">
        <?php
            // Check if the user is logged in
            $loggedIn = isset($_SESSION['login_user']);
            
            if ($loggedIn) {
                $username = $_SESSION['login_user'];
                echo "<div style='margin-left: auto;'>Hi, $username | <a href='logout.php'>Logout</a></div>";
            } else {
                echo "<div style='margin-left: auto;'><a href='login.php'>Login</a> | <a href='create-user.php'>Create Account</a></div>";
            }
        ?>
    </div>

    <div class="menu-bar">
        <div class="menu-toggle">
            <div class="bar"></div>
            <div class="bar middle"></div>
            <div class="bar"></div>
        </div>
        <ul>
            <li><a href="home.php">Dashboard</a></li>
            <li><a href='course-list.php'>Course List</a></li>
            <?php
                if ($loggedIn) {
                    echo "<li><a href='admission.php'>Enroll on a Course</a></li>";
                    echo "<li><a href='your-courses.php'>Courses You Enroll</a></li>";
                }
            ?>
            <li><a href="tutor-list.php">Tutors</a></li>
            <li><a href="partner-list.php">Partners</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </div>

    <div class="collapsed-menu-bar"></div>
    
    <div class="content">
        <h1>Contact Us</h1>
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div>
                    <label for="con_email">Email:</label>
                    <input type="email" id="con_email" name="con_email" required>
                </div>

                <div>
                    <label for="con_detail">Message:</label>
                    <textarea id="con_detail" name="con_detail" rows="15" class="text-box"></textarea>
                </div>

                <div>
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>

        <?php
            if ($error) {
                echo "<p>Error: $error</p>";
            }
        ?>

    </div>
</body>
</html>
