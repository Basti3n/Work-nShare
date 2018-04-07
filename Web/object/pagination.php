<?php
class PerPage {
	public $perpage;

	function __construct() {
		$this->perpage = 10;
	}

	function pagination($count,$href) {
		$output = '';
		if(!isset($_GET["page"]))
      $_GET["page"] = 1;
		if($this->perpage != 0)
			$pages  = ceil($count/$this->perpage);

		if($pages>1) {
      if($_GET["page"] == 1)
        $output = $output .  '<li class="page-item disabled"> <a class="page-link">&#8810;</a></li>
                              <li class="page-item disabled"> <a class="page-link">&#60;</a></li>';
      else
        $output = $output . ' <li class="page-item"> <a class="page-link" onclick="getresult(\'' . $href . (1) . '\')" href="#" >&#8810;</a></li>
                              <li class="page-item"> <a class="page-link" onclick="getresult(\'' . $href . ($_GET["page"]-1) . '\')" href="#" >&#60;</a></li>';
				//$output = $output . '<a class="link first" onclick="getresult(\'' . $href . (1) . '\')" >&#8810;</a><a class="link" onclick="getresult(\'' . $href . ($_GET["page"]-1) . '\')" >&#60;</a>';


			if(($_GET["page"]-3)>0) {
				if($_GET["page"] == 1)
					$output = $output . '<span id=1 class="link current">1</span>';
				else
					$output = $output . '<li class="page-item"><a class="page-link" onclick="getresult(\'' . $href . '1\')" href="#" >'. '1' .'</a></li>';
			}
			if(($_GET["page"]-3)>1) {
					$output = $output . '<li class="page-item"><a class="page-link dot">'. '...' .'</a></li>';
			}

			for($i=($_GET["page"]-2); $i<=($_GET["page"]+2); $i++)	{
				if($i<1)
          continue;
				if($i>$pages)
          break;
				if($_GET["page"] == $i)
          $output = $output . '<li class="page-item active"><a class="page-link">'.$i.'</a></li>';
				else
					$output = $output . '<li class="page-item"><a class="page-link" onclick="getresult(\'' . $href . $i . '\')" href="#" >'.$i.'</a></li>';
			}

      if(($pages-($_GET["page"]+2))>1) {
        $output = $output . '<li class="page-item"><a class="page-link dot">'. '...' .'</a></li>';
      }
			if(($pages-($_GET["page"]+2))>0) {
				if($_GET["page"] == $pages)
          $output = $output . '<li id=' . ($pages) .' class="page-item active"><a class="page-link"  href="#" >'. ($pages) .'</a></li>';
				else
					$output = $output . '<li class="page-item"><a class="page-link" onclick="getresult(\'' . $href .  ($pages) .'\')" href="#" >'. ($pages) .'</a></li>';
			}

			if($_GET["page"] < $pages)
				$output = $output . '<li class="page-item"> <a class="page-link" onclick="getresult(\'' . $href . ($_GET["page"]+1) . '\')" href="#" >&#62;</a></li>
                             <li class="page-item"> <a class="page-link" onclick="getresult(\'' . $href . ($pages) . '\')" href="#" >&#8811;</a></li>';
			else
				$output = $output . ' <li class="page-item disabled"> <a class="page-link">&#62;</a></li>
                              <li class="page-item disabled"> <a class="page-link">&#8811;</a></li>';

		}
		return $output;
	}
}
?>
