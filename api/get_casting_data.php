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

$castings = $casting->getAllCastings();

// Устанавливаем код ответа
http_response_code(200);

if (!empty($castings)) {
    // Покажем сообщение о том, что данные получены
    $response = array();
    foreach ($castings as $casting) {
      $response[$casting->id_casting] = array(
        "id" => $casting->id_casting,
        "city" => $casting->name_city_casting,
        "type" => $casting->type_casting, 
        "date" => $casting->date_casting,
        "time" => $casting->time_casting,
        "address" => $casting->adress_casting,
        "x" => $casting->x_coordinate_casting,
        "y" => $casting->y_coordinate_casting,
        "status" => $casting->status_casting,
        "views" => $casting->views_casting
      );
    }
    echo json_encode($response);
  } else {
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о кастинге"));
  }
  