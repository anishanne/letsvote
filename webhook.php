<?php
$curl = curl_init("https://discordapp.com/api/webhooks/558456839508066344/asHbQCLVifvXk4IaMxMvr3VSOETFOF1H740PhTCEfbKE9ahdNkWCZFlFlYR-BWu6vYFw");
$text = "This is a test messasge";//($username."Logged in on " . date("Y/m/d") . " at " . date("h:i:s"));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array("content" => $text)));
echo  curl_exec($curl);
header("location: home.php")
?>
