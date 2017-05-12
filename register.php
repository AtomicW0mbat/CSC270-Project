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
    $password_re = clean_input($_POST['password-re']);

    $check = "SELECT* FROM users WHERE username='$username'";
    $result = $db->query($check);
    $rows = $result->num_rows;

    if($rows != 0) {
      $_SESSION['error_message'] = "That username is not avaliable.";
      $_SESSION['username'] = "";
      $_SESSION['modal'] = "register";
    }
    else if($password != $password_re) {
      $_SESSION['error_message'] = "The passwords do not match.";
      $_SESSION['username'] = "";
      $_SESSION['modal'] = "register";
    }
    else {
      $sql = "INSERT INTO users(username,password) VALUES('$username','$password')";
      $db->query($sql);
      $_SESSION['error_message'] = "";
      $_SESSION['username'] = $username;
      $_SESSION['modal'] = "";
    }

    header("Location: index.php");
  }
?>
