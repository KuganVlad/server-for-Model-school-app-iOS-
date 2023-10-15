<?php

// Заголовки
header("Access-Control-Allow-Origin: http://authentication-jwt/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Файлы необходимые для соединения с БД
include_once "./Config/Database.php";
include_once "./Objects/User.php";

// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new User($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Устанавливаем значения
$user->id = $data->id;


// Существует ли электронная почта и соответствует ли код тому, что находится в базе данных
if ($user->userCastingDeleteRecord()) {

    // Код ответа
    http_response_code(200);
    echo json_encode(
        array(
            "message" => "delete_record",

        )
    );
}

// Если электронная почта не существует или код не совпадает,
// Сообщим пользователю, что он не может войти в систему
else {

    // Код ответа
    http_response_code(401);
    // Скажем пользователю что войти не удалось
    echo json_encode(array("message" => "Ошибка записи на кастинг"));
}
?>