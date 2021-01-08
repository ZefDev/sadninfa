<?php
	include_once 'config.php'; 
	include_once 'db.php';
	include_once 'pager.php';

	if (isset($_REQUEST['tag'])){


		switch ($_REQUEST['tag']) {
			case 'prompt_for_searching': //подсказка для поиска
				prompt_for_searching($connection,$config);
				break;
			case 'full_searching': //поиск с отображением результатов
				searching($connection,$config);
				break;
			default:
				break;
		}
	}
	
	function getCategory($connection){
		$result = mysqli_query($connection,"select c.title,c.id FROM category c
inner join product p ON p.category = c.id group by title");
		if($result){
			while ($row = mysqli_fetch_array($result)) {
	            echo "<li id='tipy'><a href='types.php?category=".$row['id']."'>".$row['title']."</a></li>";
			}
			echo "<li id='tipy'><a href='types.php?category=0'>Все</a></li>";
		}
	} 


	function getCategoryMobile($connection){
		$result = mysqli_query($connection,"select c.title,c.id FROM category c
inner join product p ON p.category = c.id group by title");
		if($result){
		    echo "<select id='tipy-select' onchange='window.location.href=this.options[this.selectedIndex].value'>";
		    echo "<option value='types.php?category=0'>Все</option>";
		    $category = 0;
		    if(isset($_REQUEST['category'])){
			        $category = (int)$_REQUEST['category'];
			}
			while ($row = mysqli_fetch_array($result)) {
			   
			    if($row['id']==$category){
			        echo "<option selected value='types.php?category=".$row['id']."'>".$row['title']."</option>";
			    }
			    else{
			        echo "<option value='types.php?category=".$row['id']."'>".$row['title']."</option>";
			    }
			}
		}
		echo "</select>";
	} 
	function getProduct($connection,$offset,$per_page){
		$item2 ="";
		$result = mysqli_query($connection," select p.id, p.title,p.coast,p.description,p.category,p.isNew,p.isPopuler, ph.photo FROM product p
			inner join photoproduct ph ON p.id = ph.idProduct
			order by id
			desc limit $offset,$per_page");
		if($result){
			while ($row = mysqli_fetch_array($result)) {
				//echo "<a href='#'>".$row['title']."</a> <br>";
				$item2 = $item2
				."<div class='new-box'>
						<div class='new-box-img'>
							<img src='img/flowers/".$row['photo']."' alt=''>
						</div>
						<div class='new-box-name-button'>
							<div class='new-box-name'>
							<li>".mb_substr($row['title'], 0, 35, 'utf-8')."</li>
							</div>
							<div class='new-box-button'>
							<p style='font-size: 16px;'>".$row['coast']."</p>
							<a href='#'>открыть</a>
							</div>
						</div>
					</div>";
			}
		}
		echo "$item2";
	}

	function prompt_for_searching($connection,$config){
		$item2 ="";
		$full_searching="";
		$result_searching="";
		if(isset($_REQUEST['full_searching'])){
			$full_searching =$_REQUEST['full_searching'];
		}

		if(trim($full_searching)!=""){
			$result = mysqli_query($connection," select p.id, p.title,p.coast,p.description,p.category,p.isNew,p.isPopuler, ph.photo FROM product p
			inner join photoproduct ph ON p.id = ph.idProduct
			where title  LIKE '%".$full_searching."%' or description LIKE '%".$full_searching."%'
			order by id limit 5");
			if($result){
				while ($row = mysqli_fetch_array($result)) {
					//echo "<a href='#'>".$row['title']."</a> <br>";
					$item2 = $item2
					."<div class='item-product-searching'>
						<a href='tovar.php?idProduct=".$row['id']."'>
							<img width='50px' class='picter-searching' src='".$config['constants']['path_img_flowers'].$row['photo']."'/>
							<span class='title'>".mb_substr($row['title'], 0, 35, 'utf-8')."</span>
						</a>
					</div>";
				}
			}
			$item2 = $item2."<div class='item-product-searching'>
						<a href='tovar.php?idProduct=".$row['id']."'>
							<span class='title'>Больше товаров</span>
						</a>
					</div>";
			$result_searching = $item2;
		}
		$array = array ('result_searching' => $result_searching);
		echo json_encode($array);
	}

	function searching($connection,$config,$flag = false){
		$item2 ="";
		$full_searching="";
		$result_searching="";
		$category =0;
		$coastmin=0;
		$coastmax=9999;
		if(isset($_REQUEST['full_searching'])){
			$full_searching =$_REQUEST['full_searching'];
        	$full_searching = trim($full_searching); 
            $full_searching = mysqli_real_escape_string($connection,$full_searching);
        	$full_searching = htmlspecialchars($full_searching);
		}
		if(isset($_REQUEST['coastmin'])){
			$coastmin =(double)$_REQUEST['coastmin'];
		}
		if(isset($_REQUEST['coastmax'])){
			$coastmax =(double)$_REQUEST['coastmax'];
			if ($coastmin <0.01){
			    $coastmax=9999;
			}
		}
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
		

		//if(trim($full_searching)!=""){
			$per_page = 12;
			$page = 1;
			if(isset($_GET['page'])){
				$page =(int) $_GET['page'];
			}
			if(isset($_GET['category'])){
				$category =(int) $_GET['category'];
			}
			$offset = ($per_page * $page)-$per_page;
			
			$query = " select p.id, p.title,p.coast,p.description,p.category,p.isNew,p.isPopuler, ph.photo FROM product p
			inner join photoproduct ph ON p.id = ph.idProduct
		    where (p.title LIKE '%".$full_searching."%' or p.description LIKE '%".$full_searching."%') and
			(p.coast >= $coastmin and p.coast <= $coastmax) ";

			if($category!=0){
				$query = $query." and (p.category = $category) ";
			}

			$query = $query."order by id
			desc limit $offset,$per_page";

			$result = mysqli_query($connection,$query);

			if($result){
				if($result->num_rows>0){
					while ($row = mysqli_fetch_array($result)) {
						//echo "<a href='#'>".$row['title']."</a> <br>";
						$photo="";
						if(strlen($row['photo'])==0){
							$photo="nophoto.jpg";
						}
						else {
							$photo=$row['photo'];
						}
						$coast="";
            			if($row['coast']!=0){
            			    $coast="<p style='font-size: 18px;'>".number_format($row['coast'], 2, 'р', ',')."к</p>";
            			}
            			else{
            			    $coast="<p style='font-size: 15px;'>Уточняйте</p>";
            			}

						$item2 = $item2
						."<div class='new-box'>
								<div class='new-box-img'>
									<img src='img/flowers/".$row['photo']."' alt=''>
								</div>
								<div class='new-box-name-button'>
									<div class='new-box-name'>
									<li>".mb_substr($row['title'], 0, 35, 'utf-8')."</li>
									</div>
									<div class='new-box-button'>
									".$coast."
									<a href='tovar.php?idProduct=".$row['id']."'>открыть</a>
									</div>
								</div>
							</div>";
					}
				}
				else {
					$item2 = "<p>По данному запросу ничего не найдено!</p>";
				}
			}
			$result_searching = $item2;
		//}

		$category = 0;
		$pagerContent ="";
		if(isset($_REQUEST['category'])){
			$category = (int)$_REQUEST['category'];
		}
		if(isset($_REQUEST['page'])){
			$page =(int) $_REQUEST['page'];
			$pager = new pager($connection,"product",12,$page,$category,$full_searching);
			$pagerContent =$pager->getPageContainer();
		}	
		else {
			$page = 1;
			$pager = new pager($connection,"product",12,$page,$category,$full_searching);
			$pagerContent= $pager->getPageContainer();
		}
		$array = array('result_searching' => $result_searching,'pager' => $pagerContent);
		if($flag){
			return $array;
		}
		else {			
			echo json_encode($array);
		}
	}


?>