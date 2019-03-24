<?php
function postToDiscord($message)
{
    $data = array("content" => $message, "username" => "Webhooks");
    $curl = curl_init("https://discordapp.com/api/webhooks/558456839508066344/asHbQCLVifvXk4IaMxMvr3VSOETFOF1H740PhTCEfbKE9ahdNkWCZFlFlYR-BWu6vYFw");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($curl);
}

postToDiscord("This is a test message.");

echo "Message sent successfully";
?>
