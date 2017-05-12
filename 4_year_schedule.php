<?php
session_start();
require_once 'config.php';
$conn = new mysqli($DB_SERVER,$DB_USERNAME,$DB_PASSWORD,$DB_DATABASE);

if($conn->connect_error) die($conn->connect_error);
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

function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function query($query,$conn)
{
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
//view_all function
function view_all($conn)
{
    $topic_input = "Biology";
    $semester_input = 'Fall';
    $year_input = 2019;
    
    if($_POST['submit']) {
        //data values
        $topic_input=clean_input($_POST['topic']);
        $semester_input=clean_input($_POST['semester']);
        $year_input=clean_input($_POST['year']);
    }
    
    //View all quer
    $query = "SELECT course,title,instructor, credits,class_days,semester, year,topic,start_time,end_time FROM schedule WHERE semester = '$semester_input' AND year = $year_input AND topic='$topic_input'";
    $result = query($query,$conn);
    $rows = $result->num_rows;
    //View all table
    $table = '<tr>'.'<th>Course</th><th>Title</th><th>Credits</th><th>Class Days</th><th>Start Time</th><th>End Time</th><th>Instructor</th><th>Semester</th><th>Year</th>'.'</tr>';
    for($j=0;$j<$rows;$j++)
    {
        $result->data_seek($j);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $table = $table.'<tr><td>'.$row['course'].'</td>'.'<td>'.$row['title'].'</td>'.'<td>'.$row['credits'].'</td>'.'<td>'.$row['class_days'].'</td>'.'<td>'.$row['start_time'].'</td>'.'<td>'.$row['end_time'].'</td>'.'<td>'.$row['instructor'].'</td>'.'<td>'.$row['semester'].'</td>'.'<td>'.$row['year'].'</td></tr>';
    }
    return $table;
}

//call view_all
$table = view_all($conn);
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="main_stylesheet.php">
    <title>Class Search</title>

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

    <style>
      input[type=text] {
        max-width: 250px;
      }
      
      .box {
        display: block;
      }
    </style>

  </head>

  <body onload="<?php echo $onload ?>; startTime()">
    <nav>
      <ul class="navbar">
        <li><a href="http://52.36.44.103/" class="navbtn"> Home </a></li>
        <li><a href="https://login.microsoftonline.com/login.srf?wa=wsignin1.0&rpsnv=4&ct=1490943806&rver=6.7.6640.0&wp=MCMBI&wreply=https%3a%2f%2fportal.office.com%2flanding.aspx%3ftarget%3d%252fdefault.aspx&lc=1033&id=501392&msafed=0&client-request-id=dc28fab0-ca54-436e-8774-a8e23944b6e2"
          class="navbtn"> Yote Mail </a></li>
        <li><a href="https://cofi.instructure.com/login/ldap" class="navbtn"> Canvas </a></li>
        <li><a href="#" class="navbtn active"> 4 Year Schedule </a></li>
        <div style="float:right; border-left:2px solid #222">
          <?php
if($_SESSION['username']) {
    ?>
            <li><a href="#" class="navbtn"> My Profile </a></li>
            <li><a href="home.php?action=logout" class="navbtn"> Log out </a></li>
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
    header("Location: home.php");
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
          <p><a href="#"> Forgotten Password? </a></p>
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
    <center>
      <!-- Search for a class-->
      <div>
        <h3>Search For a Class</h3>
        <form method="post">
          <label>Topic: </label>
          <input type="text" name="topic" class="box" required>
          <label>Semester: </label>
          <input type="text" name="semester" class="box" required>
          <label>Year: </label>
          <input type="text" name="year" class="box" required>
          <input type="submit" name="submit" value="Submit" class="submitbtn">
        </form>
      </div>
      <!-- View all books -->
      <div>
        <table width="100%" align="center">
          <?php echo $table; ?>
        </table>
      </div>
    </center>
  </body>
  <footer>
    <ul class="footer_links">
      <li style="float:left"> A project by Team Dog Icon <img src="dog.png" alt="Dog_icon" style="width:20px;hight:20px; filter: invert(100%); padding:0px 0px"></li>
      <li><a href="#"> Feedback </a></li>
      <li><a href="#"> Report a problem </a></li>
      <li><a href="#"> Other Resources </a></li>
    </ul>
  </footer>

  </html>
