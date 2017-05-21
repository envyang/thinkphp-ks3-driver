<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }

    /**
     * 上传
     */
    public function upload(){
        $dir = I('request.dir') ? I('request.dir') : 'image';   // 上传类型image、flash、media、file
        $upload_driver = C('UPLOAD_DRIVER');
        $reay_file = array_shift($_FILES);
        if (!$upload_driver) {
            $return['error']   = 1;
            $return['success'] = 0;
            $return['status']  = 0;
            $return['message'] = '无效的文件上传驱动';
            return $return;
        }
        $ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb', 'mp4'),
            'file'  => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'wps', 'txt', 'zip', 'rar', 'gz', 'bz2', '7z'),
        );

        // 上传文件
        $upload_config['removeTrash'] = array($this, 'removeTrash');
        $upload = new Upload($upload_config, $upload_driver, C("UPLOAD_{$upload_driver}_CONFIG"));  // 实例化上传类
        $upload->exts = $ext_arr[$dir] ? $ext_arr[$dir] : $ext_arr['image'];    // 设置附件上传允许的类型，注意此处$dir为空时漏洞
        $info = $upload->uploadOne($reay_file);  // 上传文件
        if (!$info) {
            echo '上传出错'.$upload->getError();
        } else {
            // 获取上传数据
            echo '上传成功!文件结果信息为：<br/>';
            var_dump($info);
        }
    }



}