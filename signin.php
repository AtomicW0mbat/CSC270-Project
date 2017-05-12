<?php
  session_start();
  require_once 'config.php';
  $db = new mysqli($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

  function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if($_POST['submit']) {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);

    $check = "SELECT* FROM users WHERE username='$username'";
    $result = $db->query($check);
    $rows = $result->num_rows;

    if($rows != 0) {
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $db_username = $row['username'];
      $db_password = $row['password'];

      if($username == $db_username && $password == $db_password) {
        $_SESSION['username'] = $username;
        $_SESSION['error_message'] = "";
        $_SESSION['modal'] = "";
      }
    }
    else {
      $_SESSION['error_message'] = "Invalid username or password";
      $_SESSION['username'] = "";
      $_SESSION['modal'] = "signin";
    }

    header("Location: index.php");
  }
?>
