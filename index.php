<?php
error_reporting(E_ALL);
use Ifsnop\Mysqldump as IMysqldump;

/* access_key用作简单的访问控制 */
$access_key='';
/* 数据库参数 */
$dbname='';
$db_user='';
$db_password='';

$filename='db_'.$dbname.'_'.date('Y-m-d');
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
