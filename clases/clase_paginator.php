<?
class paginator {
	var $records;
	var $pages;
	var $recordsperpage;
	var $actual_page=1;
	var $url_page="";
	var $start_record;
	
	function paginator($records, $recordsperpage, $url_page = "") {
		if(!isset($_REQUEST['pg'])) { $_REQUEST['pg'] = ''; }
		if(!isset($_GET['pg'])) { $_GET['pg'] = ''; }
		
		$this->url_page = $url_page;
		$this->records=$records;
		$this->recordsperpage=$recordsperpage;
		if ($_REQUEST['pg']) {
			$this->actual_page=$_REQUEST['pg'];
		}
		if ($_GET['pg']) {
			$this->start_record=($_GET['pg'] * $recordsperpage) - $recordsperpage;
		}else {
			$this->start_record=0;
		}
	}
	function get_total_pages() {
	$total=(($this->records%$this->recordsperpage==0)? $this->records/$this->recordsperpage : floor($this->records/$this->recordsperpage) +1);

		$this->pages=$total;
		return $total;
	}
	function print_paginator($type="") {
		$sep=((substr_count($this->url_page,"?")==0)? "?" : "&amp;");
		if ($type=="") {
			$cad=(($this->actual_page!=1)? "<a class='paginator' style='font-size:14;text-decoration:none' href='".$this->url_page.$sep."pg=1'>&laquo;</a> ": "");
			if ($this->url_page=="") {
				$cad.=(($this->actual_page!=1)? "<a class='paginator' style='font-size:14;text-decoration:none' href='?pg=".(($this->actual_page)-1)."'>&lsaquo;</a>": ""); 
				$linkc=$sep;
			}else {
				$cad.=(($this->actual_page!=1)? "<a class='paginator' style='font-size:14;text-decoration:none' href='".$this->url_page.$sep."pg=".(($this->actual_page)-1)."'>&lsaquo;</a> ": ""); 
				$linkc= $this->url_page.$sep;
			}
			if ($this->pages>5) {
				if ($this->actual_page<=2) {
					$inicio=1;
					$fin=5;
				} else {
					$inicio=$this->actual_page-2;
					if (($this->actual_page+2)<$this->pages) {
						$fin=$this->actual_page+2;
					}else {
						$fin=$this->pages;
					}
				}
			} else {
				$inicio=1;
				$fin=$this->pages;
			}
			for($i=$inicio;$i<=$fin; $i++) {
				$link= $linkc . "pg=" . $i ;
				if ($i==$this->actual_page) {
					$cad.="<span class='paginator_check'>". $i . "</span> ";
				} else {
					$cad.= "<a href='$link' class='paginator'>" . $i . "</a> ";
				}
			}
			if ($this->url_page=="") {
				$cad.=(($this->actual_page!=$this->pages)? "<a class='paginator' style='font-size:14;text-decoration:none' href='".$sep."pg=".(($this->actual_page)+1)."'>&rsaquo;</a> ": "");
			}else {
				$cad.=(($this->actual_page!=$this->pages)? "<a class='paginator' style='font-size:14;text-decoration:none' href='".$this->url_page.$sep."pg=".(($this->actual_page)+1)."'>&rsaquo;</a> ": ""); 
			}
			$cad.=(($this->actual_page!=$this->pages)? "<a class='paginator' style='font-size:14;text-decoration:none' href='".$this->url_page.$sep."pg=".($this->pages)."'>&raquo;</a> ": "");
			if ($this->pages>1) {
				echo $cad;
			}
		}elseif($type="pulldown"){
			$inicio=1;
			$fin=$this->pages;
			if ($this->pages>1){
				echo "	<script>
							function nextpage(page){
								location.href='".$this->url_page.$sep."pg='+page;
							}
						</script>";
				echo "<select name='pg' onchange='nextpage(this[this.selectedIndex].value)'>";
				for($i=$inicio;$i<=$fin; $i++) {
					$s=($i==$this->actual_page)?"Selected":"";
					echo "<option value='".$i."'".$s.">".$i."</option>";
				}	
				echo "</select>";	
			}
		}
	}
	function print_page_counter($labelpage="Pagina", $labelof="de") {
		if ($this->pages>1) {
			$objLan = unserialize($_SESSION["obj_language"]);
			echo $labelpage. " " . $this->actual_page . " ". $labelof. " " . $this->pages;
		}
	}
}

?>
