<?php require_once 'includes/config.php'; 
		require_once 'includes/db.php';
		include_once 'includes/workingWithBase.php'; 
		include_once 'includes/pagerCub.php';?> 
<html>
	<head>
   <meta charset="utf-8">
   <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/media.css">
	<link rel="stylesheet" href="libs/owlcarousel/assets/owl.carousel.css">
	<link rel="stylesheet" href="libs/owlcarousel/assets/owl.theme.default.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:700, Nosifer" rel="stylesheet"> 
	<?php
		include_once 'includes/config.php'; 
		include_once 'includes/db.php'; 
	?>

		<title>Главная</title>
		
		<link rel="stylesheet" href="css\style1.css">
		<script src="js\script1.js"></script>
		  <?php 
		require_once 'includes/header.php';
	?>
	</head>
	<body>
	    <section class="types-main container" style="grid-template-columns: 1fr;">
		<?php
		if (isset($_SESSION['loginUser'])){
		
			?>
		<div id="openModal" class="modalDialog">
			    <div class="special_krest">
				    <a href='#close' title='Закрыть' class='close'>X</a>
				<div class="modal" id="modal">
					<form enctype="multipart/form-data" method="POST" action="controlPanel.php"	>
					    <div class="mod-block">
					    <div class="mod-block1">
						<input type="text" placeholder="код" id="codModal" name="codModal" style="display: none;">
						<input type="text" placeholder="наименование" name="nameModal" id="nameModal" style="margin-bottom: 10px; width: 230px;padding: 10px;"><br>
						<input type="text" name="coastModal" id="coastModal" placeholder="0.00" pattern="\d+(\.\d{2})?" style="margin-bottom: 10px;width: 230px;padding: 10px;" value="0.00"><br>
                        
						<select id="selectСategoryModal" name = "categoryModal" style="width: 230px;padding: 10px;">
						
						<?php  
			    			loadingListCategorys($connection); /*Загрузка списка фильтров для мобилки*/
				  			?>
						</select>
						</div>
						<div class="mod-block2">
						    <div style="margin-top: 50px; padding:10px;">
        						<input type='checkbox' id="isNewModal" name="isNewModal"> <label for="isNewModal">Отображать в блоке новинки </label>
        						<br><input type='checkbox' id="isPopulerModal" name="isPopulerModal"> <label for="isPopiulerModal">Отображать в блоке популярные </label>
    						</div>
						</div>
						<div class="mod-block3">
    						<input type="file" name="images[]" multiple accept="image/*,image/jpeg" id="loadModal"><br>
    						<?php //print_r($_REQUEST);
    		    				
    				    		if(isset($_REQUEST['updateProduct'])){ 
    				    			//print_r($_FILES);
    				    			$isNew = "";
    				    			$isPopuler = "";
    				    			if(!isset($_REQUEST['isNewModal'])){
    				    				$isNew = "off";
    				    			}
    				    			else {
    				    				$isNew = "on";
    				    			}
    				    			if(!isset($_REQUEST['isPopulerModal'])){
    				    				$isPopuler = "off";
    				    			}
    				    			else {
    				    				$isPopuler = "on";
    				    			}
    				    			echo updateProduct($connection,$_REQUEST['nameModal'],$_REQUEST['coastModal'],$_REQUEST['codModal'],$_FILES,$_REQUEST['descriptionModal'],$isNew,$isPopuler,$_REQUEST['categoryModal'],$config);
    				    		}
    				    	?>
    				    	<div id="containerModal" width="200" height="200">
    							<input type="button" name="clearPhotoModal" id="clearphotoModal" value="X">
    							<img width="200" height="200" id="photoModal" class="photoModal" src="img/nophoto.jpg"/>
    							<p id="answer"></p>
    						</div>
						</div>
						<div class="mod-block4">
						<textarea rows="15" cols="50" id="descriptionModal" name="descriptionModal" placeholder="Описание" required></textarea> 
						</div>
						<div style="justify-content: center;display: grid;grid-column: 1/3;padding: 10px;">
						<input type="submit" name="updateProduct" id="updateProduct" value="Обновить" style="width:150px;height:50px; background: #013d45;color:#fff;"></input><br>
						</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div id="modalCategory" class="modalCategory">
			<div class="special_krest">
				<a href='#close' title='Закрыть' class='close'>X</a>
				<div class="modal" id="modal">
					<form enctype="multipart/form-data" method="POST" action="<?=$_SERVER['SCRIPT_NAME']?>"	>
						<input type="text" placeholder="код" id="idCategory" name="idCategory"><br>
						<input type="text" placeholder="наименование" name="titleCategory" id="titleCategory" ><br>
						<input type="submit" name="saveCategory" id="saveCategory" value="Сохранить изменения"></input><br>					
					</form>
				</div>
			</div>
		</div>

		<div id="modalUser" class="modalUser">
			<div class="special_krest">
				<a href='#close' title='Закрыть' class='close'>X</a>
				<div class="modal" id="modal">
					
						<input type="text" placeholder="код" id="idUser" name="idUser"><br>
						<input type="text" placeholder="логин" name="login" id="login" ><br>
						<input type="text" placeholder="пароль" id="password" name="password"><br>
						<input type="submit" name="saveUser" id="saveUser" value="Сохранить изменения"></input><br>		
				</div>
			</div>
		</div>
		<div class="tabs">

		    <input type="radio" name="inset" value="" id="tab_2" checked>
		    <label for="tab_2">Список товаров</label>	
		    
		    <input type="radio" name="inset" value="" id="tab_3">
		    <label for="tab_3">Список категорий</label>

			<input type="radio" name="inset" value="" id="tab_6" style="display: none;">
		    <label for="tab_6" style="display: none;">Добавить пользователя</label>

			<input type="radio" name="inset" value="" id="tab_5">
		    <label for="tab_5">Пользователи</label>
		    <a href="logout.php" style="margin-left: 625px;background: #013d45;color: #fff;padding: 7px;">Выход</a></label>

		    <div id="txt_2">

					<form enctype="multipart/form-data" method="POST" action="<?=$_SERVER['SCRIPT_NAME']?>">
					<div class="bigblock"> 
    					<div class="block1">
        					<input type="text" name="title" placeholder="наименование" id="name" required><br>
        					<input type="text" name="coast" id="coast" placeholder="0.00" value="0.00" pattern="\d+(\.\d{2})?" required><br>
        					<select id="selectСategory" name = "category">
        						<?php  
        			    			loadingListCategorys($connection); /*Загрузка списка фильтров для мобилки*/
        			  			?>
        					</select><br>
        					<br><input type='checkbox' id="isNew" name="isNew"> <label for="isNew">Отображать в блоке новинки </label>
        					<br><input type='checkbox' id="isPopiuler" name="isPopuler"> <label for="isPopuler">Отображать в блоке популярные </label>
    					</div>
    					<div class="block2">
        					<textarea rows="15" cols="50" id="description" name="description" placeholder="Описание" required></textarea> 
        					<!--<label for="datestart">Дата начала акции: <input type="text" id="datestart" name="datestart" ></label>
        					<label for="dateend">Дата окончания акции: </label><input type="text" id="dateend" name="dateend" > </label>-->
        					
                        </div>
                        <div class="block3">
        					<div id="containerMainPhoto" width="200" height="200">
        						<input type="button" name="clearPhoto" id="clearphoto" value="X">
        						<img width="200" height="200" id="mainPhoto" class="nophoto" src="img/nophoto.jpg"/>
        					</div>
        					
        					<input type="file" name="images[]" accept="image/*,image/jpeg" id="load"><br>
					    </div>
					    <div style="display:grid; justify-content: center; grid-column: 1 / 4;margin-top: 25px;">
					    <input type="submit" name="add" id="add" value="Добавить" style="width: 250px;height: 50px;background:#013d45;color: #fff;">
					    </div>
					<!--<div id="container">
						
					</div>-->
			        </div>
				</form>
		    	<?php //print_r($_REQUEST);
		    		

		    		if(isset($_REQUEST['add'])){ 
		    			//$datestart = date("Y-m-d",strtotime($_REQUEST['datestart']));description
		    			//$dateend = date("Y-m-d",strtotime($_REQUEST['dateend']));
		    			$isNew = "";
		    			$isPopuler = "";
		    			if(!isset($_REQUEST['isNew'])){
		    				$isNew = "off";
		    			}
		    			else {
		    				$isNew = "on";
		    			}
		    			if(!isset($_REQUEST['isPopuler'])){
		    				$isPopuler = "off";
		    			}
		    			else {
		    				$isPopuler = "on";
		    			}
		    			addition($connection,$_REQUEST['title'],$_REQUEST['coast'],
		    				$_FILES,$_REQUEST['description'],$isNew,$isPopuler);
		    		}
		    	?>



		    	
		    	<input id='selectAllProduct' type="checkbox" name="products" <label for="selectAllProduct" ">Отметить все элменты</label>
		    	<button id='delProduct' onClick='delProduct();' style="margin-left:25px;">Удалить</button>
		    	<select name="" id="selectPerPage" style="margin-left:25px;">
		    		<option value="5">5</option>
		    		<option value="10">10</option>
		    		<option value="15">15</option>
		    		<option value="20">20</option>
		    	</select><label for="selectPerPage" style="margin-left: 10px;">Количество продуктов на странице</label>
				<input id='filter_title_product' type="text" style="margin-left:25px;">
				<button id='searching_products' style="margin-left: 10px;">Поиск</button>
		    	
		    	<div id="containerTableProduct">
		    		<table id='tableProduct' class="table_blur">
				    	<?php 
				        	echo refreshTable($connection,$config,true);
				        ?>
				    </table>
		   		</div>
		   		<div id="pagerProduct">
		   			<?php
		   				$page = 1;
		   				if(isset($_REQUEST['page'])){
							$page =(int) $_REQUEST['page'];
						}
						$pager = new pagerCub($connection,"product",5,$page);
		   				echo $pager->getPageContainer();
		   			?>
		   		</div>
		    </div>
		    <div id="txt_3">
	    		<input type="text" placeholder="наименование" id="title_category" required><br>
				<button name="addCategory" id="addCategory" >Добавить</button><br>
				<p id="notify-category"></p>
		    	<button id='delCategory' onClick='delCategories();'>Удалить</button><br>
		    	<input id='selectAllCategory' type="checkbox" name="categories"><label for="selectAllCategory">Отметить все элменты</label>
		    	<select name="" id="selectPerPageCategory">
		    		<option value="10">10</option>
		    		<option value="15">15</option>
		    		<option value="20">20</option>
		    		<option value="20">25</option>
		    	</select><label for="selectPerPageCategory">Количество категорий на странице</label>
				<input id='filter_title_category' type="text">


				<button id='searching_categorys'>Поиск</button><br>
			
		    	<table id='tableCategory' class="table_blur">
		    		
			        <?php 
			        	echo refreshTableCategory($connection,true);
			        ?>
			    </table>
			    <div id="pagerCategory">
		   			<?php
		   				$page = 1;
		   				if(isset($_REQUEST['page'])){
							$page =(int) $_REQUEST['page'];
						}
		   				$pager = new pagerCub($connection,"category",10,$page);
		   				echo $pager->getPageContainer();
		   			?>
		   		</div>
		    </div>
		    <div id="txt_5">
					<button id='delUser' onClick='delUser();'>Удалить</button><br>
			    	<table id='tableUser' class="table_blur">
			    		
				        <?php  
				    		echo refreshTableUser($connection,true); /*Загрузка списка фильтров для мобилки*/
				  		?>
				    </table>
		    </div>

		    <div id="txt_6">
		        
					<input type="text" name="loginUser" placeholder="Введите логин" id="loginUser" required><br>
					<input type="text" name="passwordUser" placeholder="Введите пароль" id="passwordUser" required><br>
					<input type="text" name="doublePasswordUser" placeholder="Введите пароль ещё раз" id="doublePasswordUser" required><br>
					<input type="submit" name="addUser" id="addUser" value="Добавить"><br>
		    		<p id="notify-user"></p>
		    </div>
		  
		</div>
		
		
		
	<?php
	}
	else {
		echo '<script type="text/javascript">'; 
	    echo "window.location.href='singIn.php';"; 
	    echo '</script>'; 
	}
	 mysqli_close($connection); ?>	
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