<?php
class rrange{
	public function put_list(){
		$redis = $this->fetch_redis();
		$res = $redis->lpop("yzct");
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
	//发送报警信息
	private function put_bj($content){
		echo $content;
		echo PHP_EOL;
	}
	//获取报警信息
    public function get_bj($str){
    	echo $str;
        $len = strlen($str);
        $len_c = 32-$len;
        $result_str = '';
        for($i=0;$i<$len_c;$i++){
        	$result_str = '0'.$result_str;
        }
        $result_str = $result_str.$str;
        for($j=0;$j<32;$j++){
        	if($result_str{$j} == 1){
        		switch($j){
        			case 1:
        			$this->put_bj("系统通信故障");
        			break;
        			case 6:
        			$this->put_bj("EEPROM读出错");
        			break;
        			case 9:
        			$this->put_bj("温度传感器1故障");
        			break;
        			case 10:
        			$this->put_bj("温度传感器2故障");
        			break;
        			case 11:
        			$this->put_bj("饲喂1超时");
        			break;
        			case 12:
        			$this->put_bj("饲喂2超时");
        			break;
        			case 13:
        			$this->put_bj("低温报警");
        			break;
        			case 14:
        			$this->put_bj("高温报警");
        			break;
        			case 15:
        			$this->put_bj("定速风机1过流");
        			break;
        			case 16:
        			$this->put_bj("定速风机2过流");
        			break;
        			case 17:
        			$this->put_bj("定速风机3过流");
        			break;
        			case 18:
        			$this->put_bj("定速风机4过流");
        			break;
        			case 19:
        			$this->put_bj("定速风机5过流");
        			break;
        			case 20:
        			$this->put_bj("定速风机6过流");
        			break;
        			case 21:
        			$this->put_bj("定速风机7过流");
        			break;
        			case 26:
        			$this->put_bj("缺相L2故障");
        			break;
        			case 27:
        			$this->put_bj("缺相L3故障");
        			break;
        			case 28:
        			$this->put_bj("总开关断开");
        			break;
        			case 29:
        			$this->put_bj("环控器硬件版本与软件程序不匹配");
        			break;
        			case 30:
        			$this->put_bj("组内环控器ID与本机重复");
        			break;
        		}
        	}
        }
    }
}
$r = new rrange();
$list = $r->put_list();
$list_arr = unserialize($list);
$result = $list_arr['devList'];
foreach($result as $li){
	$key = '';
	$value = '';
	foreach($li['varList'] as $vl){
		$key .= "`".trim($vl['varName'])."`,";
		$value .= "'".trim($vl['varValue'])."',";
		if($vl['varName'] == "RS24"){
			$StrToBin = decbin($vl['varValue']);
			$r->get_bj($StrToBin);
		}
	}
	$key .= "`TIME`";
	$value .= "'".$list_arr['timestamp']."'";
	$sql = "insert into pig_hardwaret(".$key.") values(".$value.")";
	$dbh = $r->fetch_pdo();
	$dbh->exec($sql);
}
