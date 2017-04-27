<?php
session_start ();
function loginForm() {
    echo '
   <div id="loginform">
   <form action="index.php" method="post">
       <p>Please enter your name to continue:</p>
       <label for="name">Name:</label>
       <input type="text" name="name" id="name" />
       <input type="submit" name="enter" id="enter" value="Enter" />
   </form>
   </div>
   ';
}
 
if (isset ( $_POST ['enter'] )) {
    if ($_POST ['name'] != "") {
        $_SESSION ['name'] = stripslashes ( htmlspecialchars ( $_POST ['name'] ) );
        $fp = fopen ( "log.html", 'a' );
        fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['name'] . " has joined the chat session.</i><br></div>" );
        fclose ( $fp );
    } else {
        echo '<span class="error">Please type in a name</span>';
    }
}
 
if (isset ( $_GET ['logout'] )) {
   
    // Simple exit message
    $fp = fopen ( "log.html", 'a' );
    fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['name'] . " has left the chat session.</i><br></div>" );
    fclose ( $fp );
   
    session_destroy ();
    header ( "Location: index.php" ); // Redirect the user
}
 
?>
<html>
<html>
    <header role="banner" style= "background-color:#626262">
        <section aria-label="main top level navigation section">
            <img alt="Case Western Reserve University est 1826" class="logo" src="https://case.edu/umc/media/template/admin-dept-1/images/logos/cwru-formal-blue-tag.png" style = "height:100px;">
		<link href="../393project.css" rel="stylesheet" type="text/css">
<div id="menu" align="right">

<div id="menu-buttons" align="right">
	<a href="../index1.html">Home</a>
	<a href="../tempforum.html">Forum</a>
	<a href="../syllabus/syllabus.php">Syllabus</a>
	<a href="../assignments.html">Assignments</a>
	<a href="index.php">Messaging</a>
	<a href="../groupstudy.html">Group Study</a>
	<a href="../practice.html">Practice</a>
    
    <div class="dropdown">
		<div class="dropdown-button">
    	<a>Webapps</a>
    	</div>
    	<div class="dropdown-links">
      	<a id="notepad">Notepad</a>
     	<a id="calculator">Calculator</a>
        </div>
    </div>
    
    <a id="logout" href="https://login.case.edu/cas/logout" style="font-size:14px">LOGOUT</a>
</div>

</div>
        </section>
    </header>

<head>

<style>
body {
    font: 12px arial;
    color: white;
    text-align: center;
    padding: 35px;
}
 
form,p,span {
    margin: 0;
    padding: 0;
}
 
input {
    font: 12px arial;
}
 
a {
    color: ##0a304e;
    text-decoration: none;
}
 
a:hover {
    text-decoration: underline;
}
 
#wrapper,#loginform {
    margin: 0 auto;
    padding-bottom: 25px;
    background: #0a304e;
    width: 504px;
    border: 1px solid #ACD8F0;
}
 
#loginform {
    padding-top: 18px;
}
 
#loginform p {
    margin: 5px;
}
 
#chatbox {
    text-align: left;
    margin: 0 auto;
    margin-bottom: 25px;
    padding: 10px;
    background: lightblue;
    height: 270px;
    width: 430px;
    border: 1px solid #ACD8F0;
    overflow: auto;
}
 
#usermsg {
    width: 395px;
    border: 1px solid #ACD8F0;
}
 
#submit {
    width: 60px;
}
 
.error {
    color: ##0a304e;
}
 
#menu {
    padding: 12.5px 25px 12.5px 25px;
}
 
.welcome {
    float: left;
}
 
.logout {
    float: right;
}
 
.msgln {
    margin: 0 0 2px 0;
}
</style>
</head>

<body>
<br>
<br>
    <?php
    if (! isset ( $_SESSION ['name'] )) {
        loginForm ();
    } else {
        ?>
<div id="wrapper">
        <div id="menu">
            <p class="welcome">
                Welcome, <b><?php echo $_SESSION['name']; ?></b>
            </p>
            <p class="logout">
                <a id="exit" href="#">Exit Chat</a>
            </p>
            <div style="clear: both"></div>
        </div>
        <div id="chatbox"><?php
        if (file_exists ( "log.html" ) && filesize ( "log.html" ) > 0) {
            $handle = fopen ( "log.html", "r" );
            $contents = fread ( $handle, filesize ( "log.html" ) );
            fclose ( $handle );
           
            echo $contents;
        }
        ?></div>
 
        <form name="message" action="">
            <input name="usermsg" type="text" id="usermsg" size="63" /> <input
                name="submitmsg" type="submit" id="submitmsg" value="Send" />
        </form>
    </div>
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});
 
//jQuery Document
$(document).ready(function(){
    //If user wants to end session
    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit==true){window.location = 'index.php?logout=true';}     
    });
});
 
//If user submits the form
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php", {text: clientmsg});             
        $("#usermsg").attr("value", "");
        loadLog;
    return false;
});
 
function loadLog(){    
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url: "log.html",
        cache: false,
        success: function(html){       
            $("#chatbox").html(html); //Insert chat log into the #chatbox div  
           
            //Auto-scroll          
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }              
        },
    });
}
 
setInterval (loadLog, 100);
</script>
<?php
    }
    ?>
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
</script>

<footer>
     &copy; anr41, avb27, emf65, rxr353
 </footer>
 
 <script>
var notepadButton = document.getElementById("notepad");
var calculatorButton = document.getElementById("calculator");

var notepad = function(){
	var myWindow = window.open("../notepad.html", "", "width=400, height=600")
};

var calculator = function() {
	var myWindow = window.open("../calculator.html", "", "width=400, height=400")	
};

notepadButton.addEventListener("click", notepad);
calculatorButton.addEventListener("click", calculator);
</script>

</body>
</html>

