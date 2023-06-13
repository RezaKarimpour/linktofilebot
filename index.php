<?php
/*
creator github: https://github.com/RezaKarimpour
*/

define ('BOT_TOKEN','YOUR_TOKEN');
define ('API_URL','https://api.telegram.org/bot'.BOT_TOKEN.'/');

function msg($method,$parm){
    if(!$parm){
        $parm = array();
    }
    $parm["method"] = $method;
    $handle = curl_init(API_URL);
    curl_setopt($handle,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($handle,CURLOPT_CONNECTTIMEOUT,60);
    curl_setopt($handle,CURLOPT_TIMEOUT,60);
    curl_setopt($handle,CURLOPT_POSTFIELDS,json_encode($parm));
    curl_setopt($handle,CURLOPT_HTTPHEADER,array("Content-Type:application/json"));
    $result = curl_exec($handle);
    return $result;
}


$content = file_get_contents("php://input");
$update = json_decode($content,true);
$chat_id = $update["message"]['chat']['id'];
$text = $update["message"]['text'];
$msg_id = $update["message"]['message_id'];


///////////////////////////////////////////////////////////////////////////////////////////////////////
    $headers = get_headers($text , 1);
    $content_type = $headers["Content-Type"];
    // Get the content length from the headers
    $file_size = $headers['Content-Length'];
    $file_size_human = round($file_size / 1024 / 1024, 2) . ' MB';
    
    if (strpos($content_type, "video") !== false) {
	              if($file_size_human < 49){ 
	msg("sendChatAction",array('chat_id'=>$chat_id,'action'=>"upload_video"));
	msg("sendVideo",array('chat_id'=>$chat_id,'video'=>$text));
        }else{
            msg("sendChatAction",array('chat_id'=>$chat_id,'action'=>"typing "));
             msg("sendMessage",array('chat_id'=>$chat_id,'text'=>'حجم فایل زیاده نمیشه ارسال کرد'));
             }
	
    } elseif (strpos($content_type, "image") !== false) {
        if($file_size_human < 49){
        msg("sendChatAction",array('chat_id'=>$chat_id,'action'=>"upload_photo"));
        msg("sendPhoto",array('chat_id'=>$chat_id,'photo'=>$text));}
        else{
            msg("sendChatAction",array('chat_id'=>$chat_id,'action'=>"typing "));
             msg("sendMessage",array('chat_id'=>$chat_id,'text'=>'حجم فایل زیاده نمیشه ارسال کرد'));
        }
        
    }  elseif (strpos($content_type, "audio") !== false) {
         if($file_size_human < 49){
        msg("sendChatAction",array('chat_id'=>$chat_id,'action'=>"upload_voice"));         
        msg("sendAudio",array('chat_id'=>$chat_id,'audio'=>$text));
                  
              }
        else{
            msg("sendChatAction",array('chat_id'=>$chat_id,'action'=>"typing "));
             msg("sendMessage",array('chat_id'=>$chat_id,'text'=>'حجم فایل زیاده نمیشه ارسال کرد'));
        }
    } else {
        
      if($file_size_human < 49){
        msg("sendChatAction",array('chat_id'=>$chat_id,'action'=>"upload_document"));      
        msg("sendDocument",array('chat_id'=>$chat_id,'document'=>$text));}
        else{
            msg("sendChatAction",array('chat_id'=>$chat_id,'action'=>"typing "));
             msg("sendMessage",array('chat_id'=>$chat_id,'text'=>'حجم فایل زیاده نمیشه ارسال کرد'));
        }
        
        
    }







?>
