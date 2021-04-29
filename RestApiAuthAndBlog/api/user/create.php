
<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Acees-Control-Allow-Methods:POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

    include_once '../config/database.php';
    include_once '../objects/user.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $data = (file_get_contents("php://input"));

        $data = explode("&",$data);


        $L = $data[0];
        $P = $data[1];

        $L = explode("=",$L);
        $P = explode("=",$P);

        $Log = $L[1];
        $Pass = $P[1];

    if (
        !empty($Log) &&
        !empty($Pass)
    ) {
        $user->login = $Log;
        $user->password = $Pass;


        if ($user->create()){
            http_response_code(201);
            echo json_encode(["message" => "Пользователь создан."],JSON_UNESCAPED_UNICODE);
        }

        else {
            http_response_code(503);
            echo json_encode(["message"=>"Пользователь уже есть!"],JSON_UNESCAPED_UNICODE);
        }
    }

    else {
        json_encode(array("message"=>"Недостаток данных"),JSON_UNESCAPED_UNICODE);
    }
?>


