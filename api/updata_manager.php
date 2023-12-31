<?php

// Заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Требуется для кодирования веб-токена JSON
include_once "Config/Core.php";
include_once "libs/php-jwt/BeforeValidException.php";
include_once "libs/php-jwt/ExpiredException.php";
include_once "libs/php-jwt/SignatureInvalidException.php";
include_once "libs/php-jwt/JWT.php";
include_once "libs/php-jwt/Key.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Файлы, необходимые для подключения к базе данных
include_once "./Config/Database.php";
include_once "./Objects/Manager.php";

// Получаем соединение с БД
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Manager"
$manager = new Manager($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Получаем jwt
$jwt = isset($data->jwt) ? $data->jwt : "";

// Если JWT не пуст
if ($jwt) {

    // Если декодирование выполнено успешно, показать данные пользователя
    try {

        // Декодирование jwt
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

        // Нам нужно установить отправленные данные (через форму HTML) в свойствах объекта пользователя

        if(!empty($data->email)){
            $manager->email = $data->email;
        }else{
            $manager->email = $decoded->data->email;
        }
        $manager->id = $decoded->data->id;
        $manager->password = $data->password;
        $manager->firstname = $data->firstname;
        $manager->lastname = $data->lastname;
        $manager->surname = $data->surname;
        $manager->phonenumber = $data->phonenumber;
        $manager->city = $data->city;
        $manager->acadeic_discipline = $data->discipline;
        $manager->manager_image = $data->image;

        // Создание пользователя
        if ($manager->update()) {
            // Нам нужно заново сгенерировать JWT, потому что данные пользователя могут отличаться
            $token = array(
                "iss" => $iss,
                "aud" => $aud,
                "iat" => $iat,
                "nbf" => $nbf,
                "data" => array(
                    "id" => $manager->id,
                    "email" => $manager->email
                )
            );

            $jwt = JWT::encode($token, $key, 'HS256');

// Код ответа
            http_response_code(200);

// Ответ в формате JSON
            echo json_encode(
                array(
                    "message" => "Пользователь был обновлён",
                    "jwt" => $jwt
                )
            );
        } // Сообщение, если не удается обновить пользователя
        else {

            // Код ответа
            http_response_code(401);

            // Показать сообщение об ошибке
            echo json_encode(array("message" => "Невозможно обновить пользователя"));
        }
    } // Если декодирование не удалось, это означает, что JWT является недействительным
    catch (Exception $e) {

        // Код ответа
        http_response_code(401);

        // Сообщение об ошибке
        echo json_encode(array(
            "message" => "Доступ закрыт",
            "error" => $e->getMessage()
        ));
    }
} // Показать сообщение об ошибке, если jwt пуст
else {

    // Код ответа
    http_response_code(401);

    // Сообщить пользователю что доступ запрещен
    echo json_encode(array("message" => "Доступ закрыт"));
}