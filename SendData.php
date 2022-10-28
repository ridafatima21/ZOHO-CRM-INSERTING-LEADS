<?php
    $response = array();
    //getting client_id, client_secret and refresh code from files, to generate access_token
    $file = fopen("refresh-token.txt", "r") or die("Unable to open file!");
    $refresh_token = fread($file, filesize("refresh-token.txt"));
    fclose($file);
    $file = fopen("client_id.txt", "r") or die("Unable to open file!");
    $client_id = fread($file, filesize("client_id.txt"));
    fclose($file);
    $file = fopen("client_secret.txt", "r") or die("Unable to open file!");
    $client_secret = fread($file, filesize("client_secret.txt"));
    fclose($file);
    $POST = [
        'refresh_token' => $refresh_token,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'refresh_token'
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://accounts.zoho.com/oauth/v2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($POST));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    $response_access_token = curl_exec($ch);
    $response_access_token = json_decode($response_access_token);
    //Data for sending to leads.
    $CompanyName = $_POST['CompanyName'];
    $LastName = $_POST['LastName'];
    $First_Name = $_POST['First_Name'];
    $State = $_POST['State'];
    $Email = $_POST['Email'];
    $postdata = [
        "data" => [
            [
                "Company" => $CompanyName,
                "Last_Name" => $LastName,
                "First_Name" => $First_Name,
                "Email" => $Email,
                "State" => $State
            ]
        ],
        "trigger" => [
            "approval",
            "workflow",
            "blueprint"
        ]
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.zohoapis.com/crm/v2/Leads");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Zoho-oauthtoken ' . $response_access_token->access_token, 'Content-Type: application/x-www-form-urlencoded'));
    $response_insert = curl_exec($ch);
    $response_insert = json_decode($response_insert); 
    if(isset($response_insert->data[0]->status))
    {
        $response['status'] = "success";
    }
    else
    {
        $response['message'] = $response_insert->code;
        $response['status'] = "error";
    }
    echo json_encode($response);
