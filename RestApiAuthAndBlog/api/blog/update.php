<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("charset = UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../objects/blog.php';

    date_default_timezone_set("Asia/Almaty");

    $database = new Database();
    $db = $database->getConnection();


    $blog = new Blog($db);



    $data = (file_get_contents("php://input"));

    $data = explode("&",$data);

    $i = $data[0];
    $h =$data[1];
    $t= $data[2];

    $i = explode("=",$i);
    $h = explode("=",$h);
    $t = explode("=",$t);

    $id = $i[1];
    $header = $h[1];
    $text = $t[1];
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


    if (isset($id) && isset($header) && isset($text)) {

        $blog->header = $header;
        $blog->text = $text;
        $blog->date_pub = date("Y-m-d_h:i:s");



            if ($_SESSION['id_From_User'] != $user_id){
                echo json_encode(["message"=>"Запись вы не можете изменять данную запись!"],JSON_UNESCAPED_UNICODE);
                http_response_code(503);
                die();
            }

        if ($blog->update()){
            http_response_code(201);

            echo json_encode(["message" => "Запись обновленна."],JSON_UNESCAPED_UNICODE);
//                echo "<h1>".$blog->id."</h1>";
                echo "<h1>".$blog->header."</h1>";
                echo "<p>".$blog->text."</p>";
               echo "<q>$blog->date_pub</q>";



        }
        else {
            http_response_code(503);
            echo json_encode(["message"=>"Запись не найдена!"],JSON_UNESCAPED_UNICODE);
        }
    } else {
        json_encode(array("message"=>"Недостаток данных"),JSON_UNESCAPED_UNICODE);
    }



?>