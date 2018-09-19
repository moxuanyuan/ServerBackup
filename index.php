<?php
error_reporting(E_ALL);
use Ifsnop\Mysqldump as IMysqldump;


$access_key='91279893';
$dbname='';
$db_user='';
$db_password='';

$filename='db_'.date('Y-m-d');

if(isset($_GET['key']) && $_GET['key']==$access_key)
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


 