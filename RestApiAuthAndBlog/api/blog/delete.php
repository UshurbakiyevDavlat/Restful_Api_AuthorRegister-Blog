<?php
    session_start();

    header("Access-Control-Allow-origin:*");
    header("Content-Type:application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/blog.php';

    $database = new Database();
    $db = $database->getConnection();
    $id = $_POST['id'];

    $blog = new Blog($db);
    $blog->id = $id;

    $stmt = $blog->read();
    $num = $stmt->rowCount();


    $user_id = '';

    if ($num > 0) {
        $blog_arr = [];


        $header = '';
        $text = '';
        $date_publicate = '';
        $login = '';


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $blog_item = array(
                "header" => $header,
                "text" => $text,
                "date_publicate" => $date_publicate,
                "author" => $login,
                "user_id" => $user_id
            );
        }
    }

    if ($_SESSION['id_From_User'] != $user_id){
        echo json_encode(["message"=>"Запись вы не можете удалить данную запись!"],JSON_UNESCAPED_UNICODE);
        http_response_code(503);
        die();
    }

    if ( $stmt = $blog->delete()) {
        http_response_code(200);
        echo json_encode(array("message" =>"Запись удалена."),JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode(array("message" =>"Запись не найдена."),JSON_UNESCAPED_UNICODE);
    }


?>