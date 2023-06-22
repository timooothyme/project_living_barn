<?php
  $cityOrigin      = $_GET["origin"];
  $cityDestination = $_GET["destination"];
  $weight          = $_GET["weight"];
  $courier         = $_GET["courier"];

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "origin=$cityOrigin&destination=$cityDestination&weight=$weight&courier=$courier",
    CURLOPT_HTTPHEADER => array(
      "content-type: application/x-www-form-urlencoded",
      "key: 4fb242a1c81734fe8b29980346dc64c8"
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    $data = json_decode($response);
    echo $data->rajaongkir->results[0]->costs[0]->cost[0]->value;
  }
?>