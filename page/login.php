<?php

	require_once("../../../config.php");
	$database = "if15_Harri_3";
	$mysqli = new mysqli($servername, $username, $password, $database);
	// LOGIN.PHP
	// echo $_POST["email"];


	$email_error = "";
	$password_error = "";

	$email = "";
	$password = "";


	$name1_error = "";
	$name2_error = "";
	$username_error = "";
	$email1_error = "";
	$email2_error = "";
	$password1_error = "";
	$password2_error = "";
	$pmatch_error  = "";
	$ematch_error  = "";

	$name1 = "";
	$name2 = "";
	$username = "";
	$email1 = "";
	$email2 = "";
	$password1 = "";
	$password2 = "";


	if($_SERVER["REQUEST_METHOD"] == "POST") {		
		if (isset($_POST["login"])) {
				// echo "Sisse loggimine  ";
			if (empty($_POST["email"]) )  {
				$email_error = "see väli on kohustuslik";
			}else{

				$email = test_input($_POST["email"]);

			}	
			if (empty($_POST["password"]) )  {
				$password_error = "see väli on kohustuslik";
			}else{
				$email = test_input($_POST["email"]);
			}	
				if($email_error == "" && $password_error ==""){
				// echo "Loggiti sisse! username on ".$username." ja password on ".$password;
			
				$hash = hash("sha512", $password);
				
				$stmt = $mysqli->prepare("SELECT id, email FROM user_reg WHERE email=? AND password=?");
				$stmt->bind_param("ss", $email, $hash);
				
				//muutujad tulemustele
				$stmt->bind_result($id_from_db, $email_from_db);
				$stmt->execute();
				
				//Kontrollin kas tulemusi leiti
				if($stmt->fetch()){
					// ab'i oli midagi
					echo "Loggiti sisse !! Email ".$email." ja password õiged, kasutaja id=".$id_from_db;
				}else{
					// ei leidnud
					echo "Vale username või password!";
				}
				
				$stmt->close();
				
				
			}
					
		}
	}
	function test_input($data) {
		// võtab ära tühikud, enterid, tabid
		$data = trim($data);
		// tagurpidi kaldkriipsud \ 
		$data = stripslashes($data);
		// teeb html'i tekstiks < läheb &lt;
		$data = htmlspecialchars($data);
		return $data;
	}
		


	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST["registreeru"])) {
			// echo "Registreerumine ";

			if (empty($_POST["name1"]) )  {
				$name1_error = "see väli on kohustuslik";
			}else{
				$name1 = test_input($_POST["name1"]);
			}
			if (empty($_POST["name2"]) )  {
				$name2_error = "see väli on kohustuslik";
			}else{
				$name2 = test_input($_POST["name2"]);
			}
			if (empty($_POST["username"]) )  {
				$username_error = "see väli on kohustuslik";
			}else{
				$username = test_input($_POST["username"]);
			}
			if (empty($_POST["email1"]) )  {
				$email1_error = "see väli on kohustuslik";
			}else{
				$email1 = test_input($_POST["email1"]);
			}
			if (empty($_POST["email2"]) )  {
				$email2_error = "see väli on kohustuslik";
			}
			if ($_POST['email1']!= $_POST['email2'])
			 {
			     $ematch_error = "Emailid ei ühtinud!!!!   ";
			}else{
				$email2 = test_input($_POST["email2"]);
			}
			if ($_POST['password1']!= $_POST['password2'])
			 {
			     $pmatch_error = "passwordid ei ühtinud!!!!! ";
			 }
			if (empty($_POST["password1"]) )  {
				$password1_error = "see väli on kohustuslik";
			} 		
			if (empty($_POST["password2"]) )  {
				$password2_error = "see väli on kohustuslik";
			} else {
				//siis pole password tyhi
				if(strlen($_POST["password2"]) < 8)	{
					$password2_error = "Peab olema vähemalt 8 tähemärki pikk!";
				}
				if(strlen($_POST["password1"]) < 8)	{
					$password1_error = "Peab olema vähemalt 8 tähemärki pikk!";


				}
			}
							if(	$email1_error == "" && $email2_error == "" && $username_error == "" && $password1_error == "" && $password2_error == "" && $name1_error == "" && $name2_error == "" && $pmatch_error == ""&& $ematch_error == ""){
			
			// räsi passwordist, mille salvestame ab'i
			$hash = hash("sha512", $password1);

			
			
			echo "Registreerisid kasutaja! username on ".$username." ja password on Õige  ja räsi on ".$hash;
			
			//Salvestame AB'i
			$stmt = $mysqli->prepare("INSERT INTO user_reg (firstname, lastname, username, email, password) VALUES (?,?,?,?,?)");
			//echo $mysqli->error;
			//echo $stmt->error;
			
			
			// asendame ? märgid, ss - s on string email, s on string password
			$stmt->bind_param("sssss", $name1, $name2, $username, $email1, $hash);
			$stmt->execute();
			$stmt->close();
		}	
		}	
	}		
?>










<?php


	// avaleht
	$page_title = "avaleht";
	$page_file_name = "login.php";
?>
<?php require_once("../header.php"); ?>

	<h2>log in</h2>
		
		<form action="login.php" method="post">
		<input name="email"e type="email" placeholder = "email"> <?php echo $email_error;  ?><br><br>
		<input name="password" type="password" placeholder = "parool"> <?php echo $password_error;  ?><br><br>
		<input type="submit" value="login" name="login">
		</form>

	<h2>Registreeru</h2>

		<form action="login.php" method="POST"><br><br>
		<input name="name1" type="text" placeholder="eesnimi" /><?php echo $name1_error;  ?><br><br>
		<input name="name2" type="text" placeholder="perekonna nimi" /><?php echo $name2_error;  ?><br><br>
		<input name="username" type="text" placeholder="kasutajanimi" /><?php echo $username_error;  ?><br><br>
		<input name="email1" type="email" placeholder="Email" /><?php echo $ematch_error;  ?><?php echo $email1_error;  ?><br><br>
		<input name="email2" type="email" placeholder="uuesti Email" /><?php echo $email2_error;  ?><br><br>
		<input name="password1" type="password" placeholder="parool" /><?php echo $pmatch_error;  ?><?php echo $password1_error;  ?><br><br>
		<input name="password2" type="password" placeholder="uuesti parool" /><?php echo $password2_error;  ?><br><br>
		<input type="submit" value="Registreeri" name="registreeru" /><br><br>



<h2>MVP teemaks luua kasutajate põhine anonüümne vestlus portaal ajax päringutega</h2>














