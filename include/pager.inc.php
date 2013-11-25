<?

Class Pager {
	var 
		$buffer, 
		$pageLength,
		$length,
		$pageNumber,
		$query,
		$templateFile,
		$emptyTemplateFile,
		$template;
		
	function Pager($pageLength = 10) {
		$this->pageLength = $pageLength;
		$this->length = 0;
		$this->pageNumber = 0;
	}
	
	function setQuery($query) {
		$this->query = $query;
	}
	
	function setTemplate($template) {
		$this->templateFile = $template;
	}
	
	function setEmptyTemplate($template) {
		$this->emptyTemplateFile = $template;
	}
	
	function getPage() {
		
		if (!isset($_REQUEST['page'])) {
			$page = 1;
		} else {
			$page = $_REQUEST['page'];
		}
		
		
		$oid = mysql_query($this->query);
		$pagerLength = mysql_affected_rows();
		
		if ($pagerLength > 0) {
			
			
			$this->template = new Template($this->templateFile);
		
		
			$min = ($page-1)*$this->pageLength;
			$max = $page*$this->pageLength;
			
			$query = $this->query." LIMIT {$min}, {$this->pageLength}";
			
			$this->buffer = Parser::getResult($query);
			
			foreach($this->buffer as $data) {
				$this->display($data);
			}
			
			$this->pageNumber = ceil($pagerLength/$this->pageLength);
			
			$this->template->setContent("pageNumber", $this->pageNumber);
			$this->template->setContent("page", $page);
			
			$script = basename($_SERVER['SCRIPT_FILENAME']);
			$pars = $_SERVER['QUERY_STRING'];
			
			
			
			
			if ($this->pageNumber == 1) {
				$next = "avanti&nbsp;&raquo;";
				$prev = "&laquo;&nbsp;indietro";
			} else {
				
				
				
				if ($page == $this->pageNumber) {
					$next = "avanti&nbsp;&raquo;";
					$prevPage = $page - 1;
					$prev = "<a href=\"{$script}?{$pars}&page={$prevPage}\">&laquo;&nbsp;indietro</a>";
				} else {
					
					if ($page == 1) {
						$prev = "&laquo;&nbsp;indietro";
						$nextPage = $page + 1;
						$next = "<a href=\"{$script}?{$pars}&page={$nextPage}\">avanti&nbsp;&raquo;</a>";
					} else {
						$nextPage = $page + 1;
						$next = "<a href=\"{$script}?{$pars}&page={$nextPage}\">avanti&nbsp;&raquo;</a>";
						$prevPage = $page - 1;
						$prev = "<a href=\"{$script}?{$pars}&page={$prevPage}\">&laquo;&nbsp;indietro</a>";
						
						
						
					}
					
				}
				
			}
			
			$this->template->setContent("next", $next);
			$this->template->setContent("prev", $prev);
			
		} else {
			$this->template = new Template($this->emptyTemplateFile);	
		} 
		
		return $this->template->get();
	}

	function display($data) {
		
		foreach($data as $k => $v) {
			$this->template->setContent($k,$v);
		}
		
	}
}

Class News extends Pager {
	function News($length) {
		$this->Pager($length);
	}
	
	function display($data) {
		
		$length = 400;
		foreach($data as $k => $v) {
			switch($k) {
			case "body":
				$this->template->setContent($k,Parser::subtext($data[$k], $length)." ...");
			break;
			case "video":
				if ($data[$k] != "") {
					
					#$this->template->setContent("video","<span class=\"mediaicons\"><img src=\"img/grafica/icon_video.gif\" alt=\"Video: titolo_mainnews\"/><a href=\"javascript:openvideo('{$data['video']}','{$data['logo']}')\">video </a> </span>");
					$this->template->setContent("video","<img src=\"img/grafica/icon_video.gif\" alt=\"Video: titolo_mainnews\"/><a href=\"javascript:openvideo('{$data['video']}','{$data['logo']}')\">video </a>");
				

				} else {
					$this->template->setContent("video", "");
				}
			break;
			
			case "foto":
				
				if ($data[$k] != 0) {
					$length=250;
					$this->template->setContent("foto", "<a href=\"news.php?id={$data['id']}\"><img src=\"show.php?token=3bcda8f2aed2c8f1fdea1c020dadcf39&id={$data['id']}&width=52&height=60&thumb\" alt=\"{$data['title']}\"/></a>");
				} else {
					$this->template->setContent("foto", "");
				}
			break;
			
			case "data":
				$this->template->setContent("data", Parser::formatDate($v, STANDARD_PLUS));
			break;
			
			default:
				$this->template->setContent($k,$data[$k]);
			break;
			}
		}
	}
}


?>