<?php
class Database
{
    private static $dbName = 'domain_system';
    private static $dbHost = '147.182.189.109';
    private static $dbUsername = 'domain_user';
    private static $dbUserPassword = 'Jbp=aZb1QZ={96Pi';

    private static $cont = null;

    public function __construct()
    {
        exit('Init function is not allowed');
    }

    public static function connect()
    {
        // One connection through whole application
        if (null == self::$cont) {
            try {
                self::$cont = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword, [PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo"<pre/>";print_r($_GET);
$res = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
echo"<pre/>";print_r($res);
die;
try {
	$sql = "INSERT INTO clicker_phone (phone,date_added) values (?,?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($_GET['phone'],date('Y-m-d H:i:s')));
	
	echo $_GET['phone']; die;
	
}catch(Exception $e) {
	echo 'Message: ' .$e->getMessage(); die;
}
die;
$domain = $_SERVER['HTTP_HOST'];
$clist_sql = "SELECT wildcard_url FROM `ssl_domains` WHERE `domain_name` = ?";
$result_clist = $pdo->prepare($clist_sql);
$result_clist->execute(array($domain));
$list = $result_clist->fetch();

if(isset($list['wildcard_url'])){
	$queryString =  http_build_query($_GET);
	if (strpos($list['wildcard_url'], '?') == false) {
		$redirect_link = $list['wildcard_url']."?".$queryString;
	}elseif (strpos($list['wildcard_url'], '&') !== false) {
		$redirect_link = $list['wildcard_url']."&".$queryString;
	}	
	header("Location:".$redirect_link);
}else{
	echo "Link not found.";
}
?>