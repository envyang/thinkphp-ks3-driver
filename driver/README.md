
##  驱动代码使用方法

该目录为驱动的代码目录，使用时只需几步即可完成配置：
* 将Conf中config.php的文件内容拷贝或替换需要的模块config.php配置文件中。
* 将Upload/Driver中的文件拷贝至/ThinkPHP/Library/Think/Upload/Driver中
* 在Driver/Ks3.class.php中修改所需配置
* 使用时，只须调用Upload类即可使用KS3存储，无须重复代码。具体使用方法请见demo

注：该项目基于KS3文档版本号为V1.2.2