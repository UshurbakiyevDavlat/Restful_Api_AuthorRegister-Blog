<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/blog.php';

    $database = new Database();
    $db = $database->getConnection();
        $id = $_POST['id'];

    $blog = new Blog($db);
    $blog->id = $id;

    $stmt = $blog->read();
    $num = $stmt->rowCount();




    if ($num > 0) {
        $blog_arr  = [];


        $header = '';
        $text = '';
        $date_publicate='';
        $login = '';
        $user_id = '';

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $blog_item = array(
                "header" => $header,
                "text" => $text,
                "date_publicate" =>$date_publicate,
                "author"=>$login,
                "user_id"=>$user_id
            );
        }
        array_push($blog_arr,$blog_item);

        foreach ($blog_arr as $item) {
            echo "<h1>".$item['header']."</h1>";
            echo "<p>".$item['text']."</p>";
            echo "<q>".$item['date_publicate']."</q>";
            echo "<h2>".$item['author']."</h2>";

        }
        http_response_code(200);

    } else {
        http_response_code(404);
        echo json_encode(array("message" =>"Запись не найдена."),JSON_UNESCAPED_UNICODE);
    }
?>