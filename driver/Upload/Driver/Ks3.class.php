<?php
/**
 * @tzp 414111907@qq.com
 * ks3上传
 */

namespace Think\Upload\Driver;
use Think\Exception;

require_once dirname(__FILE__)."/Ks3/Ks3Client.class.php";

class Ks3{
    /**
     * 上传文件根目录
     * @var string
     */
    private $rootPath;

    /**
     * 上传错误信息
     * @var string
     */
    private $error = ''; //上传错误信息

	private $config = array(
        'ACCESSKEY'     =>  '<AccessKeyID>',//https://ks3.console.ksyun.com/console.html#/setting 获取AccessKeyID 、AccessKeySecret
        'SECRETKEY'    =>  '<AccessKeySecret>',
        'ENDPOINT'    =>  'ks3-cn-shanghai.ksyun.com',//
        'BUCKET'    =>  '<bucket>',//请于管理后台创建bucket
        'DOMAIN'    =>'http://<bucket>.ks3-cn-shanghai.ksyun.com'//bucket所对应的外网地址
    );

    private static $ks3 = null;

    /**
     * 构造函数，用于设置上传根路径
     * @param string $root 根目录
     */

	public function __construct($root, $config = null){

        $this->rootPath = str_replace('./', '', $root);
		$domain = $this->config["DOMAIN"];


        $this->domain = $domain;

        if(!self::$ks3){
            self::$ks3 = new \Ks3Client($this->config["ACCESSKEY"], $this->config["SECRETKEY"], $this->config["ENDPOINT"]);
        }
     
     	self::$ks3 = new \Ks3Client($this->config["ACCESSKEY"], $this->config["SECRETKEY"], $this->config["ENDPOINT"]);
	}

    /**
     * 检测上传根目录
     * @return boolean true-检测通过，false-检测失败
     */
    public function checkRootPath(){
		if(strpos($this->rootPath,".")===0 || strpos($this->rootPath,"/")===1 || strpos($this->rootPath,"/")===0){
			$this->error = "根目录配置不正确";
			return false;			
		}
		return true;

    }    

    /**
     * 检测保存目录
     * @param  string $savepath 上传目录
     * @return boolean          检测结果，true-通过，false-失败
     */
	public function checkSavePath($savepath){
		return true;
    }


    /**
     * 创建文件夹 
     * @param  string $savepath 目录名称
     * @return boolean          true-创建成功，false-创建失败
     */
    public function mkdir($savepath){
    	return true;
    }

    /**
     * 保存指定文件
     * @param  array   $file    保存的文件信息
     * @param  boolean $replace 同名文件是否覆盖
     * @return boolean          保存状态，true-成功，false-失败
     */
    public function save(&$file,$replace=true) {

		$upload_config = C('UPLOAD_KS3_CONFIG');

    	$tagerPath = $upload_config['rootPath'].$file['savepath'].$file['savename'];

    	$selfPath = $file['tmp_name'];

        


    	try{
            $args = array(
                'Bucket'=>$this->config['BUCKET'],
                'Key'=>$tagerPath,
                'Content'=>array(
                    'content'=>$selfPath,
                    'seek_position'=>0
                ),
                'ACL'=>'public-read',
            );

			self::$ks3->putObjectByFile($args);
			$file['url'] = $this->domain."/".$tagerPath;
			return true;
		}catch(Exception $e){
			$this->error = $e->getMessage();
			return false;
		}
    }


    /**
     * 获取最后一次上传错误信息
     * @return string 错误信息
     */
    public function getError(){
        return $this->error;
    }    
}
