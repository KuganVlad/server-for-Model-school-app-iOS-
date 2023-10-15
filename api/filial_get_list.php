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
include_once "./Objects/Filial.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Project"
$filial = new Filial($db);
// Получаем данные
$data = json_decode(file_get_contents("php://input"));

$filials = $filial->getAllFilial();

// Устанавливаем код ответа
http_response_code(200);

if (!empty($filials)) {
    // Покажем сообщение о том, что данные получены
    $response = array();
    foreach ($filials as $filial) {
      $response[$filial->filial_id] = array(
        "id" => $filial->filial_id,
        "name" => $filial->filial_name,
        "adress" => $filial->filial_adress, 
        "city" => $filial->name_city,
        "director" => $filial->director,
      );
    }
    echo json_encode($response);
  } else {
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о кастинге"));
  }
  