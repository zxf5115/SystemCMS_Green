<?php
use Think\Think;
class CustomAjaxPage extends Think {
	// 分页栏每页显示的页数
	public $rollPage = 5;
	
	// 页数跳转时要带的参数
	public $parameter;
	
	// 默认列表每页显示行数
	public $listRows = 20;
	
	// 起始行数
	public $firstRow;
	
	// 分页总页面数
	protected $totalPages;
	
	// 总行数
	protected $totalRows;
	
	// 当前页数
	protected $nowPage;
	
	// 分页的栏的总页数
	protected $coolPages;
	protected $page;
	
	// 分页显示定制
	protected $config = array(
    /* 'header' => '条记录',
    'prev'   => '上一页',
    'next'   => '下一页',
    'first'  => '第一页',
    'last'   => '最后一页',
    'theme'  => '<span >&nbsp;&nbsp;</span>   %upPage%  %linkPage% %downPage%' */
	  'first' => '首页',
			'prev' => '上一页',
			'next' => '下一页',
			'end' => '尾页',
			'theme' => '%first%  %upPage%  %linkPage%  %downPage%  %end%' 
	);
	
	// 默认分页变量名
	protected $varPage;
	public function __construct($totalRows, $listRows = '', $ajax_func, $page, $parameter = '') {
		$this->totalRows = $totalRows;
		
		$this->ajax_func = $ajax_func;
		
		$this->parameter = $parameter;
		
		$this->varPage = ! empty ( $page ) ? $page : C ( 'VAR_PAGE' );
		
		if (! empty ( $listRows )) {
			$this->listRows = intval ( $listRows );
		}
		
		// 总页数
		$this->totalPages = ceil ( $this->totalRows / $this->listRows );
		
		$this->coolPages = ceil ( $this->totalPages / $this->rollPage );
		
		$this->nowPage = ! empty ( $this->varPage ) ? intval ( $this->varPage ) : 1;
		
		if (! empty ( $this->totalPages ) && $this->nowPage > $this->totalPages) {
			$this->nowPage = $this->totalPages;
		}
		
		$this->firstRow = $this->listRows * ($this->nowPage - 1);
	}
	public function setConfig($name, $value) {
		if (isset ( $this->config [$name] )) {
			$this->config [$name] = $value;
		}
	}
	public function show() {
		// 如果总行数为0，返回空
		if (0 == $this->totalRows) {
			return '';
		}
		
		$p = $this->varPage;
		
		$nowCoolPage = ceil ( $this->nowPage / $this->rollPage );
		
		$url = $_SERVER ['REQUEST_URI'] . (strpos ( $_SERVER ['REQUEST_URI'], '?' ) ? '' : "?") . $this->parameter;
		
		$parse = parse_url ( $url );
		
		if (isset ( $parse ['query'] )) {
			parse_str ( $parse ['query'], $params );
			unset ( $params [$p] );
			$url = $parse ['path'] . '?' . http_build_query ( $params );
		}
		
		// 上下翻页字符串
		$upRow = $this->nowPage - 1;
		$downRow = $this->nowPage + 1;
		
		if ($upRow > 0) {
			$upPage = "<li class='paginate_button previous'><a id='big' href='javascript:" . $this->ajax_func . "(" . $upRow . ")'>" . $this->config ['prev'] . "</a></li>";
		} else {
			$upPage = "<li class='paginate_button previous' disabled ><a id='big' href='#'>" . $this->config ['prev'] . "</a></li>";
		}
		
		if ($downRow <= $this->totalPages) {
			$downPage = "<li class='paginate_button next'><a id='big' href='javascript:" . $this->ajax_func . "(" . $downRow . ")'>" . $this->config ['next'] . "</a></li>";
		} else {
			$downPage = "<li class='paginate_button next' disabled ><a id='big' href='#'>" . $this->config ['next'] . "</a></li>";
		}
		
		// << < > >>
		if ($nowCoolPage == 1) {
			$theFirst = "";
			$prePage = "";
		} else {
			$preRow = $this->nowPage - $this->rollPage;
			$prePage = "<a id='big' href='javascript:" . $this->ajax_func . "(" . $preRow . ")'>上" . $this->rollPage . "页</a>";
			// $theFirst = "<a id='big' href='javascript:".$this->ajax_func."(1)' >".$this->config['first']."</a>";
		}
		
		if ($nowCoolPage == $this->coolPages) {
			$nextPage = "";
			$theEnd = "";
		} else {
			$nextRow = $this->nowPage + $this->rollPage;
			$theEndRow = $this->totalPages;
			$nextPage = "<a id='big' href='javascript:" . $this->ajax_func . "(" . $nextRow . ")' >下" . $this->rollPage . "页</a>";
			$theEnd = "<a id='big' href='javascript:" . $this->ajax_func . "(" . $theEndRow . ")' >" . $this->config ['last'] . "</a>";
		}
		
		$linkPage = "";
		// 1 2 3 4 5
		if ($this->totalPages < $this->rollPage) {
			for($i = 1; $i <= $this->rollPage; $i ++) {
				$page = ($nowCoolPage - 1) * $this->rollPage + $i;
				if ($page != $this->nowPage) {
					if ($page <= $this->totalPages) {
						$linkPage .= "&nbsp;<li class='paginate_button'><a id='big' href='javascript:" . $this->ajax_func . "(" . $page . ")'>&nbsp;" . $page . "&nbsp;</a></li>";
					} else {
						break;
					}
				} else {
					if ($this->totalPages != 1) {
						$linkPage .= "<li class='paginate_button active'><a href='javascript:;'>" . $page . "</a></li>";
					}
				}
			}
		} else {
			//左右保持2页
			$mid = ceil ( $this->rollPage / 2 );
			if ($this->nowPage >= $mid && $this->nowPage <= ($this->totalPages - $mid)) {
				
				$this->page = $this->nowPage - ceil ( $this->rollPage / 2 - 1 );
				
				for($i = 1; $i <= $this->rollPage; $i ++) {
					if ($this->page == $this->nowPage) {
						
						$linkPage .= "&nbsp;<li class='paginate_button active'><a id='big' href='javascript:" . $this->ajax_func . "(" . $this->page . ")'>&nbsp;" . $this->page . "&nbsp;</a></li>";
					} else {
						
						$linkPage .= "<li class='paginate_button '><a  href='javascript:" . $this->ajax_func . "(" . $this->page . ")'>&nbsp;".$this->page ."&nbsp;</a></li>";
					}
					$this->page ++;
				}
			}else if ($this->nowPage < $mid) {//第三页走这里
				for($i = 1; $i <= $this->rollPage; $i ++) {
					$this->page = $i;
					
					if ($this->page == $this->nowPage) {
						 
						$linkPage .= "&nbsp<li class='paginate_button active'><a id='big' href='javascript:" . $this->ajax_func . "(" . $this->page . ")'>&nbsp;" . $this->page . "&nbsp;</a></li>";
					} else {
						
						$linkPage .= "<li class='paginate_button '><a href='javascript:" . $this->ajax_func . "(" . $this->page . ")'>&nbsp;" . $this->page . "&nbsp;</a></li>";
					}
				}
			}else if ($this->nowPage > $this->totalPages - $mid) {//处理尾页所有数据
				for($i = $this->totalPages - $this->rollPage + 1; $i <= $this->totalPages; $i ++) {
					$this->page = $i;
					
					if ($this->page == $this->nowPage) {
						
						$linkPage .= "&nbsp<li class='paginate_button active'><a id='big' href='javascript:" . $this->ajax_func . "(" . $this->page . ")'>&nbsp;" . $this->page . "&nbsp;</a></li>";
					} else {
						
						$linkPage .= "<li class='paginate_button '><a href='javascript:" . $this->ajax_func . "(" . $this->page . ")'>&nbsp;" . $this->page . "&nbsp;</a></li>";
					}
				}
			}
		}
		
		$pageStr = str_replace ( array (
				'%header%',
				'%nowPage%',
				'%totalRow%',
				'%totalPage%',
				'%upPage%',
				'%downPage%',
				'%first%',
				'%prePage%',
				'%linkPage%',
				'%nextPage%',
				'%end%' 
		), array (
				$this->config ['header'],
				$this->nowPage,
				$this->totalRows,
				$this->totalPages,
				$upPage,
				$downPage,
				$theFirst,
				$prePage,
				$linkPage,
				$nextPage,
				$theEnd 
		), $this->config ['theme'] );
		
		return $pageStr;
	}
}
