<?php


// Заголовки
header("Access-Control-Allow-Origin: http://authentication-jwt/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Файлы необходимые для соединения с БД
include_once "./Config/Database.php";
include_once "./Objects/Manager.php";

// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Manager"
$manager = new Manager($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Устанавливаем значения
$manager->email = $data->email;
$email_exists = $manager->emailManagerExists();

// Подключение файлов JWT
include_once "Config/Core.php";
include_once "libs/php-jwt/BeforeValidException.php";
include_once "libs/php-jwt/ExpiredException.php";
include_once "libs/php-jwt/SignatureInvalidException.php";
include_once "libs/php-jwt/JWT.php";
use Firebase\JWT\JWT;

// Существует ли электронная почта и соответствует ли пароль тому, что находится в базе данных
if (($email_exists && !strcmp($data->password, $manager->password)
|| ($email_exists && password_verify($data->password, $manager->password)))) {


    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        "data" => array(
            "id" => $manager->id,
            "email" => $manager->email,
            "type_user" => $manager->type_user
        )
    );

    // Код ответа
    http_response_code(200);

    // Создание jwt
    $jwt = JWT::encode($token, $key, 'HS256');
    echo json_encode(
        array(
            "message" => "Успешный вход в систему",
            "jwt" => $jwt,
            "id" => $manager->id,
            "type" => $manager->type_user

        )
    );
}

// Если электронная почта не существует или пароль не совпадает,
// Сообщим пользователю, что он не может войти в систему
else {

    // Код ответа
    http_response_code(401);

    // Скажем пользователю что войти не удалось
    echo json_encode(array("message" => "Ошибка входа"));
}
?>