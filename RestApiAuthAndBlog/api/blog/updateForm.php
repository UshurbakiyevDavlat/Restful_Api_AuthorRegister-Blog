<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Read ID of blog</title>
</head>
<body>
<form action="update.php" method="post">
    <label>id:<input type="number" name="id"></label>

    <p><label>Ваш загаловок: <input type="text" name="header" /></label></p>
    <p><label>Ваш текст: <input type="text" name="statement" /></label></p>

    <br>
    <input type="submit" name="submit" value="Изменить">
</form>
</body>
</html>
