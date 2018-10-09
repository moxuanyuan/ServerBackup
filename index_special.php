<?php
@error_reporting(0);
@date_default_timezone_set('Asia/Shanghai');
@set_time_limit(0);

/* access_key用作简单的访问控制 */
$access_key='';

/* 备份保留天数，整数，默认15天*/
$backup_keep_day=15;

/* 数据库参数 */
$db_user='';
$db_password='';
$db_name='';

/* 以下非必要参数 */
/* 数据库发生错误时，重试次数，当数据库很大时备份时出现错误，可以设置更大的重试次数 */
//$query_retries = 20

/* 只需要备份的Tables */
//$include_tables=array();

/* 不需要备份的Tables */
//$exclude_tables = array();

$filename='db_'.$db_name.'_'.date('Y-m-d');

if(isset($_GET['access_key']) && $_GET['access_key']==$access_key)
{
    $directory=dirname(__FILE__); 

    $nowtime=time();

    $gzs=glob("*.gz");

    if(is_array($gzs))
    {
        foreach($gzs as $v)
        {
            $filepath="{$directory}/$v"; 
            if(($nowtime-filemtime($filepath)) >= $backup_keep_day*24*60*60)
            {
               @unlink($filepath); 
            }
        }
    } 
 
    include_once($directory."/dumper.php");

    try{
        $setting=array(
            'host' => '',
            'username' => $db_user,
            'password' => $db_password,
            'db_name' => $db_name
        );

        foreach(array('query_retries','include_tables','exclude_tables') as $v)
        {
            isset($$v) && ($setting[$v]=$$v);
        }

        $world_dumper = Shuttle_Dumper::create($setting);  
    
        $world_dumper->dump($filename.'.sql.gz'); 
    } catch(Shuttle_Exception $e) {
        echo "Couldn't dump database: " . $e->getMessage();
    }

}