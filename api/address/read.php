<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/address.php';
 
// instantiate database and address object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$address = new Address($db);

$stmt = $address->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // address array
    $address_arr=array();
    $address_arr["records"]=array();
 
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        extract($row);
 
        $address_item=array(
            "nim" => $nim,
            "nama" => $nama,
            "id_PS" => $id_PS,
            "status" => $status,
            "sks" => $sks,
            "upload_sempro" => $upload_sempro,
            "upload_semhas" => $upload_semhas,
            "upload_sidang" => $upload_sidang,
            "upload_validasi" => $upload_validasi,
            "uji_program" => $uji_program,
        );
 
        array_push($address_arr["records"], $address_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show address data in json format
    echo json_encode($address_arr);
}