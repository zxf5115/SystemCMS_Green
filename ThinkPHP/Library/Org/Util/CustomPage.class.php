<?php
use Think\Think;

class CustomPage extends Think
{
  # 起始行数
  private $firstRow;

  # 列表每页显示行数
  public $listRows;

  # 页数跳转时要带的参数
  private $parameter;

  # 分页总页面数
  private $totalPages;

  # 总行数
  private $totalRows;

  # 当前页数
  private $nowPage;

  # 分页的栏的总页数
  private $coolPages;

  # 分页栏每页显示的页数
  private $rollPage;

  # 这里将$page写成类的成员属性，其实不用，懒的改了
  private $page;

  # 分页中其他参数和页码下标的分隔符
  private $decollator = '/';

  # 分页中页码下标和页码值的连接符 i=2, i/2, i|2
  private $connector = '/';

  # url模式:0 普通模式 1 PATHINFO模式
  private $pattern;

  # 分页显示定制
  protected $config = array(
    'header' => '条记录',
    'prev'   => '上一页',
    'next'   => '下一页',
    'first'  => '第一页',
    'last'   => '最后一页',
    'theme'  => ' %first% %upPage%  %linkPage% %downPage% %last% '
  );


  /**
   * --------------------------------------------------------------------------------------
   * 架构函数
   *
   * @param array $totalRows  总的记录数
   * @param array $listRows   每页显示记录数
   * @param array $parameter  分页跳转的参数
   */
  public function __construct($totalRows, $listRows, $rollPage = '', $parameter = '', $pattern = 0)
  {
    # 设置总记录数
    $this->totalRows = $totalRows;

    # 参数
    $this->parameter = $parameter;

    # URL模式
    $this->pattern = $pattern;

    $this->rollPage = !empty($rollPage) ? $rollPage : C('PAGE_ROLLPAGE');

    $this->listRows = !empty($listRows) ? $listRows : C('PAGE_LISTROWS');

    # 总页数
    $this->totalPages = ceil($this->totalRows/$this->listRows);

    $this->coolPages  = ceil($this->totalPages/$this->rollPage);

    # 当前页
    $this->nowPage  = !empty($_GET[C('VAR_PAGE')]) ? $_GET[C('VAR_PAGE')]:1;

    # 如果总页数存在并且当前页数大于总页数，总页数等于当前页数
    if(!empty($this->totalPages) && ($this->nowPage > $this->totalPages))
    {
      $this->nowPage = $this->totalPages;
    }

    $this->firstRow = $this->listRows * ($this->nowPage - 1);
  }




