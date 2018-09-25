<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');
use Ifsnop\Mysqldump as IMysqldump;

/* access_key用作简单的访问控制 */
$access_key='';

/* 备份保留天数，整数，默认15天*/
$backup_keep_day=15;

/* 数据库参数 */
$dbname='';
$db_user='';
$db_password='';

$filename='db_'.$dbname.'_'.date('Y-m-d');
if(isset($_GET['access_key']) && $_GET['access_key']==$access_key)
{
    $directory=dirname(__FILE__);

    include_once($directory."/Mysqldump.php"); 

    $scanned_directory = array_diff(scandir($directory), array('..', '.'));

    $nowtime=time();

    foreach($scanned_directory as $v)
    {
        $filepath="{$directory}/$v";
        $path_parts = pathinfo($filepath);
        if($path_parts['extension']==='gz')
        {
            if(($nowtime-filemtime($filepath)) >= $backup_keep_day*24*60*60)
            {
               unlink($filepath); 
            }
        }
    } 

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
