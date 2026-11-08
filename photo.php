<?php
require_once __DIR__.'/config.php';
$user=require_login();$id=(int)($_GET['id']??0);
$sql="SELECT p.filename,p.mime_type FROM photos p JOIN gallery_clients gc ON gc.gallery_id=p.gallery_id WHERE p.id=? AND gc.user_id=?";
if($user['role']==='admin'){$sql="SELECT p.filename,p.mime_type FROM photos p WHERE p.id=?";}
$s=db()->prepare($sql);$s->execute($user['role']==='admin'?[$id]:[$id,$user['id']]);$photo=$s->fetch();
if(!$photo){http_response_code(404);exit('Photo not found.');}
$path=UPLOAD_DIR.'/'.$photo['filename'];if(!is_file($path)){http_response_code(404);exit('Photo file missing.');}
header('Content-Type: '.$photo['mime_type']);header('Content-Length: '.filesize($path));header('X-Content-Type-Options: nosniff');header('Cache-Control: private, no-store');readfile($path);exit;
