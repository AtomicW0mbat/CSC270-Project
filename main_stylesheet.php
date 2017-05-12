<?php
	header("Content-type: text/css; charset UTF-8"); //Change the content type back to CSS.
	// Colors
	$color_1 = "#7B1FA2";
	$color_2 = "#BA68C8";
	$background = "#FEFEFE";
	$highlight = "#BA68C8";
?>

/*Now write regular CSS code and use any PHP variable defined in the PHP secton above.*/


/*************************************Prep*************************************/
/*Define the behavior of these elements for browsers that don't have it 
  already set */
article, aside, footer, header, main, nav, section {
	display: block;
}

/*The default spacing of these (and most) elements are not 0. Lets set them to
  0 so that we can have the most control over our elements.*/
html, body, ul, li, a, p, article, asside, footer, header, main, nav, section {
	list-style-type: none;
	padding: 0;     /*One argument:   (all sides)
                          Two arguments:  (top/bottom) (left/right)
                          Four arguments: (top) (right) (bottom) (left)*/
	margin: 0;
}
/******************************************************************************/

body {
	/*#333 is read as #333333. #123 would become #112233.*/
	background-color: <?php echo $background; ?>;
	font-family: "Georgia", serif;
	padding: 40px 0 0 0;
}


.navbar {
	background-color: <?php echo $color_1; ?>;
	height: 47px;
	overflow: hidden;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.3);
  
	/*Keep the nav bar at the top of the page as the user scrolls*/
	position: fixed;
	top: 0;
	width: 100%;
	z-index: 1;
}

.navbar li {
	float: left;
	padding: 4px 5px;
}

.navbtn {
	background-color: <?php echo $color_1; ?>;
	color: white;
  
	/*Makes the whole link area clickable, not just the text.*/
	display: block;
	padding: 10px 11px;
	border-radius: 6px;
	text-decoration: none;
	cursor: pointer;

	transition: background-color 0.2s;
}

.navbtn:hover {
	background-color: <?php echo $highlight; ?>;
	color: black;
}

.active {
	background-color: <?php echo $highlight; ?>;
	color: black;
}

#time {
  bakcground-color: <?php echo $color_1; ?>;
  color: white;
  font-family: "Lucida Console", Monaco, monospace;
  font-size: 18px;
  font-weight:550;
  display: block;
  padding: 8px 11px;
  margin: 0;
  text-decoration: none;
  //border-right: 2px solid #222;
}

.user_modal {
	display: none;
	position: fixed;
	z-index: 1;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	overflow: auto;
	background-color: rgb(0,0,0);
	background-color: rgba(0,0,0,0.4);
	padding-top: 50px;
}

.close {
	background-color: <?php echo $color_1; ?>;
	color: white;
	font-size: 40px;
	font-weight: bold;
	position: absolute;
	right: 35px;
	top: 47px;
	padding: 0px 16px 5px;
	border-radius: 6px;

	transition: background-color 0.2s;
}

.close:hover, .close:focus {
	background-color: <?php echo $highlight; ?>;
	color: black;
	cursor: pointer;
}

.user_modal_container {
	background-color: <?php echo $background; ?>;
	margin: 5% auto 15% auto;
	width: 60%;
	max-width: 500px;
	border-radius: 8px;
}

.user_modal_container .switcher li {
	background-color: <?php echo $color_2; ?>;
	color: white;
	font-weight: bold;
	text-align: center;
	font-size: 120%;
	width: 50%;
	float: left;
	padding: 20px 0px;
	cursor: pointer;
}

.user_modal_container .switcher li:first-child {
	border-radius: 8px 0px 0px 0px;
}

.user_modal_container .switcher li:last-child {
	border-radius: 0px 8px 0px 0px;
}

.user_modal_container .switcher .selected {
	background-color: <?php echo $background; ?>;
	color: black;
}

.user_modal_container form {
	padding: 75px 16px 16px 16px;
}

input[type=text], input[type=password] {
	display: inline-block;
	background-color: #DDD;
	margin: 6px 0;
	width: 100%;
	padding: 12px 20px;
	border: 3px solid #444;
	border-radius: 6px;
	box-sizing: border-box;
	color: black;

	transition: background-color 0.2s, border 0.2s;
}

input[type=text]:focus, input[type=password]:focus {
	background-color: <?php echo $background; ?>;
	color: black;
	border: 3px inset #777;
}

.user_modal_container form p a {
	color: black;
	font-weight: bold;
	font-size: 80%;
	float: right;
	padding: 0px 3px;
}

.cancelbtn, .signupbtn, .signinbtn {
        color: white;
        font-size: 110%;
       	margin: 8px 0px;
        width: 50%;
        padding: 14px 20px;
        border: none;
       	border-left: 1px solid #fefefe;
        border-radius: 0px 6px 6px 0px;
        cursor: pointer;
        float: left;
}

.signupbtn, .signinbtn {
        background-color: #4caf50;
        border-left: 1px solid #fefefe;
        border-radius: 0px 6px 6px 0px;
}

.cancelbtn {
        background-color: #f44336;
       	border-right: 1px solid #fefefe;
        border-radius: 6px 0px 0px 6px;
}


.cancelbtn: hover {
	background-color: #db3c30;
}

.clearfix::after {
	display: table;
	content:"";
	clear: both;
}

.post_input {
	max-width: 500px;
	display: block;
}

.submitbtn {
	padding: 10px;
}

table {
	border-collapse: collapse;
	width: 95%;
}

th, td {
	text-align: left;
	padding: 8px;
}

tr:nth-child(even) {
	background-color: #f2f2f2;
}

th {
	background-color: <?php echo $color_1 ?>;
	color: white;
	border-right: 2px solid #222;
}

th:last-child {
	border: none;
}

footer {
	padding: 28px 0px 28px 16px;
	background: <?php echo $color_1 ?>; /*For browsers that do not support gradients.*/
	background: -webkit-linear-gradient(<?php echo $color_1; ?>,<?php echo $color_2; ?>); /*For Safari 5.1 to 6.0.*/
	background: -o-linear-gradient(<?php echo $color_1; ?>,<?php echo $color_2; ?>); /*For Opera 11.1 to 12.0.*/
	background: -moz-linear-gradient(<?php echo $color_1; ?>,<?php echo $color_2; ?>); /*For Firefox 3.6 to 15.*/
	background: linear-gradient(<?php echo $color_1; ?>,<?php echo $color_2; ?>); /*Standard syntax.*/
	color: white;
}

.footer_links {
	overflow: hidden;
}

.footer_links li {
	float: right;
}

.footer_links li a {
	background-color: none;
	color: white;
	display: block;
	padding: 10px 16px;
	text-decoration: none;
	border-radius: 6px;
	cursor: pointer;

	transition: background-color 0.2s;
}

.footer_links li a:hover {
	background-color: <?php echo $highlight; ?>;
	color: black;
}
