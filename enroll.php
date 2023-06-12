<?php
    session_start();
    include("config.php");

    if (isset($_GET['id'])) {
        $courseId = $_GET['id'];

        $username = $_SESSION['login_user'];
        $userIDQuery = "SELECT * FROM user WHERE u_username = '$username'";
        $userIDResult = mysqli_query($db, $userIDQuery);

        $result = mysqli_fetch_assoc($userIDResult);
        $userID = $result['u_id'];

        $insertQuery = "INSERT INTO User_Course (user_u_id, course_c_id) VALUES ('$userID', '$courseId')";

        if (mysqli_query($db, $insertQuery)) {
            header("Location: home.php");
            exit();
        } else {
            $error = "Error enrolling: " . mysqli_error($db);
        }
    } else {
        header("Location: home.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Member</title>
</head>
<body>
    <?php
        // Display error message if any
        if (isset($error)) {
            echo "<p>Error: $error</p>";
        }
    ?>
</body>
</html>
