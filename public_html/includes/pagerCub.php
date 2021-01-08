<?php
	/**
	* 
	*/
	class pagerCub
	{
		private $connection;
		private $name_table;// имя таблицы к которой нужны страницы
		private $per_page;//Кол-во отображаемых элементов на странице
		private $page;//Номер страницы
		private $filter_title;//запрос юзера
		
		function __construct($connection,$name_table,$per_page,$page,$filter_title="")
		{
			$this->connection = $connection;
			$this->name_table = $name_table;
			$this->per_page = $per_page;
			$this->page = $page;
			$this->filter_title = $filter_title;
		}

		function getPageContainer(){
			$result_string="";
			$query_for_count = "select count(id) as total_count from $this->name_table where title  LIKE '%"
			.$this->filter_title."%'";
			/*Находим количество записей*/
			$total_count_q = mysqli_query($this->connection,$query_for_count);
			$total_count = mysqli_fetch_assoc($total_count_q);
			$total_count = $total_count['total_count'];

			$total_pages = ceil($total_count/$this->per_page);//Вычисляем сколько будет страниц
			
			if($this->page<=1 || $this->page > $total_pages){
				$this->page =1;
			}
			if($this->page>1){
				$result_string =$result_string."<a href='#' id='".($this->page -1)."'> Прошлая страница</a>";
			}
			
			for($i =1; $i<$total_count/$this->per_page+1; $i++){
				$result_string = $result_string."<a href='#' id='$i'> $i</a>";
			}
			if ($this->page<$total_pages){
				$result_string = $result_string."<a href='#' id='".($this->page +1)."'> Следующая страница</a>";
			}

			return $result_string;
		}
	}
?>