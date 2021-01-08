<?php
	/**
	* Этот пэйджер для страницы type.php всего списка товаров
	*/
	class pager
	{
		private $connection;
		private $name_table;// имя таблицы к которой нужны страницы
		private $per_page;//Кол-во отображаемых элементов на странице
		private $page;//Номер страницы
		private $filter_title;//запрос юзера
		private $category;//запрос юзера
		private $coastmin;//запрос юзера
		private $coastmax;//запрос юзера
		
		function __construct($connection,$name_table,$per_page,$page,$category=0,$filter_title="",$coastmin=0,$coastmax=9999)
		{
			$this->connection = $connection;
			$this->name_table = $name_table;
			$this->per_page = $per_page;
			$this->page = $page;
			$this->filter_title = $filter_title;
			$this->category = $category;
			$this->coastmin = $coastmin;
			$this->coastmax = $coastmax;
		}

		function getPageContainer(){
			$result_string="";
			$query_for_count = "select count(id) as total_count from $this->name_table where (title  LIKE '%"
			.$this->filter_title."%' or description  LIKE '%".$this->filter_title."%') and
			(coast >= $this->coastmin and coast <= $this->coastmax ) ";
			if($this->category!=0){
				$query_for_count = $query_for_count ." and category = ".$this->category;
			}
			/*Находим количество записей*/
			$total_count_q = mysqli_query($this->connection,$query_for_count) or die(mysqli_error($this->connection));
			$total_count = mysqli_fetch_assoc($total_count_q);
			$total_count = $total_count['total_count'];

			$total_pages = ceil($total_count/$this->per_page);//Вычисляем сколько будет страниц
			
			if($this->page<=1 || $this->page > $total_pages){
				$this->page =1;
			}
			if($this->page>1){
				$result_string =$result_string."<li><a href='types.php?page=".($this->page -1)."&category=".$this->category."&full_searching=".$this->filter_title."' id='".($this->page -1)."'> Прошлая страница</a></li>";
			}

			if($this->page-1>1){
				$result_string = $result_string."<li><a href='types.php?page=1&category=".$this->category."&full_searching=".$this->filter_title."' id='1'>1</a></li>";
				$result_string = $result_string."<li id='nothing'>...</li>";
			}
			
			/*for($i =1; $i<$total_count/$this->per_page+1; $i++){
				$result_string = $result_string."<li><a href='types.php?page=".($i)."&category=".$this->category."' id='$i'> $i</a></li>";
			}*/
			if($this->page>1){
			$result_string = $result_string."<li><a href='types.php?page=".($this->page -1)."&category=".$this->category."&full_searching=".$this->filter_title."' id='".($this->page -1)."'>".($this->page -1)."</a></li>";
			}
			$result_string = $result_string."<li style='box-shadow:0px 0px 10px #013d45;'><a href='types.php?page=".($this->page)."&category=".$this->category."&full_searching=".$this->filter_title."' id='".($this->page)."'> ".($this->page)."</a></li>";
			if ($this->page<$total_pages){
			$result_string = $result_string."<li ><a href='types.php?page=".($this->page +1)."&category=".$this->category."&full_searching=".$this->filter_title."' id='".($this->page +1)."'> ".($this->page +1)."</a></li>";
			}
			if($this->page+1<$total_pages){
				$result_string = $result_string."<li id='nothing'>...</li>";
				$result_string = $result_string."<li><a href='types.php?page=".($total_pages)."&category=".$this->category."&full_searching=".$this->filter_title."' id='".($total_pages)."'> ".($total_pages)."</a></li>";
			}

			
			if ($this->page<$total_pages){
				$result_string = $result_string."<li><a href='types.php?page=".($this->page +1)."&category=".$this->category."&full_searching=".$this->filter_title."' id='".($this->page +1)."'> Следующая страница</a></li>";
			}

			return $result_string;
		}
	}
?>