  /**
   * --------------------------------------------------------------------------------------
   * 定制分页链接设置
   *
   * @param string $name  设置名称
   * @param string $value 设置值
   */
  public function setConfig($name, $value)
  {
    if(isset($this->config[$name]))
    {
      $this->config[$name] = $value;
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 生成链接URL
   *
   * @param  integer $page 页码
   * @return string
   */
  private function url($page)
  {
    return str_replace(urlencode('[PAGE]'), $page, $this->url);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 分页显示输出
   */
  public function show()
  {
    # 如果总行数为0，返回空
    if(0 == $this->totalRows)
    {
      return '';
    }

    $footer = C('VAR_PAGE');

    $nowCoolPage = ceil($this->nowPage / $this->rollPage);

    # 普通模式URL转换
    if($this->pattern == 0)
    {
      $url = $_SERVER['REQUEST_URI'].$this->parameter;

      # 去掉地址中多余的分页数据
      $url = preg_replace('/\/i\/\d?/i', '', $url);

      // $url = $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;

      $parse = parse_url($url);

      if(isset($parse['query']))
      {
        parse_str($parse['query'], $params);

        unset($params[$footer]);

        $preg = '/\/'.$footer.'\/(\d+)/';

        if(preg_match($preg, $params['s']))
        {
          $params['s'] = preg_replace($preg, "", $params['s']);
        }

        if(preg_match($preg, $params['m']))
        {
          $params['m'] = preg_replace($preg, "", $params['m']);
        }

        $url = rawurldecode($parse['path'].'?'.http_build_query($params));
      }
    }
    # PATHINFO模式或者兼容URL模式
    else
    {
      $parameter = str2arr($_SERVER['REQUEST_URI'], '/');

      # 添加参数
      if(!empty($parameter))
      {
        foreach($parameter as $key => &$val)
        {
          if($footer == $val)
          {
            unset($parameter[$key]);
            unset($parameter[$key+1]);
          }
        }
      }

      $url = arr2str($parameter, '/');
    }



    # 上下翻页字符串
    $upRow   = $this->nowPage - 1;
    $downRow = $this->nowPage + 1;

    if ($upRow > 0)
    {
      $upPage="<li><a href='".$url.$this->decollator.$footer.$this->connector."$upRow'>".$this->config['prev']."</a></li>";
      $firstPage="<li><a href='".$url.$this->decollator.$footer.$this->connector."1'>".$this->config['first']."</a></li>";
    }
    else
    {
      $upPage="<li class='paginate_button previous disabled'><span class='nextprev'><a href='javascript:;'>".$this->config['prev']."</a></span></li>";
      $firstPage="<li class='paginate_button previous disabled'><span class='nextprev'><a href='javascript:;'>".$this->config['first']."</a></span></li>";
    }

    if ($downRow <= $this->totalPages)
    {
      $downPage="<li><a href='".$url.$this->decollator.$footer.$this->connector."$downRow'>".$this->config['next']."</a></li>";
      $lastPage="<li><a href='".$url.$this->decollator.$footer.$this->connector."$this->totalPages'>".$this->config['last']."</a></li>";

    }
    else
    {
      $downPage="<li class='paginate_button previous disabled'><span class='nextprev'><a href='javascript:;'>".$this->config['next']."</a></span></li>";
      $lastPage="<li class='paginate_button previous disabled'><span class='nextprev'><a href='javascript:;'>".$this->config['last']."</a></span></li>";
    }

    $linkPage = "";

    if($this->totalPages < $this->rollPage)
    {
      # 若页码数不够设置的显示页数 ，比如设置显示5页，但只有3页数据
      for($i = 1; $i<=$this->totalPages; $i++)
      {
        if($i == $this->nowPage)
        {
          $linkPage .= "<li class='paginate_button active'><a href='javascript:;'>".$i."</a></li>";
        }
        else
        {
          $linkPage .= "<li><a href='".$url.$this->decollator.$footer.$this->connector."$i'>".$i."</a></li>";
        }
      }
    }
    else
    {
      $mid = ceil($this->rollPage/2);

      # 当前页在页码中间靠右时，保持左边有2个页码
      if($this->nowPage >= $mid && $this->nowPage <= ($this->totalPages - $mid))
      {
        # 这个2使当前页保持在中间（每次显示5个页码时），如果一次显示7个页码，改成3即可保持当前页在中间
        $this->page = $this->nowPage - ceil($this->rollPage/2 - 1);

        for($i = 1; $i <= $this->rollPage; $i++)
        {
          if($this->page == $this->nowPage)
          {
            $linkPage .= "<li class='paginate_button active'><a href='javascript:;'>".$this->page."</a></li>";
          }
          else
          {
            $linkPage .= "<li><a href='".$url.$this->decollator.$footer.$this->connector."$this->page'>".$this->page."</a></li>";
          }
          $this->page++;
        }
      }
      # 当前页在coolPages为1时，并且当前页在页码中间靠左
      elseif($this->nowPage < $mid)
      {
        #如1234567 当前页为3
        for($i = 1; $i <= $this->rollPage; $i++)
        {
          $this->page = $i;

          if($this->page == $this->nowPage)
          {
            $linkPage .= "<li class='paginate_button active'><a href='javascript:;'>".$this->page."</a></li>";
          }
          else
          {
            $linkPage .= "<li><a href='".$url.$this->decollator.$footer.$this->connector."$this->page'>".$this->page."</a></li>";
          }
        }
      }
      # 当前页在coolPages是最后一页时，直接循环出剩下的页面就行
      elseif($this->nowPage > $this->totalPages - $mid)
      {
        for($i = $this->totalPages - $this->rollPage + 1; $i <= $this->totalPages; $i++)
        {
          $this->page = $i;

          if($this->page == $this->nowPage)
          {
            $linkPage .= "<li class='paginate_button active'><a href='javascript:;'>".$this->page."</a></li>";
          }
          else
          {
            $linkPage .= "<li><a href='".$url.$this->decollator.$footer.$this->connector."$this->page'>".$this->page."</a></li>";
          }
        }
      }
    }

    $pageStr     =     str_replace(
      array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%linkPage%','%last%'),
      array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$firstPage,$linkPage,$lastPage),$this->config['theme']);

    return $pageStr;
  }
}
