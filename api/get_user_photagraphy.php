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
include_once "./Objects/Photography.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Project"
$photo = new Photography($db);
// Получаем данные
$data = json_decode(file_get_contents("php://input"));

$photo->user_id = $data->id;

$photos = $photo->getAllPhotography();

// Устанавливаем код ответа
http_response_code(200);

if (!empty($photos)) {
    // Покажем сообщение о том, что данные получены
    $response = array();
    foreach ($photos as $photo) {
      $response[$photo->id_photargaphy] = array(
        "id" => $photo->id_photargaphy,
        "name" => $photo->session_name,
        "date" => $photo->session_date, 
        "time" => $photo->session_time,
        "location" => $photo->session_location,
        "status" => $photo->session_status,
        "id_group" => $photo->fk_id_group
      );
    }
    echo json_encode($response);
  } else {
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о посещаемости"));
  }
  