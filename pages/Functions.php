<?php
function connect($host='localhost', $user='root', $pass='', $dbname='TouristAgency')
	{ 
		$mysqli = @new mysqli($host, $user, $pass, $dbname);
		if ($mysqli->connect_errno) 
		{
			die('Error connection: ' . $mysqli->connect_errno);
		}
		$mysqli->query("set names 'utf8'"); 
		return $mysqli;
	}
	
	function register($name,$pass,$pass2,$email)
	{ 
		$name=trim(htmlspecialchars($name)); 
		$pass=trim(htmlspecialchars($pass)); 
		$pass2=trim(htmlspecialchars($pass2)); 
		$email=trim(htmlspecialchars($email)); 
		if ($name=="" || $pass=="" || $pass2=="" || $email=="") 
		{  
			echo "<h3/><span style='color:red'> Fill All Required Fields! </span><h3/>";  
			echo "<script>";
			echo "setTimeout('window.location=document.URL', 2000)";
			echo "</script>";
			return false;   
		} 
		if (strlen($name)<6 || strlen($name)>30 ||
			strlen($pass)<6 || strlen($pass)>30) 
		{  
				echo "<h3/><span style='color:red;'> Values Length Must Be Between 6 And 30! </span><h3/>";  
				echo "<script>";
				echo "setTimeout('window.location=document.URL', 2000)";
				echo "</script>";
				return false;   
		} 
		if ($pass != $pass2)
		{  
				echo "<h3/><span style='color:red;'> Passwords do not match! </span><h3/>";  
				echo "<script>";
				echo "setTimeout('window.location=document.URL', 2000)";
				echo "</script>";
				return false;   
		}
		$ins='insert into users (login,pass,email,roleid) values("'.$name.'","'. md5($pass).'","'.$email.'",2)'; 
		$mysqli = connect(); 
		 
		if (!$mysqli->query($ins)) 
		{
			if($mysqli->errno==1062)  
				echo "<h3/><span style='color:red;'> This Login Is Already Taken! </span><h3/>";  
			else  
				echo "<h3/><span style='color:red;'> Error code:".$mysqli->errno."!</ span><h3/>";  
			echo "<script>";
			echo "setTimeout('window.location=document.URL', 2000)";
			echo "</script>";
			return false; 
		} 
		return true;
	}
	
	function login($name,$pass) 
	{ 
		$name=trim(htmlspecialchars($name)); 
		$pass=trim(htmlspecialchars($pass)); 
		if ($name=="" || $pass=="")  
		{  
			echo "<h3/><span style='color:red;'> Fill All Required Fields!</span><h3/>";  
			echo "<script>";
			echo "setTimeout('window.location=document.URL', 2000)";
			echo "</script>";	
			return false; 
		} 
		if (strlen($name)<6 || strlen($name)>30 || strlen($pass)<6 || strlen($pass)>30) 
		{  
			echo "<h3/><span style='color:red;'> Value Length Must Be Between 6 And 30! </span><h3/>";
			echo "<script>";
			echo "setTimeout('window.location=document.URL', 2000)";
			echo "</script>";			
			return false; 
		} 
		$mysqli = connect(); 
		$sel='select * from users where login="'.$name.'" and pass="'.md5($pass).'"'; 
		$res=$mysqli->query($sel);
		if($row=mysqli_fetch_array($res, MYSQLI_NUM))
		{  
			$_SESSION['ruser']=$name;  
			if($row[4]==1)
			{
				$_SESSION['radmin']=$name;  
			} 
			mysqli_free_result($res);			
			return true; 
		} 
		else 
		{  
			mysqli_free_result($res);
			echo "<h3/><span style='color:red;'> No Such User!</span><h3/>";
			echo "<script>";
			echo "setTimeout('window.location=document.URL', 2000)";
			echo "</script>";			
			return false; 
		} 
	} 
?>