<?php
define('DB', __DIR__ . '/data.txt');
function save($data)
{
    $tmp = "";
    foreach ($data as $value) {
        $tmp .= "data" . json_encode($value)."\n";
    }
    file_put_contents(DB, $tmp, FILE_APPEND);
}
function db($insert)
{
    $db   = explode('data', file_get_contents(DB));
    $data = [];
    foreach ($db as $item) {
        $tmp = json_decode($item);
        if (is_object($tmp)) {
            $data[] = $tmp->date;
        }
    }
    $insert = explode('data', $insert);
    foreach ($insert as $key => $value) {
        $value = json_decode($value);
        if (is_object($value)) {
            if (!in_array($value->date, $data)) {
                $data[] = $value->date;
                save([$value]);
            }
        }
    }
}
$data = isset($_POST['data']) ? $_POST['data']:''; //code timer data in txt format
db($data);