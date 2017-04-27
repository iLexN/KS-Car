<?php

$curl = curl_init();

$url = 'https://ks-motor.pacificprime.com/api/getPrice.php';
$user = '';
$pass = '';

$data = [];
$data['ncd'] = 20;
$data['age'] = 28;
$data['drivingExp'] = 'gt_2yr';
$data['insuranceType'] = 'Third_Party_Only';
$data['yearManufacture'] = '2016';
$data['make'] = 1;
$data['model'] = 3;
$data['occupation'] = 1;


curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => http_build_query($data),
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic " . base64_encode($user . ":" . $pass),
  ),
  CURLOPT_CAINFO => __DIR__ . '/cacert.pem',
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;

  $data['referer'] = 'gobear';
  $data['utm_source'] = 'gobear';

  //url go to kwiksure.com motor form
  $formUrl = [
        'en' => 'https://kwiksure.com/quote/motor/direct-link/?'.http_build_query($data),
        'zh' => 'https://kwiksure.com/zh/quote/motor/direct-link/?'.http_build_query($data),
  ];
}
