<?php
use AliyunMNS\Client;
use AliyunMNS\Requests\SendMessageRequest;
use AliyunMNS\Requests\CreateQueueRequest;
use AliyunMNS\Requests\BatchReceiveMessageRequest;
use AliyunMNS\Exception\MnsException;

class yzc{

	// 获取 阿里云 MNS 对象
	public function ali_mns_obj(){
		// 先往队列里面发消息试试
		$accessId = "LTAIZi0m78Ije8QG";
		$accessKey = "RGq2ALhgbSBfKmasIc5IDJJAlWu0Ya";
		$endPoint = "http://1691942791450205.mns.cn-shanghai.aliyuncs.com/";
		//这里需要先在控制台新建队列
		$queueName = 'aliyun-iot-a1m3yx5oS4o';
		//实例化获取MNS对象
		$client = new Client($endPoint, $accessId, $accessKey);
		$queue = $client->getQueueRef($queueName);
		return $queue;
	}

	public function msnew(){
		return new BatchReceiveMessageRequest(1,0);
	}

	private function fetch_redis(){
		$redis = new Redis();
		$redis->connect("127.0.0.1",6379);
		return $redis;
	}

	public function data_processing($data=''){
		// $data = '{"payload":"eyJJRCI6NzAwMDAwMSwiSFUiOjQ3LjgsIkFNIjoiLS0iLCJIMlMiOiItLSIsIkNPMiI6OTI3LCJOUCI6Ii0tIiwiTEkiOiItLSIsIlBNIjoiLS0iLCJXIjowLjAwLCJUMSI6MTYuMCwiVDIiOjIwLjAsIlQzIjoxNi4zLCJFMSI6MC4yMSwiRTIiOiItLSIsIkUzIjoiLS0iLCJFNCI6Ii0tIiwiRTUiOiItLSIsIkU2IjoiLS0iLCJXQSI6MCwiRUEiOjEsIlQxQSI6MCwiVDJBIjowLCJUM0EiOjAsIlBMQSI6MCwiSFRBIjowLCJMVEEiOjAsIklTQSI6MCwiVElNRSI6IjIwMTgtMTItMTMgMTU6NTU6MDcifQ==","messagetype":"upload","topic":"/a1m3yx5oS4o/7000001/up","messageid":1073124162769526784,"timestamp":1544687712}';
		$data_arr = json_decode($data,true);
		$msg = json_decode(base64_decode($data_arr['payload']),true);
		$msg['SID'] = $msg['ID'];
		unset($msg['ID']);
		$redis = $this->fetch_redis();
		print_r($msg);
        echo PHP_EOL;
        echo PHP_EOL;
		$redis->rpush("yzc",serialize($msg));
		// $count = $sth->rowCount();//受影响行数
	}

	public function handle_msg_list(){
	    for ($i=0; $i < 100; $i++) {  // 10 * 16  每次运行处理160条
	    //先调用上面的方法，获取MNS对象
	      $queue = $this->ali_mns_obj();
	      //用MNS对象调用MNS提供的接口。这边是批量拉取活跃数据
	      //16代表每次最多拉取16条数据
	      //30代表失效，30秒拉取不到则失败
	      $obj_receives = $queue->batchReceiveMessage($this->msnew());
	      //拉取到数据之后，循环，使用getMessages()方法获取到消息内容
	      foreach ($obj_receives->getMessages() as $k) {
	        // 示例数据
	        // {"payload":"c3RfZm8=","messagetype":"upload","messageid":307,"topic":"/q5dL8yereAg/ssc-cl-00002/update","timestamp":1510991583}
	        //使用getMessageBody()方法获取消息的主体部分，注意，需要解密
	        $msg = $k->getMessageBody(); // payload部分数据，需 base64解码
	        $this->data_processing($msg);
	        // $obj = json_decode($msg);
	        // $d['str'] = base64_decode($obj->payload);
	        // $d['time'] = date('Y-m-d h:i:s', $obj->timestamp  );
	        // //这里是判断消息的类型。其实到这一步，已经成功获取到消息了
	        // if( $obj->messagetype == 'upload' ){
	        //   $this->ali_mns_handle($obj); // 如果是机器上传的信息，则处理
	        // }
	        // $str = json_encode($d);
	        // // 给硬件人员看
	        // if( $str!=false ){
	        //   Redis::lPush('ali_iot_mns_list', $str);
	        // }
	        // // 删除
	        $queue->deleteMessage(   $k->getReceiptHandle()  );
	      }
	    }
	    return MyResponse::success();
	  }
}

set_time_limit(0);
require_once('./mns-autoloader.php');
$yzc = new yzc();
$result = $yzc->handle_msg_list();
// $result = $yzc->data_processing();
print_r($result);