<?php
	require_once 'includes/config.php'; 
	require_once 'includes/db.php'; 
	include_once 'includes/loadingMainPage.php'; 
	include_once 'includes/pager.php';
?>
<!DOCTYPE HTML>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/media.css">
	<link rel="stylesheet" href="libs/owlcarousel/assets/owl.carousel.css">
	<link rel="stylesheet" href="libs/owlcarousel/assets/owl.theme.default.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:700, Nosifer" rel="stylesheet"> 
	
   <title>САДЫ НИНФА</title>
</head>
<body>
		
	<?php 
		require_once 'includes/header.php';
	?>
	<section class="types-main container">

			<div class="types-sidebar">
				<form>
					
				<?php 
					$full_searching="";
					$coastmin =0;
					$coastmax =9999;
					if(isset($_REQUEST['full_searching'])){$full_searching = $_REQUEST['full_searching'];}
					if(isset($_REQUEST['coastmin'])){$coastmin = $_REQUEST['coastmin'];}
					if(isset($_REQUEST['coastmax'])){$coastmax = $_REQUEST['coastmax'];}
					if($coastmin>$coastmax){
            		    if($coastmax!=0){
                		    $min = $coastmax;
                		    $coastmax = $coastmin;
                		    $coastmin = $min;
            		    }
            		    else{
            		        $coastmax =9999;
            		    }
            		}
				?>
				<div class="coast">
				    <p style="grid-column: 1 / 3; margin: 0px;">Минимальная цена в предложениях магазина:</p>
				<input type="text" name="coastmin" placeholder="0р." id="coastmin" 
				value='<?php 
				    if(trim($coastmin)!=0){
				        echo trim($coastmin);
				    }?>'></input>
				<input type="text" name="coastmax" placeholder="999р." id="coastmax" 
				value='<?
				    if(trim($coastmax)!=9999){
				        echo trim($coastmax);
				    }
				    ?>'></input>
				</div>
				<input type="text" name="full_searching" id="full_searching"  placeholder="наименование" value='<?php echo trim($full_searching);?>'></input>
				<button id="searching_product" style="padding: 0px; width: 100%; margin:0 auto; background: #eec69b; color: #013d45; margin-bottom: 10px;height: 50px;">Поиск</button>
				</form>
				<?php
					getCategory($connection);
				?>
				<?php
					getCategoryMobile($connection);
				?>
			<div>
			
			<!--<div id="result_searching">
				
			</div>-->
		</div>
			</div>
			<div id ="types-content" class="types-content">
				<div id="types-blocks" class="types-blocks">
				<?php
					$array = searching($connection,$config,true);
					echo $array['result_searching'];
				?>
				</div>
				<div id="types-pages" class="types-pages">
					<?php 
						echo $array['pager'];
					?>
						
				</div>
			</div>
	</section>

	<?php 
		require_once 'includes/footer.php';
	?>	
	<script src="js/jquery.min.js"></script>
	<script src="libs/owlcarousel/owl.carousel.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/script.js"></script>
	<script src="js/wow.min.js"></script>
	<!--<script src="js/searching.js"></script>-->
    </script>

	<script>
	  new WOW().init();
	</script>

</body>
</html>