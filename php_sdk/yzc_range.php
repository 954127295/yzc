<?php
class rrange{
	public function put_list(){
		$redis = $this->fetch_redis();
		$res = $redis->lpop("yzc");
		return $res;
	}
	public function fetch_pdo(){
		$dbms='mysql';
		$host='47.101.177.160';
		$dbName='yzc';
		$user='yzc';
		$pass='yzc';
		$dsn="$dbms:host=$host;dbname=$dbName";
		$dbh = new PDO($dsn, $user, $pass);
		return $dbh;
	}
	private function fetch_redis(){
		$redis = new Redis();
		$redis->connect("127.0.0.1",6379);
		return $redis;
	}
}
$r = new rrange();
$list = $r->put_list();
$list_arr = unserialize($list);
$keys = array_keys($list_arr);
$values = array_values($list_arr);
$keys_str = '`'.implode("`,`",$keys).'`';
$values_str = "'".implode("','",$values)."'";
$sql = "insert into pig_hardware(".str_replace("--",0,$keys_str).") values(".str_replace("--",0,$values_str).")";
$dbh = $r->fetch_pdo();
$dbh->exec($sql);
