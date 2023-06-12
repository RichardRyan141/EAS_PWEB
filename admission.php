<?php
    session_start();
    include("config.php");

    $c_id = "";
    $error = "";

    $username = $_SESSION['login_user'];

    $userIDQuery = "SELECT * FROM user WHERE u_username = '$username'";
    $userIDResult = mysqli_query($db, $userIDQuery);

    $result = mysqli_fetch_assoc($userIDResult);
    $userID = $result['u_id'];

    // Process the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $c_id = validateInput($_POST["c_id"]);

        // Insert the employee data into the database
        $insertQuery = "INSERT INTO User_Course (user_u_id, course_c_id) VALUES ('$userID', '$c_id')";

        if (mysqli_query($db, $insertQuery)) {
            header("Location: home.php");
            exit();
        } else {
            $error = "Error enrolling: " . mysqli_error($db);
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
        <h1>Enroll on a Course</h1>
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div>
                    <label for="c_id">Course:</label>
                    <select id="c_id" name="c_id" required>
                        <?php
                            $courseIDQuery = "SELECT * FROM course";
                            $courseIDResult = mysqli_query($db, $courseIDQuery);

                            while ($courseID = mysqli_fetch_assoc($courseIDResult)) {
                                echo "<option value='" . $courseID['c_id'] . "'>" . $courseID['c_name'] . "</option>";
                            }
                        ?>
                    </select>
                </div>

                <div>
                    <input type="submit" value="Enroll">
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
