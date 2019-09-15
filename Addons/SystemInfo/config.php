<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 系统环境信息配置文件
 *     @english: config.php
 *
 * @version: 1.0
 * @desc   : 设置系统环境信息的配置文件
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-12 13:40:21
 */
return array
(
	'title'=>array  # 配置在表单中的键名 ,这个会是config[title]
	(
		'title'=>'显示标题:',	# 表单的文字
		'type'=>'text',		 		# 表单的类型：text、textarea、checkbox、radio、select等
		'value'=>'系统信息',	# 表单的默认值
	),
	
	'width'=>array
	(
		'title'=>'显示宽度:',
		'type'=>'select',
		'options'=>array
		(
			'1'=>'1格',
			'2'=>'2格',
			'4'=>'4格'
		),
		'value'=>'2'
	),

	'display'=>array
	(
		'title'=>'是否显示:',
		'type'=>'radio',
		'options'=>array
		(
			'1'=>'显示',
			'0'=>'不显示'
		),
		'value'=>'1'
	)
);