<?php
  session_start();
  require_once 'config.php';
  $conn = new mysqli($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

  function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $username = $_SESSION['username'];

  if($_SESSION['modal'] == "signin") {
    $onload = "openSignIn();";
  }
  else if($_SESSION['modal'] == "register") {
    $onload = "openRegister();";
  }
  else {
    $onload = "";
  }

   function query($query,$conn)
	{
		$result = $conn->query($query);
		if(!$result)
		{
			echo "Error with query";
			die($die->error);
			return NULL;
		}
		else 
		{
			return $result;
		}
	}

   function view_all($conn)
	{
		$query = "SELECT u.username, p.date, p.content FROM posts p JOIN users u ON u.id=p.user_id ORDER BY date DESC;";
		$result = query($query, $conn);
		$rows = $result->num_rows;
	
		$table = '<tr>'.'<th>User</th><th>Date</th><th>Content</th>'.'</tr>';
		for($j=0;$j<$rows;$j++)
		{
			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$table = $table.'<tr><td>'.$row['username'].'</td>'.'<td>'.$row['date'].'</td>'.'<td>'.$row['content'].'</td><tr>';
		}
		return $table;
	}

	$table = view_all($conn);

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title> YoteSupport </title>
		<link rel="stylesheet" type="text/css" href="main_stylesheet.php">
		<script type="text/javascript">
			function openSignIn() {
				document.getElementById("signin").style.display = "block";
				document.getElementById("register").style.display = "none";
			}
			function openRegister() {
				document.getElementById("register").style.display = "block";
				document.getElementById("signin").style.display = "none";
			}
                        function checkTime( i ) {
                          if(i<10){
                            i = "0" + i;
                          }
                          return i;
                        }
                        function startTime() {
                          var today = new Date();
                          var h = checkTime(today.getHours());
                          var m = checkTime(today.getMinutes());
                          var s = checkTime(today.getSeconds());
                          var c = ":";
                          if ((s % 2) == 1) {
                            c = " ";
                          }
                          document.getElementById("time").innerHTML = h + c + m;
                          var t = setTimeout( function(){startTime() },500);
                        }
		</script>
	</head>
	<body onload="<?php echo $onload ?>; startTime()">
		<nav>
			<ul class="navbar">
				<li><a href="#" class="navbtn active"> Home </a></li>
				<li><a href="https://login.microsoftonline.com/login.srf?wa=wsignin1.0&rpsnv=4&ct=1490943806&rver=6.7.6640.0&wp=MCMBI&wreply=https%3a%2f%2fportal.office.com%2flanding.aspx%3ftarget%3d%252fdefault.aspx&lc=1033&id=501392&msafed=0&client-request-id=dc28fab0-ca54-436e-8774-a8e23944b6e2" class="navbtn"> Yote Mail </a></li>
				<li><a href="https://cofi.instructure.com/login/ldap" class="navbtn"> Canvas </a></li>
				<li><a href="4_year_schedule.php" class="navbtn"> 4 Year Schedule </a></li>
				<div style="float:right; border-left:2px solid #222">
<?php
  if($_SESSION['username']) {
?>
					<li><a href="construction.php" class="navbtn"> My Profile </a></li>
                                       	<li><a href="index.php?action=logout" class="navbtn"> Log out </a></li>
<?php
  }
  else {
?>
					<li><span onclick="openSignIn()" class="navbtn"> Sign in </span></li>
					<li><span onclick="openRegister()" class="navbtn"> Register </span></li>
<?php
  }

  if($_GET['action'] == "logout") {
    session_destroy();
    header("Location: index.php");
  }
?>
				</div>
				<li style="float:right"><div id="time"></div></li>
			</ul>
		</nav>
		<div id="signin" class="user_modal">
		<span onclick="document.getElementById('signin').style.display='none'" class="close" title="Close Modal"> x </span>
			<div class="user_modal_container">
				<ul class="switcher">
					<li class="selected"> Sign in </li>
					<li onclick="openRegister()"> Register </li>
				</ul>
				<form action="signin.php" method="POST">
					<label><b> Username </b></label>
					<input type="text" placeholder="Username" name="username" required>
					<label><b> Password </b></label>
					<input type="password" placeholder="Password" name="password" required>
					<p><a href="construction.php"> Forgotten Password? </a></p>
					<input type="checkbox" checked="checked"> Remember me
					<div class="clearfix">
						<button type="button" onclick="document.getElementById('signin').style.display='none'" class="cancelbtn"> Cancel </button>
						<input type="submit" name="submit" value="Sign in" class="signinbtn">
					</div>
				</form>
			</div>
		</div>
		<div id="register" class="user_modal">
			<span onclick="document.getElementById('register').style.display='none'" class="close" title="Close Modal"> x </span>
			<div class="user_modal_container">
				<ul class="switcher">
					<li onclick="openSignIn()"> Sign in </li>
					<li class="selected"> Register </li>
				</ul>
				<form action="register.php" method="POST">
					<label><b> Username </b></label>
					<input type="text" placeholder="Username" name="username" required>
					<label><b> Password </b></label>
					<input type="password" placeholder="Password" name="password" required>
					<label><b> Re-enter Password </b></label>
					<input type="password" placeholder="Re-Enter Password" name="password-re" required>
					<input type="checkbox" checked="checked"> Remember me
					<div class="clearfix">
						<button type="button" onclick="document.getElementById('register').style.display='none'" class="cancelbtn"> Cancel </button>
						<input type="submit" name="submit" value="Register" class="signupbtn">
					</div>
				</form>
			</div>
		</div>
		<div style="padding:0px 10px">
			<center> <h1> Posts </h1>
<?php
	if($_SESSION['username']) {
?>
			<form action="posts.php" method="POST" style="display:block; padding: 0 0 10px 0">
				<input type="text" placeholder="What's on your mind?" name="content" class="post_input">
				<input type="submit" name="submit" value="Post" class="submitbtn">
				<?php echo $_SESSION['error_message'] ?>
			</form>
<?php } ?>
			<div style="overflow-x: auto">
			<table>
				<?php echo $table; ?>
			</table>
			</center>
			</div>
			<br>

		</div>
	</body>
	<footer>
		<ul class="footer_links">
			<li style="float:left"> A project by Team Dog Icon <img src="coyote.png" alt="Coyote_icon" style="width:20px;hight:20px; filter: invert(100%); padding:0px 0px"></li>
			<li><a href="construction.php"> Feedback </a></li>
			<li><a href="construction.php"> Report a problem </a></li>
			<li><a href="construction.php"> Other Resources </a></li>
		</ul>
	</footer>
</html>
