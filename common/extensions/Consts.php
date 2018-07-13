<?php
/**
 * 公共方法类
 */

namespace common\extensions;

use yii;
use yii\helpers\ArrayHelper;

class Consts{
	// 详解分类
	public static $explain_type=[
	'2'=>'加速时间','3'=>'刹车距离','23'=>'油耗/能耗','40'=>'噪音',
	'29'=>'中控方向盘','30'=>'乘坐空间','31'=>'天窗规格','51'=>'储物空间','32'=>'后备厢',
	'44'=>'车身尺寸','38'=>'车轮轮胎','35'=>'动力系统','36'=>'车辆悬架','47'=>'底盘细节','46'=>'防撞梁','37'=>'涉水性',
	'26'=>'四驱结构','27'=>'四驱性能',
	'42'=>'保养周期','43'=>'保养费用'
	];
	
	// 详解分组
	public static $explain_group=[ 
							['name'=>'实测','members'=>['2','3','23','40']],
							['name'=>'内装','members'=>['29','30','31','51','32']],
							['name'=>'结构','members'=>['44','38','35','36','47','46','37']],
							['name'=>'四驱','members'=>['26','37']],
							['name'=>'实测','members'=>['42','43']]
						];

	// 车系参数
	public static $params_type=[
		'base'=>'基本参数',
		'car_body'=>'车身',
		'engine'=>'发动机',
		'motor'=>'电动机',
		'gear_box'=>'变速箱',
		'underpan'=>'底盘转向',
		'wheel_brake'=>'车轮制动',
		'security_equipment'=>'主/被动安全装备',
		'holding_equipment'=>'辅助/操控配置',
		'against_burglars'=>'外部/防盗配置',
		'inner'=>'内部配置',
		'seat'=>'座椅配置',
		'media'=>'多媒体配置',
		'light'=>'灯光配置',
		'rearview_mirror'=>'玻璃/后视镜',
		'air_conditioning'=>'空调/冰箱'];

	// 文章分类
	public static $article_type=['1'=>'新闻','60'=>'导购','3'=>'测评','82'=>'用车','102'=>'技术','97'=>'文化'];

	// 车款图片分类
	public static $spec_img_type=['1'=>"车身外观",'10'=>"中控方向盘",'3'=>"车厢座椅",'12'=>"其它细节",'13'=>"评测",'14'=>"重要特点"];
		
	public static function explainTypeMap($id=null){
		if($id===null){
			return self::explainTypeTree();
		}
		return ArrayHelper::getValue(self::$explain_type,$id,$id);
	}
	
	public static function explainKey(){
		$keies=[];
		foreach(self::$explain_type as $key=>$val){
			array_push($keies,$key);
		}
		return $keies;
	}
	
	public static function explainTypeTree(){
		$ret=[];
		foreach(self::$explain_group as $tiem){
			$ret[]=['key'=>'0','name'=>$tiem['name']];
			$members=$tiem['members'];
			foreach($members as $val){
				$ret[]=['key'=>$val,'name'=>self::explainTypeMap($val)];
			}	
		}
		return $ret;
	}
	
	public static function articleTpyeMap($id=null){
		if($id===null){
			return self::$article_type;
			}
		else {
			return ArrayHelper::getValue(self::$article_type,$id,$id);
		}
	}
	
	public static function paramsTypeMap($id=null){
		if($id===null){
			return self::$params_type;
			}
		else {
			return ArrayHelper::getValue(self::$params_type,$id,$id);
		}
	}
	
	public static function specImgTypeMap($id=null){
		if($id===null){
			return self::$spec_img_type;
			}
		else {
			return ArrayHelper::getValue(self::$spec_img_type,$id,$id);
		}
	}
}