<html>
<head>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/style.css">
<link rel="stylesheet" media="screen and (max-width: 1200px) and (min-width: 0px)" type="text/css" href="<?php echo base_url(); ?>css/styleresponsive1.css">
<link rel="stylesheet" media="screen and (max-width: 600px) and (min-width: 0px)" type="text/css" href="<?php echo base_url(); ?>css/styleresponsive2.css">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="main">
<div id="envelope">
<?php if (isset($authUrl)){ ?>
<header id="sign_in">
<h2>CodeIgniter Login With Google Oauth PHP</h2>
</header>
<hr>
<div id="content">
<center><a href="<?php echo $authUrl; ?>"><img id="google_signin" src="<?php echo base_url(); ?>images/google_login.jpg" width="100%" ></a></center>
</div>
<?php }else{ ?>
<header id="info">
<a target="_blank" class="user_name" href="<?php echo $userData->link; ?>" /><img class="user_img" src="<?php echo $userData->picture; ?>" width="15%" />
<?php echo '<p class="welcome"><i>Welcome ! </i>' . $userData->name . "</p>"; ?></a><a class='logout' href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=<?php echo base_url(); ?>index.php/user_authentication/logout'>Logout</a>
</header>
<?php
echo "<p class='profile'>Profile :-</p>";
echo "<p><b> First Name : </b>" . $userData->given_name . "</p>";
echo "<p><b> Last Name : </b>" . $userData->family_name . "</p>";
echo "<p><b> Gender : </b>" . $userData->gender . "</p>";
echo "<p><b>Email : </b>" . $userData->email . "</p>";
?>
<?php }?>
</div>
</div>
<style>
body {
margin:0;
padding:0;
font-family:raleway;
background-image: url(../images/repeat-bg.png);
}
#main{
width: 65%;
height: 100%;
margin-left: 17%;
margin-top: 5%;
position: relative;
}
h2{
font-family:raleway;
}
div#envelope{
position: relative;
width: 51%;
border: 1px solid #CFCFD0;
border-radius: 10px;
background-color: #FFFFFF;
}
div#content{
width: 100%;
padding:12px auto;
overflow: hidden;
word-break: break-all;
overflow-wrap: break-word;
border-radius: 0 0 10px 10px;
}
header#sign_in{
font-family:raleway;
background-color: #079BAE;
text-align: center;
padding-top: 12px;
padding-left: 5px;
padding-bottom: 8px;
margin-bottom: -8px;
border-radius: 10px 10px 0 0;
color: white;
}
header#info{
font-family:raleway;
background-color: #079BAE;
margin-top: -11px;
padding-top:15px;
padding-bottom: 42px;
padding-left: 15px;
padding-right: 15px;
font-size: 16px;
border-radius: 10px 10px 0 0;
color: white;

}
header#info a.user_name{
font-family:raleway;
text-decoration: none;
color:white;
}
div.logout{
padding-top: 30px;
float:right;
}
a.logout{
font-family:raleway;
font-size: 20px;
font-weight: 600;
text-decoration: none;
padding-right: 0 auto;
float:right;
color:white;
}
p {
padding: 0 25px;
}
p.profile {
font-weight: bold;
font-size: 20px;
}
img.user_img{
border-radius:50% 50% 50% 50%;
border:3px solid white;
}
p.welcome{
margin-top: -50px;
margin-left: 12%;
}
</style>
</body>
</html>