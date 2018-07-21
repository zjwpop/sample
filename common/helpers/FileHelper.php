<?php
namespace common\helpers;

use Yii;
use common\services\QiniuService;

class FileHelper {
	public static function picUpload($file,$path='upload',$limit_size=1024000){
		$allowedExts = ["gif", "jpeg", "jpg", "png"];
		$temp = explode(".", $file["name"]);
		$extension = strtolower(end($temp));

		$type =["image/gif","image/jpeg","image/jpg","image/pjpeg","image/x-png","image/png"];
		$f_type=$file["type"];

		if(!in_array($extension, $allowedExts)){
			return ['errno'=>101,'msg'=>'not image extension'];
		}
		if(!in_array($f_type, $type)){
			return ['errno'=>102,'msg'=>'not image type'];
		}
		if($file['size']>$limit_size){
			return ['errno'=>103,'msg'=>'file size too large'];
		}
		if ($file["error"] > 0)
	    {
	        return ['errno'=>103,'msg'=>$file["error"]];
	    }

	    $file_name = sprintf('%s_%s.%s',date('Ymd_His'),mt_rand(100,999),$extension);
	    $dir=Yii::getAlias('@webroot/').$path;
	    if(!file_exists($dir)){
	    	mkdir($dir,'777');
	    }

	    $file_path = $dir.'/'.$file_name;
	    if(move_uploaded_file($file["tmp_name"],$file_path)){
	    	return ['errno'=>0,'file_path'=>$file_path ,'key'=>'/'.$path.'/'.$file_name,'file_name'=>$file_name];
	    }
	    else{
	        return ['errno'=>500,'msg'=>'upload erron'];
	    }
	}


	public static function qnUpload($file,$path='default',$limit_size=1024000, $private = false , $save_local=false){
		$upload = self::picUpload($file,'upload',$limit_size);
		if($upload['errno']>0){
			return $upload;
		}
		$file_path = $upload['file_path'];
		$key=$path.'/'.$upload['file_name'];

		if(QiniuService::upload($file_path,$key,$private)){
			$ret=$key;
			if($save_local===false){
	    		unlink($file_path);
	    	}
		}
		else{
			$ret=$upload['key'];
		}
		return ['errno'=>0,'key'=>$ret];
	}

}
