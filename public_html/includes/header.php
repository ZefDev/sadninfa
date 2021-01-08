<?php 
		require_once 'backcall.php';
?>
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
        
         function clickCategory(id){
        	var full_searching = document.getElementById('full_searching').value;
        	var coastmin = document.getElementById('coastmin').value;
        	var coastmax = document.getElementById('coastmax').value;
        	location.replace("http://localhost/flowers/types.php?category="+id+"&full_searching="+full_searching+"&coastmin="+coastmin+"&coastmax="+coastmax);
        }

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
	<header id="types-header">
		<div class="header-content container">
		<div class="logo">
			<img src="img/logo3.png" alt="">
		</div>
		<div class="mob-menu">
		   <a href="#" id="btn-open-menu"><img src="img/menu.png" alt=""></a>
		</div>
		<div class="menu" id="m">
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
	</header>
