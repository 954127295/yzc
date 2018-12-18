<?php
$app_id='ijiashi';
$app_secret='i-jiashi@GXQ39#';
$mobile = '18663833571';
$phone=$mobile;
$content = "ff";
$secret=md5($app_id.$mobile.$app_secret.$content);
$url='http://59.110.22.217:8088/sms/send?app_id='.$app_id.'&secret='.$secret.'&phone='.$phone.'&content='.urlencode($content);
echo $url;exit;
$resp=file_get_contents($url);
echo $resp;