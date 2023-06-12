<?php
include("config.php");

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM User WHERE u_username = '$username' and u_password = '$password'";
  $result = mysqli_query($db, $sql);
  $count = mysqli_num_rows($result);

  if ($count == 1) {
    session_start();
    $_SESSION['login_user'] = $username;
    $_SESSION['userType'] = "Member";
    header("location: home.php");
  } else {
    $sql = "SELECT * FROM Tutor WHERE t_username = '$username' and t_password = '$password'";
    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);

    if ($count == 1) {
      $row = mysqli_fetch_assoc($result);

      session_start();
      $_SESSION['login_user'] = $username;
      $_SESSION['userType'] = "Tutor";
      header("location: home.php");
    } else {
      header("location: login.php?error=1");
      exit;
    }
  }
}
?>
