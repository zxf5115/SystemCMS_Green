<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// |         lanfengye <zibin_5257@163.com>
// +----------------------------------------------------------------------

class Page {
    
    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 分页URL地址
    public $url     =   '';
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow    ;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
	protected $page;
    // 分页显示定制
	protected $config = array(
		//'first'=>'首页',
		'prev'=>'&nbsp;',
		'next'=>'&nbsp;',
		'theme'=>' %upPage% %linkPage% %downPage% ',
	);
    protected $varPage;

    /**
     * 架构函数
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows,$listRows='',$parameter='',$url='') {
        $this->totalRows    =   $totalRows;
        $this->parameter    =   $parameter;
        $this->varPage      =   C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
        if(!empty($listRows)) {
            $this->listRows =   intval($listRows);
        }
        $this->totalPages   =   ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages    =   ceil($this->totalPages/$this->rollPage);
        $this->nowPage      =   !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage  =   $this->totalPages;
        }
        $this->firstRow     =   $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     * 分页显示输出
     * @access public
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage;
        $nowCoolPage    =   ceil($this->nowPage/$this->rollPage);

        // 分析分页参数
        if($this->url){
            $depr       =   C('URL_PATHINFO_DEPR');
            $url        =   rtrim(U('/'.$this->url,'',false),$depr).$depr.'__PAGE__';
        }else{
            if($this->parameter && is_string($this->parameter)) {
                parse_str($this->parameter,$parameter);
            }elseif(empty($this->parameter)){
                unset($_GET[C('VAR_URL_PARAMS')]);
                if(empty($_GET)) {
                    $parameter  =   array();
                }else{
                    $parameter  =   $_GET;
                }
            }
            $parameter[$p]  =   '__PAGE__';
            $url            =   U('',$parameter);
        }
        //上下翻页字符串
        $upRow          =   $this->nowPage-1;
        $downRow        =   $this->nowPage+1;
        if ($upRow>0){
            $upPage     =   "<a class='prev_page' href='".str_replace('__PAGE__',$upRow,$url)."'>".$this->config ['prev']."</a>";
        }else{
            $upPage     =   "<a class='prev_page' href='#'>".$this->config ['prev']."</a>";
        }

        if ($downRow <= $this->totalPages){
			
            $downPage   =   "<a class='next_page' href='".str_replace('__PAGE__',$downRow,$url)."'>".$this->config ['next']."</a>";

        }else{
           $downPage   =   "<a class='next_page' href='#'>".$this->config ['prev']."</a>";
        }
        // << < > >>
        if($nowCoolPage == 1){
            $theFirst   =   '';
            $prePage    =   '';
        }else{
            $preRow     =   $this->nowPage-$this->rollPage;
            $prePage    =   "<a href='".str_replace('__PAGE__',$preRow,$url)."' >上".$this->rollPage."页</a>";
			//$theFirst   =   "<a href='".str_replace('__PAGE__',1,$url)."' >".$this->config['first']."</a>";
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage   =   '';
            $theEnd     =   '';
        }else{
            $nextRow    =   $this->nowPage+$this->rollPage;
            $theEndRow  =   $this->totalPages;
            $nextPage   =   "<a href='".str_replace('__PAGE__',$nextRow,$url)."' >下".$this->rollPage."页</a>";   
			$theEnd     =   "<a href='".str_replace('__PAGE__',$theEndRow,$url)."' >".$this->config['last']."</a>";
          
        }
        // 1 2 3 4 5
        $linkPage = "";

		if ($this->totalPages < $this->rollPage) {
			for($i=1;$i<=$this->rollPage;$i++){
				$page       =   ($nowCoolPage-1)*$this->rollPage+$i;
				if($page!=$this->nowPage){
					if($page<=$this->totalPages){
						$linkPage .= "<a  href='".str_replace('__PAGE__',$page,$url)."'>&nbsp;".$page."&nbsp;</a>";
					} else{
						if($this->totalPages == 1) {
							$linkPage .= "<a class='thisClass' href='".str_replace('__PAGE__',1)."'>&nbsp1&nbsp</a>";
						}
						 break;
					}
					
				}else{
					if($this->totalPages != 1){
						$linkPage .= "<a class='thisClass' href='".str_replace('__PAGE__',$page,$url)."'>&nbsp;".$page."&nbsp;</a>";
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
						
						$linkPage .= "<a class='thisClass' href='".str_replace('__PAGE__',$this->page,$url)."'>&nbsp;".$this->page."&nbsp;</a>";
					} else {
						
						$linkPage .= "<a class='' href='".str_replace('__PAGE__',$this->page,$url)."'>&nbsp;".$this->page."&nbsp;</a>";
					}
					$this->page ++;
				}
			}else if ($this->nowPage < $mid) {//第三页走这里
				for($i = 1; $i <= $this->rollPage; $i ++) {
					$this->page = $i;
					
					if ($this->page == $this->nowPage) {
						
						$linkPage .= "<a class='thisClass' href='".str_replace('__PAGE__',$this->page,$url)."'>&nbsp;".$this->page."&nbsp;</a>";
					} else {
						
						$linkPage .= "<a class='' href='".str_replace('__PAGE__',$this->page,$url)."'>&nbsp;".$this->page."&nbsp;</a>";
					}
				}
			}else if ($this->nowPage > $this->totalPages - $mid) {//处理尾页所有数据
				
				for($i = $this->totalPages - $this->rollPage + 1; $i <= $this->totalPages; $i ++) {
					$this->page = $i;
					
					if ($this->page == $this->nowPage) {
						
						$linkPage .= "<a class='thisClass' href='".str_replace('__PAGE__',$this->page,$url)."'>&nbsp;".$this->page."&nbsp;</a>";
					} else {
						
						$linkPage .= "<a class='' href='".str_replace('__PAGE__',$this->page,$url)."'>&nbsp;".$this->page."&nbsp;</a>";
					}
				}
			}
		}
        $pageStr     =   str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd),$this->config['theme']);
        return $pageStr;
    }

}