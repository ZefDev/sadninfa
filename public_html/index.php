<?php
		require_once 'includes/config.php'; 
		require_once 'includes/db.php'; 
		require_once 'includes/loadingMainPage.php'; 
		require_once 'includes/pager.php';
		require_once 'includes/workingWithUser.php';
?>

<!DOCTYPE HTML>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/media.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:700, Nosifer" rel="stylesheet"> 
     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script>
    	if(window.navigator.userAgent.indexOf('Trident/7.0')!=-1)  
	    {
	        location.replace("http://discount-svitanak.by/old_browser.html");
	    }
	    else if(window.navigator.userAgent.indexOf('Edge')!=-1)
	    {
	        location.replace("http://discount-svitanak.by/old_browser.html");
	    }
	    window.addEventListener("orientationchange", function() {
        // Выводим числовое значение ориентации
            location.reload();
        }, false);

    	$(document).ready(function(){
    	var flag =true;	
        $("#btn-open-menu").click(function(){
        	//alert("Нажал");
            $("#m").slideToggle("slow");
            $(this).toggleClass("active");
            return false;
        });
    });
    </script>
   <title>САДЫ НИНФА</title>
</head>
<body>
		
	<header>
		<div class="header-content container">
		<div class="logo">
			<img src="img/logo3.png" alt="">
		</div>
		<div class="mob-menu">
		   <a href="#" id="btn-open-menu"><img src="img/menu.png" alt=""></a>
		</div>
		<div id="m" class="menu">
			<ul >
				<li><a href="index.php">ГЛАВНАЯ</a></li>
				<li><a href="dostavka.php">ДОСТАВКА</a></li>
				<li><a href="types.php">КАТЕГОРИИ</a></li>
				<li><a href="contacts.php">КОНТАКТЫ</a></li>
				<li ><a href="#openModal2">ОБРАТНЫЙ ЗВОНОК</a></li>
				<?php
					if(isset($_SESSION['loginUser'])){
						echo "<li id='myroom'><a href='controlPanel.php'>".$_SESSION['loginUser']."</a></li>";
					}
					else {
						echo "<li id='myroom'><a href='singIn.php'>Войти</a></li>";
					}
					
				?>
			</ul>
		</div>
		</div>
		<div class="window container">
			<h1>КРУГЛОСУТОЧНАЯ ДОСТАВКА ЦВЕТОВ КУРЬЕРОМ НА ДОМ</h1>
			<div class="button">
			<a href="dostavka.php">ПОДРОБНЕЕ</a>
			</div>
		</div>
	</header>
	<section class="main container">
		<div class="new">
			<div class="new-title">
				<h1>НОВИНКИ</h1>
			</div>
			<div class="new-slider" id="new-slider">
				<?php 
					$array = reload_new_slider($connection,$config,true);
				?>
				<div class='new-prev' >
					<?php 
						echo $array['new_prev'];
					?>
				</div>
				<div id="new-boxes" class="new-boxes wow fadeIn">
					<?php 
						echo $array['new_slider'];
					?>
				</div>
				<div class='new-next' >
					<?php 
						echo $array['new_next'];
					?>
				</div>

			</div>
		</div>
		<div class="popular">
			<div class="new-title">
				<h1>ПОПУЛЯРНЫЕ</h1>
			</div>
			<div class="new-slider" id="popular-slider">
				<?php 
					$array = reload_populer_slider($connection,$config,true);
				?>
				<div class='new-prev' >
					<?php 
						echo $array['popular_prev'];
					?>
				</div>
				<div id="popular-boxes" class="new-boxes">
					<?php 
						echo $array['popular_slider'];
					?>
				</div>
				<div class='new-next' >
					<?php 
						echo $array['popular_next'];
					?>
				</div>
			</div>
		</div>
		<?php 
		    require_once 'includes/backcall.php';
        ?>
	</section>
	
		
	
	<?php 
		require_once 'includes/footer.php';
	?>	
	<script src="js/jquery.min.js"></script>
	<script src="libs/owlcarousel/owl.carousel.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/script.js"></script>
	<script src="js/scriptForSliders.js"></script>
	

</body>
</html>