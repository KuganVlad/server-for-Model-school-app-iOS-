<?php

// Заголовки
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Подключение к БД
// Файлы, необходимые для подключения к базе данных
include_once "./Config/Database.php";
include_once "./Objects/Casting.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Casting"
$casting = new Casting($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));
$casting->id_casting = $data->id;


if ($casting->add_casting_record()) {
    // Устанавливаем код ответа
    http_response_code(200);
    // Покажем сообщение о том, что данные получены
    echo json_encode(array("message" => "200"));
  } else {
    http_response_code(400);
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array());
  }
  