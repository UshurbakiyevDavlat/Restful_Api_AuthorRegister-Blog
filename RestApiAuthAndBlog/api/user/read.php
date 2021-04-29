<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    //connect with Db
    include_once '../config/database.php';
    include_once '../objects/user.php';

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    //Reading users
        $stmt = $user->read();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $users_arr = array();

            $id = '';
            $login='';
            $password='';

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                    $user_item = array(
                        "id" => $id,
                        "login" => $login,
                        "password" => $password
                    );
                array_push($users_arr,$user_item);

                }


                print_r($users_arr);

            $data = (file_get_contents("php://input"));

            $data = explode("&",$data);


            $L = $data[0];
            $P = $data[1];

            $L = explode("=",$L);
            $P = explode("=",$P);

            $Log = $L[1];
            $Pass = $P[1];
            foreach ($users_arr as $item) {
                if ($item['login'] == $Log && $item['password'] == $Pass) {

                    http_response_code(200);
                    print_r($users_arr);

//                $_POST['id'] = $id;
                    $_SESSION['id_From_User'] = $id;

                    $host = $_SERVER['HTTP_HOST'];
                    echo $_SERVER['PHP_SELF'];

//                $uri   = rtrim(dirname("/htdocs/RestApiAuthAndBlog/api/blog/createForm.php"), '/\\');
//                $extra = 'createForm.php';
                    $uri = rtrim(dirname("/htdocs/RestApiAuthAndBlog/api/blog/intermediatePage.php"), '/\\');
                    $extra = 'intermediatePage.php';

                    header("Location: http://$host$uri/$extra");

                }
            }  echo "Неправильный логин или пароль,попробуйте еще раз.";

        } else {
            http_response_code(404);
            echo json_encode(array("message" =>"Юзер не найден."),JSON_UNESCAPED_UNICODE);
        }
?>