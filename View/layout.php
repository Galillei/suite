<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT" />
<meta http-equiv="Pragma" content="no-store" />
<html>
<head>

    <title>Static web-site</title>
    <link type="text/css" rel="stylesheet" href="/css/style.css"/>
    <script type="text/javascript" src="/js/validation.js"></script>
</head>
<body>
<div class="header">
    <div class="company-name">
       <?php if (isset($_SESSION['name'])){
	   echo '<h1>ACME Corporation</h1>';
	   }
	   else {
	   echo 'ups';
	   }
	   ?>
    </div>
    <div class="company-logo">
        <img src="/images/logo.jpg" alt="ACME Corp."/>
    </div>
</div>
<div class="content">
    <div class="nav">
        <ul class="nav-list">

            <li><a href="/index/files"> Your files</a></li>
<?php if(isset($_SESSION['name'])){ echo '<li><a href="/Users/users">Show users</a></li>';}?>
            <li><a href="/index/registerUser">Register</a></li>
        <?php if(isset($_SESSION['name'])){ echo '<li><a href="/index/logFile">View logfile</a></li>';}?>
          <?php if(isset($_SESSION['name'])){
        echo '<li><a href="/index/logOut">Log Out</a></li>';
        }
            else{
              echo '<li><a href="/index/logIn">Log In</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="main">
        <?php echo($this->renderContent()); ?>
    </div>
    <div class="cleaner"/>
</div>
<div class="footer">
    <div class="copyright">Copyright 2012 Acme Inc.</div>
    <div class="f-links"><a href="about.html">About US</a><a href="terms.html">Terms & Conditions</a></div>
</div>
</body>
</html>