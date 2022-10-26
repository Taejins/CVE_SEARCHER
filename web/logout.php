<?php
	session_start();
    if(isset($_SESSION['Name'])){
    	echo "<script>alert('Logout Success!')</script>";
    	echo "<script>location.replace('index.php');</script>";
     	
     	session_destroy();
    }
    else {
    	echo "<script>alert('비정상적인 접근입니다.')</script>";
    	echo "<script>location.replace('index.php');</script>";
     	session_destroy();	
    }
?>