# ServerBackup
## 0. Main

## 1. 备份数据库
- 下载MySQLDump，<https://github.com/ifsnop/mysqldump-php>
- 在服务器根目录新建文件夹"DBbackup"，上传Mysqldump.php到"DBbackup"
- 在"DBbackup"文件夹下，新建.htaccess方件，内容如下:
**.htaccess**

        RedirectMatch 403 ^/.+gz$
.htaccess文件主要作用是防止可以通过浏览器直接下载数据库备份文件
- 在"DBbackup"文件夹下，新建index.php，内容如下:
**index.php**

        <?php
        error_reporting(E_ALL);
        use Ifsnop\Mysqldump as IMysqldump;

        /* access_key用作简单的访问控制 */
        $access_key='91279893';
        /* 数据库参数 */
        $dbname='';
        $db_user='';
        $db_password='';
      
        $filename='db_'.date('Y-m-d');
        if(isset($_GET['access_key']) && $_GET['access_key']==$access_key)
        {
            include_once(dirname(__FILE__) . "/Mysqldump.php"); 
            $dumpSettings = array( 
                'compress' => IMysqldump\Mysqldump::GZIP,
                'add-drop-table'=>true
            );
       
            $dump = new IMysqldump\Mysqldump(
                "mysql:host=localhost;dbname={$dbname}",
                $db_user,
                $db_password,
                $dumpSettings
            );
            $dump->start($filename.'.sql.gz');
        }

- 打开 http://yourdomain/DBbackup/?access_key=91279893，则在"DBbackup"目录下生成数据库备份文件"db_xxxx-xx-xx.sql.gz"
