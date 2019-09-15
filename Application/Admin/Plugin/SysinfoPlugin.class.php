<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 求职者控制器
 *     @english: Rsscontroller.class.php
 *
 * @version: 1.0
 * @desc   : 控制所有求职者信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2014-12-24 10:45:01
 */
class SysinfoPlugin
{
	/**
	 * 获取服务器实时信息，支持不同操作系统
	 */
	public function getinfo()
	{
		//error_reporting(0);    //会有多处报错，因此这里进行屏蔽
		$sysInfo = array();

		# 根据不同系统取得CPU相关信息
		switch(PHP_OS)
		{
			case "Linux":
				$sysReShow = (false !== ($sysInfo = self::sys_linux())) ? "show" : "none";
				break;

			case "FreeBSD":
				$sysReShow = (false !== ($sysInfo = self::sys_freebsd())) ? "show" : "none";
				break;

			case "WINNT":
				$sysReShow = (false !== ($sysInfo = self::sys_windows())) ? "show" : "none";
				break;

			default:
				break;
		}

		$sysInfo['sysReShow'] = $sysReShow;

		$result = array();
		$result['NetInput'] = 0;
		$result['NetOut']   = 0;
		$result['TotalMemory'] 			= "0 GB";
		$result['UsedMemory'] 			= "0 GB";
		$result['FreeMemory'] 			= "0 GB";
		$result['memPercent'] 			= "0";

		if('Linux' == PHP_OS)
		{
			self::getNetworkInformation($sysInfo);

			$tmp = array('memTotal', 'memUsed', 'memFree', 'memPercent','memCached', 'memRealPercent','memCachedPercent','swapTotal', 'swapUsed', 'swapFree', 'swapPercent');
			foreach ($tmp as $v) $sysInfo[$v] = $sysInfo[$v] ? $sysInfo[$v] : 0;

			# 网卡流量
			$strs = @file("/proc/net/dev");

			$NetOut=array();

			for ($i = 3; $i < count($strs); $i++ )
			{
				preg_match_all( "/([^\s]+):[\s]{0,}(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $strs[$i], $info );

				# $NetInput[$i] = formatsize($info[2][0]);
				# $NetOut[$i]  = formatsize($info[10][0]);

				$tmo = round($info[2][0]/1024/1024, 5);
				// $tmo2 = round($tmo / 1024, 5);
				$result['NetInput'] = $tmo;

				$tmp = round($info[10][0]/1024/1024, 5);
				// $tmp2 = round($tmp / 1024, 5);
				$result['NetOut'] = $tmp;
			}

			# 判断内存如果小于1GB，就显示M，否则显示GB单位
			if($sysInfo['memTotal']<1024)
			{
				$result['TotalMemory'] 			= $sysInfo['memTotal']." MB";
				$result['UsedMemory'] 			= $sysInfo['memUsed']." MB";
				$result['FreeMemory'] 			= $sysInfo['memFree']." MB";
				$result['memPercent'] 			= $sysInfo['memPercent'].'%';    # 内存总使用率
			}
			else
			{
				$result['TotalMemory'] 			= round($sysInfo['memTotal']/1024,3)." GB";
				$result['UsedMemory'] 			= round($sysInfo['memUsed']/1024,3)." GB";
				$result['FreeMemory'] 			= round($sysInfo['memFree']/1024,3)." GB";
				$result['memPercent'] 			= $sysInfo['memPercent']; //内存总使用率
			}
		}

		return $result;
	}

	# linux系统探测
	public function sys_linux()
	{
		# CPU
		if (false === ($str = @file("/proc/cpuinfo")))
		{
			return false;
		}

		$str = implode("", $str);

		// MEMORY
		if (false === ($str = @file("/proc/meminfo")))
		{
			return false;
		}

		$str = implode("", $str);
		preg_match_all("/MemTotal\s{0,}\:+\s{0,}([\d\.]+).+?MemFree\s{0,}\:+\s{0,}([\d\.]+).+?Cached\s{0,}\:+\s{0,}([\d\.]+).+?SwapTotal\s{0,}\:+\s{0,}([\d\.]+).+?SwapFree\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buf);
		preg_match_all("/Buffers\s{0,}\:+\s{0,}([\d\.]+)/s", $str, $buffers);
		$res['memTotal'] = round($buf[1][0]/1024, 2);
		$res['memFree'] = round($buf[2][0]/1024, 2);
		$res['memUsed'] = $res['memTotal']-$res['memFree'];
		$res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;

		return $res;
	}

	# FreeBSD系统探测
	public function sys_freebsd()
	{
		# MEMORY
		if (false === ($buf = self::get_key("hw.physmem")))
		{
			return false;
		}

		$res['memTotal'] = round($buf/1024/1024, 2);

		$str = self::get_key("vm.vmtotal");
		preg_match_all("/\nVirtual Memory[\:\s]*\(Total[\:\s]*([\d]+)K[\,\s]*Active[\:\s]*([\d]+)K\)\n/i", $str, $buff, PREG_SET_ORDER);
		preg_match_all("/\nReal Memory[\:\s]*\(Total[\:\s]*([\d]+)K[\,\s]*Active[\:\s]*([\d]+)K\)\n/i", $str, $buf, PREG_SET_ORDER);

		$res['memUsed'] = round($buf[0][1]/1024, 2) + $res['memCached'];
		$res['memFree'] = $res['memTotal'] - $res['memUsed'];
		$res['memPercent'] = (floatval($res['memTotal'])!=0)?round($res['memUsed']/$res['memTotal']*100,2):0;


		return $res;
	}

	# 取得参数值 FreeBSD
	private function get_key($keyName)
	{
		return self::do_command('sysctl', "-n $keyName");
	}

	# 确定执行文件位置 FreeBSD
	private function find_command($commandName)
	{
		$path = array('/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin');
		foreach($path as $p)
		{
			if (@is_executable("$p/$commandName")) return "$p/$commandName";
		}

		return false;
	}

	# 执行系统命令 FreeBSD
	private function do_command($commandName, $args)
	{
		$buffer = "";
		if (false === ($command = self::find_command($commandName)))
		{
		  return false;
		}

		if ($fp = @popen("$command $args", 'r'))
		{
			while (!@feof($fp)) $buffer .= @fgets($fp, 4096);
			return trim($buffer);
		}

		return false;
	}

	# windows系统探测
	public function sys_windows()
	{
		if (PHP_VERSION >= 5)
		{
			if(!class_exists('COM')) return false;
			$objLocator = new \COM("WbemScripting.SWbemLocator");
			$wmi = $objLocator->ConnectServer();
			$prop = $wmi->get("Win32_PnPEntity");
		}
		else
		{
			return false;
		}

		# SYSINFO
		$sysinfo = self::GetWMI($wmi,"Win32_OperatingSystem", array('LastBootUpTime','TotalVisibleMemorySize','FreePhysicalMemory','Caption','CSDVersion','SerialNumber','InstallDate'));


		# MEMORY
		$res['memTotal'] = round($sysinfo[0]['TotalVisibleMemorySize']/1024,2);
		$res['memFree'] = round($sysinfo[0]['FreePhysicalMemory']/1024,2);
		$res['memUsed'] = $res['memTotal']-$res['memFree'];	//上面两行已经除以1024,这行不用再除了
		$res['memPercent'] = round($res['memUsed'] / $res['memTotal']*100,2);

		return $res;
	}


	private function GetWMI($wmi,$strClass, $strValue = array())
	{
		$arrData = array();

		$objWEBM = $wmi->Get($strClass);
		$arrProp = $objWEBM->Properties_;
		$arrWEBMCol = $objWEBM->Instances_();
		foreach($arrWEBMCol as $objItem)
		{
			@reset(object2array($arrProp));
			$arrInstance = array();
			foreach($arrProp as $propItem)
			{
				eval("\$value = \$objItem->" . $propItem->Name . ";");
				if (empty($strValue))
				{
					$arrInstance[$propItem->Name] = trim($value);
				}
				else
				{
					if (in_array($propItem->Name, $strValue)) $arrInstance[$propItem->Name] = trim($value);
				}
			}
			$arrData[] = $arrInstance;
		}
		return $arrData;
	}



	# 得到网络使用信息
  public function getNetworkInformation(&$sysinfo)
  {
  	if ($sysinfo['sysReShow'] == 'show' && false !== ($strs = @file("/proc/net/dev")))
	  {
	    for ($i = 2; $i < count($strs); $i++)
	    {
	      preg_match_all("/([^\s]+):[\s]{0,}(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/", $strs[$i], $info);
	      $net_state.="{$info[1][0]} : 已接收 : <font color=\"#CC0000\"><span id=\"NetInput{$i}\">" . $sysinfo['NetInput' . $i] . "</span></font> GB &nbsp;&nbsp;&nbsp;&nbsp;已发送 : <font color=\"#CC0000\"><span id=\"NetOut{$i}\">" . $sysinfo['NetOut' . $i] . "</span></font> GB <br />";
	    }
	  }
// dump($sysinfo);exit;
	  $sysinfo['net_state'] = $net_state;
  }
}
