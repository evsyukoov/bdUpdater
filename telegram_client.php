<?php

use danog\MadelineProto\API;

if (!file_exists(__DIR__ . '/madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', __DIR__ . '/madeline.php');
}
include __DIR__ . '/madeline.php';
require_once("DAO.php");

$conn = new DAO();
$arr = $conn->selectIDs();
$settings['app_info']['api_id'] = ;
$settings['app_info']['api_hash'] = '';

$MadelineProto = new API('session.madeline');
$MadelineProto->start();

$users = $MadelineProto->users->getUsers(['id' => $arr, ]);
execute($users, $conn);

function  execute($users, DAO $conn) {
    $conn->initConnection();
    foreach ($users as $key => $value){
        $name = "None";
        $id  = $value['id'];
        $first_name = isset($value['first_name']) ? $value['first_name'] : null;
        $last_name = isset($value['last_name']) ? $value['last_name'] : null;
        $nick = isset($value['username']) ? $value['username'] : null;
        if ($nick == null)
            $nick = "None";
        if ($first_name && $last_name)
            $name = $first_name . " " . $last_name;
        else if (!$first_name && $last_name)
            $name = $last_name;
        else if ($first_name && !$last_name)
            $name = $first_name;
        print $name . " " . $nick;
        $conn->updateDB($name, $nick, $id);
    }
    $conn->closeConnection();
}




