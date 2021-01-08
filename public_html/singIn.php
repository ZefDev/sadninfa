<?php
    require_once 'includes/db.php'; 
	require_once 'includes/config.php'; 
	require_once 'includes/loadingMainPage.php'; 
?><!DOCTYPE HTML>
<head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/style1.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/media.css">
	<link rel="stylesheet" href="libs/owlcarousel/assets/owl.carousel.css">
	<link rel="stylesheet" href="libs/owlcarousel/assets/owl.theme.default.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:700, Nosifer" rel="stylesheet"> 

   <title>САД НИНФА</title>
</head>
<body>
	<?php 
		require_once 'includes/header.php';
	?>
	<section class="login-main container" >
			<?php 
				function validation($connection,$param){
					$param = trim($param); 
			   	 	$param = mysqli_real_escape_string($connection,$param);
			    	$param = htmlspecialchars($param);
			    	return $param;
		    	}
			?>
			<?php  $errors = array();
			    if(trim($_REQUEST['login']) == ''){
			    	$errors[]= 'Введите логин!';
			    }
			    if($_REQUEST['password'] == ''){
			    	$errors[]= 'Введите пароль!';
			    }
			    if(empty($errors)){
			    	$login = validation($connection,$_REQUEST['login']); 
					$password = validation($connection,$_REQUEST['password']);
					$query = "select * from user where login = '$login'";
					$result = mysqli_query($connection, $query);
					if ($result){
						while ($row = mysqli_fetch_assoc($result)) {
							//if(password_verify($password, $row['password'])){
							if(($row['password']==$password) & ($row['login']==$login) ){
								$_SESSION['loginUser'] = $row['login'];
								echo '<script type="text/javascript">'; 
	                            echo "window.location.href='controlPanel.php';";
	                            echo '</script>'; 
							}
							else{
								$errors[]= 'Неверно заполнен логин или пароль!';
							}
						}
						
					}
			    }
			    else{
			        
			    }
		?>
			<form method="POST" action="singIn.php">
		    <div class="logpas">
		        <div class="user"><img src="img/user.png" alt=""></div>
    			<div class="log"><input type="text" name="login" placeholder="логин" value="<?php if(isset($_REQUEST['login'])){echo $_REQUEST['login'];}?>"></div>
    			<div class="pas"><input type="password" name="password" placeholder="пароль" value="<?php if(isset($_REQUEST['password'])){echo $_REQUEST['password'];}?>"></div>
    			<div class="vhod"><input type="submit" name="doGo" value="Войти"></div>	
			</div>
			<?php 
			    if(isset($errors[0]) & isset($_REQUEST['doGo'])){
			        echo "<p style='text-align: center;
color: red;'>".$errors[0]."</p>";
			    }
			
			?>
		</form>
	</section>
	<?php 
		require_once 'includes/footer.php';
	?>	
	<script src="js/jquery.min.js"></script>
	<script src="libs/owlcarousel/owl.carousel.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/script.js"></script>
	<script src="js/wow.min.js"></script>
    </script>

	<script>
	  new WOW().init();
	</script>

	</body>
</html>