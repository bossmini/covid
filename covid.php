<?php

$cv = curl_init();
// ตั้ง Url สำหรับดึงข้อมูล 
 curl_setopt($cv, CURLOPT_URL, "https://covid19.th-stat.com/api/open/today");
 header ("Content-type: text/html; charset=utf-8");

 curl_setopt($cv, CURLOPT_RETURNTRANSFER, 1);
// ตัวแปร $output เก็บข้อมูลทั้งหมดที่ดึงมา 
 $output = curl_exec($cv);

 $js_array=json_decode($output, true);


$notifyURL = "https://notify-api.line.me/api/notify";
$accToken = "kDk0CASPMwZMyhvqTl9bYBmLqRLRrOare60Mu3XoME8";
$headers = array(
 "Content-Type: application/x-www-form-urlencoded",
 "Authorization: Bearer ".$accToken);

$data = array(
    "message" => "
   รายงานสถานการณ์โควิด
   ผู้ติดเชื้อ : ".$js_array["Confirmed"]." คน
   หายแล้ว : ".$js_array["Recovered"]." คน
   รักษาตัว : ".$js_array["Hospitalized"]." คน
   เสียชีวิต : ".$js_array["Deaths"]." คน
   ติดเชื้อเพิ่ม : ".$js_array["NewConfirmed"]." คน
   ผู้ป่วยใหม่รักษาหายแล้ว : ".$js_array["NewRecovered"]." คน
   ผู้ป่วยใหม่รักษาตัว : ".$js_array["NewHospitalized"]." คน
   ผู้ป่วยใหม่เสียชีวิต : ".$js_array["NewDeaths"]." คน
   เวลาล่าสุด : ".$js_array["UpdateDate"]."" );

   $ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $notifyURL);
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2); 
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1); 
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $ch );
curl_close( $ch );
 
var_dump($result);
$result = json_decode($result,TRUE);

?>