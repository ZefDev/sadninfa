<?php
	include_once 'config.php'; 
	include_once 'db.php'; 
	if (isset($_REQUEST['tag'])){


		switch ($_REQUEST['tag']) {
			case 'reload_new_slider':
				reload_new_slider($connection,$config);
				break;
			case 'reload_populer_slider':
				reload_populer_slider($connection,$config);
				break;
			default:
				break;
		}
	}

	function reload_new_slider($connection,$config,$flag=false){
		$resultString="";
		$new_box_page = 1;
		$per_page = 4;
		if(isset($_REQUEST['new_box_page'])){
			$new_box_page = (int) $_REQUEST['new_box_page'];
		}

		$total_count =  mysqli_query($connection,"select count(id) as total_count from product where isNew='on'");
		$total_count = mysqli_fetch_assoc($total_count);
		$total_count = $total_count['total_count'];
		$total_pages = ceil($total_count/$per_page);//Вычисляем сколько будет страниц

		$new_prev_page = 1;
		if($new_box_page>1){
			$new_prev_page = $new_box_page -1;
		}
		else {
			$new_prev_page = $total_pages;
		}



		

		$offset = ($per_page * $new_box_page)-$per_page;
		$result = mysqli_query($connection,"select *  from product where isNew='on' order by id
			desc limit $offset,$per_page");
		while ($row = mysqli_fetch_array($result)) {
			$resultPhoto = mysqli_query($connection, "select * from photoproduct where idProduct = ".$row['id']) or die(mysqli_error($connection));
			$photo = mysqli_fetch_assoc($resultPhoto);

			if(strlen($photo['photo'])==0){
				$photo="nophoto.jpg";
			}
			else {
				$photo=$photo['photo'];
			}
			$coast="";
			if($row['coast']!=0){
			    $coast="<p style='font-size: 18px;'>".number_format($row['coast'], 2, 'р', ',')."к</p>";
			}
			else{
			    $coast="<p style='font-size: 16px;'>Уточняйте</p>";
			}
			$resultString = $resultString."<div class='new-box wow fadeIn'>
					<div class='new-box-img'>
						<img src='".$config['constants']['path_img_flowers'].$photo."' alt=''>
					</div>
					<div class='new-box-name-button'>
						<div class='new-box-name'>
						<li>".$row['title']."</li>
						</div>
						<div class='new-box-button'>
						".$coast."
						<a href='tovar.php?idProduct=".$row['id']."'>открыть</a>
						</div>
					</div>
				</div>";
		}

		$new_next_page = 0;
		if($new_box_page>=$total_pages){
			$new_next_page = 1;
		}
		else {
			$new_next_page = $new_box_page+1;
		}
		$new_prev = "<img id='new-prev' src='img/left-arrow.png' alt='".$new_prev_page."'>";
		$new_next="<img id='new-next' src='img/right-arrow.png' alt='".$new_next_page."'>";
    	if($flag){
    		$array = array('new_slider' => $resultString,'new_prev'=> $new_prev,'new_next'=>$new_next);
    		return $array;
    	}
    	else {
    		$array = array('new_slider' => $resultString,'new_prev'=> $new_prev_page,'new_next'=>$new_next_page);
			echo json_encode($array);
		}
	}
	function reload_populer_slider($connection,$config,$flag=false){
		$resultString="";
		$new_box_page = 1;
		$per_page = 4;
		if(isset($_REQUEST['populer_box_page'])){
			$new_box_page = (int) $_REQUEST['populer_box_page'];
		}

		$total_count =  mysqli_query($connection,"select count(id) as total_count from product where isPopuler='on'");
		$total_count = mysqli_fetch_assoc($total_count);
		$total_count = $total_count['total_count'];
		$total_pages = ceil($total_count/$per_page);//Вычисляем сколько будет страниц

		$new_prev_page = 1;
		if($new_box_page>1){
			$new_prev_page = $new_box_page -1;
		}
		else {
			$new_prev_page = $total_pages;
		}



		/*$resultString = $resultString.
			"<div class='new-prev' >
				<img id='popular-next' src='img/left-arrow.png' alt='".$new_prev_page."'></a>
			</div>";*/

		$offset = ($per_page * $new_box_page)-$per_page;
		$result = mysqli_query($connection,"select *  from product where isPopuler='on' order by id
			desc limit $offset,$per_page");
		while ($row = mysqli_fetch_array($result)) {
			$resultPhoto = mysqli_query($connection, "select * from photoproduct where idProduct = ".$row['id']) or die(mysqli_error($connection));
			$photo = mysqli_fetch_assoc($resultPhoto);

			if(strlen($photo['photo'])==0){
				$photo="nophoto.jpg";
			}
			else {
				$photo=$photo['photo'];
			}
			$coast="";
			if($row['coast']!=0){
			    $coast="<p style='font-size: 18px;'>".number_format($row['coast'], 2, 'р', ',')."к</p>";
			}
			else{
			    $coast="<p style='font-size: 16px;'>Уточняйте</p>";
			}
			$resultString = $resultString."<div class='new-box'>
					<div class='new-box-img'>
						<img src='".$config['constants']['path_img_flowers'].$photo."' alt=''>
					</div>
					<div class='new-box-name-button'>
						<div class='new-box-name'>
						<li>".$row['title']."</li>
						</div>
						<div class='new-box-button'>
						".$coast."
						<a href='tovar.php?idProduct=".$row['id']."'>открыть</a>
						</div>
					</div>
				</div>";
		}

		$new_next_page = 0;
		if($new_box_page>=$total_pages){
			$new_next_page = 1;
		}
		else {
			$new_next_page = $new_box_page+1;
		}

		/*$resultString = $resultString.
			"<div class='new-next' >
				<img id='popular-next' src='img/right-arrow.png' alt='".$new_next_page."'></a>
			</div>";*/
		$populer_prev = "<img id='popular-prev' src='img/left-arrow.png' alt='".$new_prev_page."'>";
		$populer_next="<img id='popular-next' src='img/right-arrow.png' alt='".$new_next_page."'>";	
    	if($flag){
    		$array = array('popular_slider' => $resultString,'popular_prev'=> $populer_prev,'popular_next'=>$populer_next);
    		return $array;
    	}
    	else {
			$array = array('popular_slider' => $resultString,'popular_prev'=> $new_prev_page,'popular_next'=>$new_next_page);
			echo json_encode($array);
		}
	}
?>