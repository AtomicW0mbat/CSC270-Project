<?php
  session_start();
  require_once 'config.php';
  $conn = new mysqli($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

  function clean_input($data) {
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
  }

  function query($query,$conn) {
    $result = $conn->query($query);
    if(!$result)
    {
	die($conn->error);
	return NULL;
    }
    else 
    {
	return $result;
    }
		
  }

  function get_id($username, $conn) {
    $id_query = "SELECT id FROM users WHERE username = '$username';";
    $result = query($id_query,$conn);
    $result->data_seek(0);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $user_id = $row['id'];
    return $user_id;
  }
     

  if($_POST['submit']) {
    $user_id = get_id($_SESSION['username'], $conn);
    $content = clean_input($_POST['content']);
    $query = "INSERT INTO posts(user_id,date,content) VALUES($user_id, NOW(), '$content');";
    $result = query($query,$conn);
 
    if(!$result) {
      $_SESSION['error_message'] = "Could not insert post";
    }
    else {
      $_SESSION['error_message'] = "";
    }
 
  }

    header("Location: index.php");
  
?>
