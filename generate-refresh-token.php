<?php
ob_start();
function generate_refresh_token($code, $client_id, $client_secret)
{
    $POST = [
        'code' => $code,
        'redirect_uri' => 'https://www.google.com',
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'authorization_code'

    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://accounts.zoho.com/oauth/v2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($POST));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    $response = curl_exec($ch);
    $response = json_decode($response);
    //saving client_id refresh token and client_secret to files. so that it can be reused.
    $filename1 = "client_id.txt";
    $filename2 = "client_secret.txt";
    $filename3 = "refresh-token.txt";
    file_put_contents($filename1, $client_id);
    file_put_contents($filename2, $client_secret);
    file_put_contents($filename3, $response->refresh_token);
    header("location: index.php");
}
//Please add your code, client_id and client_secret here to get these, go to: https://api-console.zoho.com/
//Important: you have to add code and run this file within a selected time period, otherwise it will not work.
generate_refresh_token('code', 'client_id', 'client_secret');
?>