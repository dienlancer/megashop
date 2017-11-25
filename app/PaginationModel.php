<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class PaginationModel extends Model{
	
	private $totalItems;					// Tổng số phần tử
	private $totalItemsPerPage		= 1;	// Tổng số phần tử xuất hiện trên một trang
	private $pageRange				= 5;	// Số trang xuất hiện
	private $totalPage;						// Tổng số trang
	private $currentPage			= 1;	// Trang hiện tại
	
	public function __construct($pagination){
		$this->totalItems			= $pagination["totalItems"] ;
		$this->totalItemsPerPage	= $pagination['totalItemsPerPage'];
		
		if($pagination['pageRange'] %2 == 0) $pagination['pageRange'] = $pagination['pageRange'] + 1;
		
		$this->pageRange			= $pagination['pageRange'];
		$this->currentPage			= $pagination['currentPage'];
		$this->totalPage			= ceil($this->totalItems/$pagination['totalItemsPerPage']);
	}
	public function showPagination(){		
		$paginationHTML = '';
		if($this->totalPage > 1){
			$start 	= '<li ><span>Bắt đầu</span></li>';
			$prev 	= '<li ><span>Lùi</span></li>';
			if($this->currentPage > 1){
				$start 	= '<li ><a onclick="javascript:changePage(1)" href="javascript:void(0);">Bắt đầu</a></li>';
				$prev 	= '<li ><a onclick="javascript:changePage('.($this->currentPage-1).')" href="javascript:void(0);">Lùi</a></li>';
			}
		
			$next 	= '<li ><span>Tiếp theo</span></li>';
			$end 	= '<li ><span>Cuối</span></li>';
			if($this->currentPage < $this->totalPage){
				$next 	= '<li ><a onclick="javascript:changePage('.($this->currentPage+1).')" href="javascript:void(0);">Tiếp theo</a></li>';
				$end 	= '<li ><a href="javascript:void(0);" onclick="javascript:changePage('.$this->totalPage.')">Cuối</a></li>';
			}
		
			if($this->pageRange < $this->totalPage){
				if($this->currentPage == 1){
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				}else if($this->currentPage == $this->totalPage){
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				}else{
					$startPage		= $this->currentPage - ($this->pageRange-1)/2;
					$endPage		= $this->currentPage + ($this->pageRange-1)/2;
		
					if($startPage < 1){
						$endPage	= $endPage + 1;
						$startPage = 1;
					}
		
					if($endPage > $this->totalPage){
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			}else{
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}

			$listPages = '';
			for($i = $startPage; $i <= $endPage; $i++){
				if($i == $this->currentPage) {
					$listPages .= '<li class="active"><span>'.$i.'</span></li>';
				}else{
					$listPages .= '<li><a href="javascript:void(0);" onclick="javascript:changePage('.$i.')">'.$i.'</a></li>';
				}
			}
			$listPages .= '';
			$endPagination	= '<li >Page '.$this->currentPage.' of '.$this->totalPage.'</li>';
			$paginationHTML = '<ul class="pagination">' . $start . $prev . $listPages . $next . $end  . '</ul>';
		}
		return $paginationHTML;
	}
}