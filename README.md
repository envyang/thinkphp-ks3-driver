## 简介

thinkphp-ks3-driver是基于thinkphp和金山ks3对象存储所开发的一款上传驱动，ks3文档版本号为v1.2.2，使用时请注意金山ks3版本号兼容性。

如有使用问题，请将问题详情email至ivyang@live.cn

* 集成thinkphp
* 一键切换金山云driver存储
* 多种存储方式共存


##  driver使用方法

* 将Conf中config.php的文件内容拷贝或替换需要的模块config.php配置文件中。
* 将Upload/Driver中的文件拷贝至/ThinkPHP/Library/Think/Upload/Driver中
* 在Driver/Ks3.class.php中修改所需配置
* 使用时，只须调用Upload类即可使用KS3存储，无须重复代码。具体使用方法请见demo