<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("charset=UTF-8");
    header("Acees-Control-Allow-Methods:POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers,Authorization,X-Requested-With");

    date_default_timezone_set("Asia/Almaty");

    include_once '../config/database.php';
    include_once '../objects/blog.php';

    $database = new Database();
    $db  = $database->getConnection();

    $blog = new Blog($db);

    $data = file_get_contents("php://input");

    $data = explode("&",$data);

    $H = $data[0];
    $T = $data[1];

    $H = explode("=",$H);
    $T = explode("=",$T);

    $Head = $H[1];
    $Text = $T[1];
    $Date_Pub = date("Y-m-d H:i:s");
    $user_id = $_SESSION['id_From_User'];

    if (!empty($H) & !empty($T)) {

        $blog->header = $Head;
        $blog->text = $Text;
        $blog->date_pub = $Date_Pub;
        $blog->user_id = $user_id;

        if ($blog->create()) {
            http_response_code(201);

            echo "<h1>".$blog->header."</h1>";
            echo "<p>".$blog->text."</p>";
            echo "<q>".$blog->date_pub."</q>";
//            echo $user_id." ";

            echo json_encode(["message"=>"Запись добавлена"],JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(503);
            echo json_encode(["message"=>"Ошибка при добавлении записи"],JSON_UNESCAPED_UNICODE);
        }
    } else {
         json_encode(array("message"=>"Заполните пустые данные"),JSON_UNESCAPED_UNICODE);
    }


?>