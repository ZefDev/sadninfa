<?php
	include_once 'config.php'; 
	include_once 'db.php'; 
	include_once 'pagerCub.php';

	if (isset($_REQUEST['tag'])){


		switch ($_REQUEST['tag']) {
			case 'add_category':
				addCategory($connection);
				break;
			case 'save_category':
				saveCategory($connection);
				break;
			case 'del_category':
				delCategory($connection);
				break;
			case 'refresh_table_category':
				refreshTableCategory($connection);
				break;		
			case 'add_product':
				addition($connection);
				break;	
			case 'load_products_images':
				loadProductsImages($connection);
				break;	
			case 'change_product':
				changeProduct($connection,$config);
				break;
			case 'del_photo':
				delPhoto($connection,$config);
				break;

			case 'del_product':
				delProduct($connection,$config);
				break;			
			case 'refresh_table_product':
				refreshTable($connection,$config);
				break;		
			case 'add_user':
				addUser($connection);
				break;
			case 'change_user':
				changeUser($connection);
				break;
			case 'save_user':
				saveUser($connection);
				break;
			case 'del_user':
				delUser($connection);
				break;
			case 'checked_name_product':
				checked_name_product($connection);
			default:
				break;
		}
	}

	function checked_name_product($connection){
		$result = mysqli_query($connection,"select * from product where title = '".$_POST['title']."'") or die(mysqli_error($connection));
		$num_rows=$result->num_rows;
		if($num_rows>0){
			$array = array('answer' => 'false');
	 		echo json_encode($array);
		}
		else {
			$array = array('answer' => 'true');
	 		echo json_encode($array);
		}
	}

	function addUser($connection){
		$resultRequest ="Ошибка при выполнении запроса";
		$loginUser = $_POST['loginUser'];
		$resLogin = mysqli_query($connection, "select * from user where login = '$loginUser'") or die("Ошибка " . mysqli_error($connection));;
		$num_rows = $resLogin->num_rows;
		//echo "$num_rows";
		if($num_rows==0){
			$passwordUser = $_POST['passwordUser'];/*password_hash($_POST['passwordUser'], PASSWORD_DEFAULT);*/
		 	$result = mysqli_query($connection, "insert INTO user VALUES(NULL,'$loginUser','$passwordUser')") or die("Ошибка " . mysqli_error($connection));	
		 	if($result){
		 		$resultRequest ="Запись успешно добавлена";
		 	}
		}
		else {
			$resultRequest ="Пользователь с таким логином уже существует";
		}
	 	$tableUser = refreshTableUser($connection,true);
	 	$array = array('resultRequest' => $resultRequest,'tableUser' => $tableUser);
	 	echo json_encode($array);
	}

	function delUser($connection){
		$arrayId = explode(",", $_POST['array']);
		foreach ($arrayId as $value) {
		    $result = mysqli_query($connection, "select count(*) as count from user") or die("Ошибка " . mysqli_error($connection));
		    $count= mysqli_fetch_assoc($result);
		    $count = $count['count'];
		    if($count>1){
			    $result = mysqli_query($connection, "delete from user where id = ".(int)$value) or die("Ошибка " . mysqli_error($connection));
		    }
		}
		$tableUser = refreshTableUser($connection,true);
	 	$array = array('tableUser' => $tableUser);
	 	echo json_encode($array);
	}

	function saveUser($connection){
		$id = (int)$_POST['id'];
		$login = $_POST['login'];
		$password = $_POST['password'];
		$res = mysqli_query($connection, "update user set login = '$login', password = '$password' where id = $id ") or die("Ошибка " . mysqli_error($connection));
		refreshTableUser($connection);
	}

	function changeUser($connection){
		$array = array();
		$id = $_POST['id'];
		$query ="select * from user where id = $id";
		$result = mysqli_query($connection, $query);
		if($result){
			while ($row = mysqli_fetch_assoc($result)) {
				$array["id"] = $row['id'];
				$array["login"] = $row['login'];
				$array["password"] = $row['password'];
			}
			echo json_encode($array);
		}
	}

	function refreshTableUser($connection,$flag = false){
		$result = mysqli_query($connection, "select * from user") or die("Ошибка " . mysqli_error($connection)); 
		$resultString ="<th>
		    			<td>Номер</td>
		    			<td>Логин</td>
		    			<td>Пароль</td>
		    			<td>Пароль</td>
		    			</th>
		    			<tr>";
		if($result){
    		while ($row = mysqli_fetch_assoc($result)){

    			$resultString = $resultString."
    					<td><input type='checkbox' id='".$row['id']."' name='users'></td>
    					<td>".$row['id']."</td>
    					<td>".$row['login']."</td>
    					<td>".$row['password']."</td>
    					<td><a href='#modalUser' class='showUser' id='changeUser' >Изменить</a></td>
    				  ";
    				$resultString = $resultString ."<tr/>";
    		}

    		
    		//echo $resultString;
    	}
    	if($flag){
    		return $resultString;
    	}
    	else {
    		$array = array('tableUser' => $resultString);
			echo json_encode($array);
    	}
	}

	function delPhoto($connection,$config){
		$result = mysqli_query($connection, "select * from photoproduct where idProduct =".(int)$_POST['id']) or die("Ошибка " . mysqli_error($connection));
		while ($row = mysqli_fetch_array($result)) {
			if(file_exists($config['constants']['path_img_flowers'].$row['photo']) && $row['photo']!=$config['constants']['img_nophoto']){
					unlink($config['constants']['path_img_flowers'].$row['photo']);
				}
		}
		$resultPhoto = mysqli_query($connection, "delete from photoproduct where idProduct = ".(int)$_POST['id']) or die("Ошибка " . mysqli_error($connection));
		
		echo refreshTable($connection,$config);
	}

	function saveCategory($connection){
		$id = (int)$_POST['id'];
		$title = validation($connection,$_POST['title']);
		$res = mysqli_query($connection, "update category set title = '$title' where id = $id ") or die("Ошибка " . mysqli_error($connection));
	}

	function addCategory($connection){
		$title = $_REQUEST['title'];
		$message = "";
	 	$result = mysqli_query($connection, "insert INTO category VALUES(NULL,'$title')") or die("Ошибка " . mysqli_error($connection));	
	 	if($result){
	 		$message = "Запись успешно добавлена";
	 	}
	 	$tableCategory = refreshTableCategory($connection,true);
	 	$listCategory = loadingListCategorys($connection,true);
	 	$array = array('tableCategory' => $tableCategory,'message' => $message,
	 		'listCategory'=> $listCategory);
		echo json_encode($array);
	}

	function delCategory($connection){
		$arrayId = explode(",", $_POST['array']);
		//$resultProducts = mysqli_query($connection, "select", resultmode);
		//print_r($arrayId);
		foreach ($arrayId as $value) {
			mysqli_query($connection, "delete from category where id = ".(int)$value);
			// or die("Ошибка " . mysqli_error($connection));
			//die("Нельзя удалить категорию к которой привязаны товары!");
		}
		$tableCategory = refreshTableCategory($connection,true);
		$array = array('tableCategory' => $tableCategory);
		echo json_encode($array);
	}

	function loadProductsImages($connection){
		$query = "<span>";
		$res = mysqli_query($connection, "select * from photoproduct where idProduct = ".$_POST['id']);
		if ($res){
			while ($row = mysqli_fetch_assoc($res)) {
				$query = $query."<img width='200' height='200' class='thumb' src='".$config['constants']['path_img_flowers'].$row['photo']."'>";
			}
		}
		$query = $query."</span>";
		echo $query;
	}

	function loadingListCategorys($connection,$flag = false){
		$resultString="";
		$result = mysqli_query($connection, "select * from category");
		if ($result){
			while ($row = mysqli_fetch_assoc($result)) {
				$resultString .= "<option>".$row['title']."</option>";
			}
		}
		if($flag){
			return $resultString;
		}
		else {
			echo "$resultString";
		}
	}

	function addition($connection,$title,$coast,$imagesList,$description,$isNew,$isPopuler){
		//print_r($_FILES);
		//move_uploaded_file($_FILES['images']['tmp_name'], "/data");
		$uploads_dir = 'img/flowers';
		$count=0;
		$mainPhoto = "";
		$images = array();

		foreach ($imagesList["images"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$tmp_name = $imagesList['images']['tmp_name'][$key];
				$name = basename($imagesList['images']['name'][$key]);
				$images[] = $name;
	       		move_uploaded_file($tmp_name, "$uploads_dir/$name");
			}
			$count++;
		}

		/*$tmp_name = $_FILES['mainPhoto']['tmp_name'];
		$name = basename($_FILES['mainPhoto']['name']);
		$mainPhoto = $name;
		$images[] = $name; 
	    move_uploaded_file($tmp_name, "$uploads_dir/$name");*/

		add($title ,$coast,$images,$connection,$_POST['category'],$mainPhoto,$description,$isNew,$isPopuler);
		
	}

	function delProduct($connection,$config){
		$arrayId = explode(",", $_POST['array']);
		
		foreach ($arrayId as $value) {
			
			$result = mysqli_query($connection, "select * from photoproduct where idProduct = ".(int)$value) or die(mysqli_error($connection));
			while ($row = mysqli_fetch_array($result)) {
				if(file_exists($config['constants']['path_img_flowers'].$row['photo']) && $row['photo']!=$config['constants']['img_nophoto']){
					unlink($config['constants']['path_img_flowers'].$row['photo']);
				}
			}
			$result = mysqli_query($connection, "delete from product where id = ".(int)$value) or die("Ошибка " . mysqli_error($connection));
			$result = mysqli_query($connection, "delete from photoproduct where idProduct = ".(int)$value) or die("Ошибка " . mysqli_error($connection));;
		}
		echo refreshTable($connection,$config);
	}

	function changeProduct($connection,$config){
		$array = array();
		$id = $_POST['id'];
		$query ="select p.id,p.title,p.coast,p.description,p.isNew,p.isPopuler,p.category,c.title as titleCategory from product p
			INNER JOIN category c ON c.id = p.category
			where p.id = $id";
		$result = mysqli_query($connection, $query);
		if($result){
			while ($row = mysqli_fetch_assoc($result)) {
				$photo = "img/nophoto.jpg";
				$resultPhoto = mysqli_query($connection, "select * from photoproduct where idProduct = $id") or die("Ошибка " . mysqli_error($connection));;
				if($resultPhoto){
					while ($rowPhoto = mysqli_fetch_assoc($resultPhoto)) {
						$photo = $config['constants']['path_img_flowers'].$rowPhoto['photo'];
					}
				}
				$array["id"] = $row['id'];
				$array["title"] = $row['title'];
				$array["coast"] = $row['coast'];
				$array["titleCategory"] = $row['titleCategory'];
				$array["description"] = $row['description'];
				$array["isNew"] = $row['isNew'];
				$array["isPopuler"] = $row['isPopuler'];
				$array["photo"] = $photo;
				$array["selectСategoryModal"] = loadingListCategorys($connection,true);
			}
			echo json_encode($array);
		}
	}

	function add($title,$coast,$img,$connection,$category,$mainPhoto,$description,$isNew,$isPopuler){
		$resultCategory = mysqli_query($connection, "select * from category where title = '$category'") or die("Ошибка " . mysqli_error($connection));
	 	$idCategory = 0;

	 	while ($row = mysqli_fetch_assoc($resultCategory)) {
	 		$idCategory = $row['id'];
	 	}
	 	$res = mysqli_query($connection, "insert INTO product VALUES(NULL,'$title',$coast,'$description',$idCategory,NULL,'$isNew','$isPopuler')") or die("Ошибка " . mysqli_error($connection));
	 	$result = mysqli_query($connection, "select max(id) as id from product") or die("Ошибка " . mysqli_error($connection));
	 	while ($row = mysqli_fetch_assoc($result)) {
	 		$count=0;
	 		foreach ($img as $el) {
	 			$count++;
	 			$res = mysqli_query($connection, "insert INTO photoproduct VALUES(NULL,".$row['id'].",'".$el."',NULL)") or die("Ошибка " . mysqli_error($connection));
	 		}
	 		if($count==0){
	 			$res = mysqli_query($connection, "insert INTO photoproduct VALUES(NULL,".$row['id'].",'nophoto.jpg',NULL)") or die("Ошибка " . mysqli_error($connection));
	 		}
	 	}
		 	
	}

	function updateProduct($connection,$title,$coast,$id,$imagesList,$description,$isNew,$isPopuler,$category,$config){
		$resultCategory = mysqli_query($connection, "select * from category where title = '$category'") or die("Ошибка " . mysqli_error($connection));
	 	$idCategory = 0;

	 	while ($row = mysqli_fetch_assoc($resultCategory)) {
	 		$idCategory = $row['id'];
	 	}
	 	

		$res = mysqli_query($connection, "update product set title = '$title', coast = $coast, isNew ='$isNew', isPopuler ='$isPopuler', description='$description', category=$idCategory where id = $id ") or die("Ошибка " . mysqli_error($connection));

		//$uploads_dir = 'img/flowers';
		$count=0;
		$images = array();
		foreach ($imagesList["images"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$tmp_name = $imagesList['images']['tmp_name'][$key];
				$name = basename($imagesList['images']['name'][$key]);
				$images[] = $name;
	       		move_uploaded_file($tmp_name, $config['constants']['path_img_flowers'].$name);

			}
			$count++;
		}
		/*Код приведённый ниже юзаеться для удаление картинки с сервака при обноволении картинки в продукте */
		if($count>0){
			$result = mysqli_query($connection, "select * from photoproduct where idProduct = $id ") or die("Ошибка " . mysqli_error($connection));
			while ($row = mysqli_fetch_array($result)) {
				if(file_exists($config['constants']['path_img'].$row['photo']) && $row['photo']!=$config['constants']['img_nophoto']){
					unlink($config['constants']['path_img'].$row['photo']);
				}
			}
		}
		//======================
		$resultPhoto = mysqli_query($connection, "select * from photoproduct where idProduct = $id")or die("Ошибка " . mysqli_error($connection));
		$num_rows = $resultPhoto->num_rows;
		if($num_rows>0){
			foreach ($images as $el) {
	 			mysqli_query($connection, "update photoproduct set photo = '".$el."' where idProduct = $id ") or die("Ошибка " . mysqli_error($connection));
	 		}
		}
		else {
			foreach ($images as $el) {
	 			mysqli_query($connection, "insert INTO photoproduct VALUES(NULL,$id,'".$el."',NULL)") or die("Ошибка " . mysqli_error($connection));
	 		}
		}

		//refreshTable($connection);
	}

	function refreshTable($connection,$config,$flag = false){
		$per_page=5;
		$page = 1;
		$filter_title_product ="";
		$table_name= "product";
		if(isset($_REQUEST['page'])){
			$page =(int) $_REQUEST['page'];
		}
		if(isset($_REQUEST['per_page'])){
			$per_page =(int) $_REQUEST['per_page'];
		}
		$offset = ($per_page * $page)-$per_page;
		if(isset($_REQUEST['filter_title_product'])){
			$filter_title_product =$_REQUEST['filter_title_product'];
		}
		$pager = new pagerCub($connection,$table_name,$per_page,$page,$filter_title_product);
		$pagerProduct = $pager->getPageContainer();
		

		$result = mysqli_query($connection, "select * from product where title  LIKE '%".$filter_title_product."%'
			order by id desc limit $offset,$per_page") or die("Ошибка " . mysqli_error($connection)); 
		$resultString ="<th>
		    			<td>Номер</td>
		    			<td>Наименование</td>
		    			<td>Цена</td>
		    			<td>Категория</td>
		    			<td>Описание</td>
		    			<td>В новинках</td>
		    			<td>В популярных</td>
		    			<td>Фото</td>
		    			<td></td>
		    			</th>
		    			<tr>";
		if($result){
			if($result->num_rows>0){
	    		while ($row = mysqli_fetch_assoc($result)){
	    			$photo = "";
	    			$category = "";
	    			$resultCount = mysqli_query($connection, "select * from photoproduct where 
	    				idProduct=".$row['id']) or die("Ошибка " . mysqli_error($connection)); 
	    			if($resultCount){
	    				while ($rowCount = mysqli_fetch_assoc($resultCount)) {
	    					$photo = $rowCount['photo'];
	    				}
	    			}
	    			if($photo==""){
	    				$photo = "nophoto.jpg";
	    			}
	    			$resultCategory = mysqli_query($connection, "select * from category where 
	    				id = ".$row['category']) or die("Ошибка " . mysqli_error($connection)); 
	    			if($resultCategory){
	    				while ($rowCategory = mysqli_fetch_assoc($resultCategory)) {
	    					$category = $rowCategory['title'];
	    				}
	    			}
	    			$f="";
					if(strlen($row['description'])>50){
						$f="...";
					}
	    			$resultString = $resultString."
	    					<td><input type='checkbox' id='".$row['id']."' name='products'></td>
	    					<td>".$row['id']."</td>
	    					<td>".$row['title']."</td>
	    					<td>".number_format($row['coast'], 2, '.', ',')."</td>
	    					<td>".$category."</td>
	    					<td>".mb_substr($row['description'], 0, 50, 'utf-8').$f."</td>
	    					<td>".convertOnRus($row['isNew'])."</td>
	    					<td>".convertOnRus($row['isPopuler'])."</td>
	    					<td><img src='".$config['constants']['path_img_flowers'].$photo."' alt='' id='product_img'> </td>
	    					<td><a href='#openModal' class='showProduct' id='change' >Изменить</a></td>
	    				  ";
	    				$resultString = $resultString ."<tr/>";
	    		}
	    	}
	    	else {
	    		$resultString =" По данному запросу ничего не найдено ";
	    	}
    	}
    	if($flag){
    		return $resultString;
    	}
    	else {
    		$array = array('tableProduct' => $resultString, 'pagerProduct' => $pagerProduct);
			echo json_encode($array);
    	}
	}

	function refreshTableCategory($connection,$flag = false){

		$per_page=10;
		$page = 1;
		$filter_title_category ="";
		$table_name= "category";
		if(isset($_REQUEST['page'])){
			$page =(int) $_REQUEST['page'];
		}
		if(isset($_REQUEST['per_page'])){
			$per_page =(int) $_REQUEST['per_page'];
		}
		$offset = ($per_page * $page)-$per_page;
		if(isset($_REQUEST['filter_title_category'])){
			$filter_title_category =$_REQUEST['filter_title_category'];
		}
		$pager = new pagerCub($connection,$table_name,$per_page,$page,$filter_title_category);
		$pagerCategory = $pager->getPageContainer();

		$result = mysqli_query($connection, "select * from category where title  LIKE '%".$filter_title_category."%'
			order by id desc limit $offset,$per_page"); 
		$resultString ="<th>
		    			<td>Номер</td>
		    			<td>Наименование</td>
		    			<td></td>
		    			</th>
		    			<tr>";
		if($result){
    		while ($row = mysqli_fetch_assoc($result)){
    			$count = 0;
    			$resultString = $resultString."
    					<td><input type='checkbox' id='".$row['id']."' name='categories'></td>
    					<td>".$row['id']."</td>
    					<td class='titleCategory'>".$row['title']."</td>
    					<td><a href='#' class='showCategory' id='changeCategory'>Изменить</a></td>
    					
    				  ";
    				$resultString = $resultString ."<tr/>";
    		}

    		
    		//echo $resultString;
    	}

    	if($flag){
    		return $resultString;
    	}
    	else {
			$array = array('tableCategory' => $resultString, 'pagerCategory' => $pagerCategory);
			echo json_encode($array);
    	}
	} 

	function convertOnRus($string){
		if($string=="on"){
			return "да";
		}
		else {
			return "нет";
		}
	}
	
	function validation($connection,$param){
		$param = trim($param); 
   	 	$param = mysqli_real_escape_string($connection,$param);
    	$param = htmlspecialchars($param);
    	return $param;
	}

	/*Функция для вывода страниц по какой-то таблице c учётом поиска по полю title*/
	/*function pager($connection,$name_table,$per_page,$page,$filter_title_product=""){
		$result_string="";
		$category = 0;
		$query_for_count = "select count(id) as total_count from $name_table where title  LIKE '%".$filter_title_product."%'";
		$where_for_query ="";


		$total_count_q = mysqli_query($connection,$query_for_count);
		$total_count = mysqli_fetch_assoc($total_count_q);
		$total_count = $total_count['total_count'];

		$total_pages = ceil($total_count/$per_page);
		if($page<=1 || $page > $total_pages){
			$page =1;
		}
		if($page>1){
			$result_string =$result_string."<a href='#' id='".($page -1)."'> Прошлая страница</a>";
		}
		
			for($i =1; $i<$total_count/$per_page+1; $i++){
				$result_string = $result_string."<a href='#' id='$i'> $i</a>";
			}
		if ($page<$total_pages){
			$result_string = $result_string."<a href='#' id='".($page +1)."'> Следующая страница</a>";
		}
		return $result_string;
	}*/
?>