<?php

// Заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Файлы, необходимые для подключения к базе данных
include_once "./Config/Database.php";
include_once "./Objects/User.php";

// Получаем соединение с БД
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new User($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));


$user->id = $data->id;

// Создание пользователя
if ($user->userListDelete()) {
  
    http_response_code(200);

// Ответ в формате JSON
    echo json_encode(
        array(
            "message" => "Пользователь был удалён"
        )
    );
} 
else {

    // Код ответа
    http_response_code(401);

    // Показать сообщение об ошибке
    echo json_encode(array("message" => "Невозможно удалить пользователя"));
}

