<?php

/*******************************************************
 * Only these origins will be allowed to upload images *
 ******************************************************/
$accepted_origins = ["http://localhost", "http://127.0.0.1", "http://cms-admin.loc"];

/*********************************************
 * Change this line to set the upload folder *
 *********************************************/
$imageFolder = $_SERVER['DOCUMENT_ROOT'] . '/app/data/editor/';
/*********************************************/

if (!file_exists($imageFolder)) {
    mkdir($imageFolder, 0755, true);
}

reset ($_FILES);
$temp = current($_FILES);

if (is_uploaded_file($temp['tmp_name'])){
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        } else {
            header("HTTP/1.1 403 Origin Denied");
            return;
        }
    }

    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }

    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }

    $filetowrite = $imageFolder . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    echo json_encode(['location' => $_SERVER['HTTP_ORIGIN'] . '/app/data/editor/' . $temp['name']]);
    //echo json_encode(['location' => $filetowrite]);
} else {
    header("HTTP/1.1 500 Server Error");
}
