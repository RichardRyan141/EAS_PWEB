<?php
    session_start();
    include("config.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Tutoring</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Menu toggle functionality
            $(".menu-toggle").click(function() {
                $(".menu-bar").toggleClass("collapsed");
                $(".collapsed-menu-bar").toggleClass("collapsed");
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
        <h2>Course You Enroll In</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Detail</th>
                    <th>Taught by</th>
                </tr>
            </thead>
            <tbody id="data-table-body">
                <?php

                    $userIDQuery = "SELECT * FROM user WHERE u_username = '$username'";
                    $userIDResult = mysqli_query($db, $userIDQuery);

                    $result = mysqli_fetch_assoc($userIDResult);
                    $userID = $result['u_id'];

                    $sql = "SELECT c.*, t.t_username
                            FROM Course c
                            JOIN Tutor t ON t.t_id = c.Tutor_t_id
                            JOIN user_course uc ON c.c_id = uc.course_c_id
                            WHERE uc.user_u_id = '$userID'";
                    $result = mysqli_query($db, $sql);
                    $counter = 1;
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td>" . $row['c_name'] . "</td>";
                            echo "<td>" . $row['c_detail'] . "</td>";
                            echo "<td>" . $row['t_username'] . "</td>";
                            echo "</tr>";
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>No course found</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
