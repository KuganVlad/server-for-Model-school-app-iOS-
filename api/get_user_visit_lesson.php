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
include_once "./Objects/VisitLesson.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Project"
$visit = new VisitLesson($db);
// Получаем данные
$data = json_decode(file_get_contents("php://input"));

$visit->user_id = $data->id;

$visits = $visit->getAllVisitInfo();

// Устанавливаем код ответа
http_response_code(200);

if (!empty($visits)) {
    // Покажем сообщение о том, что данные получены
    $response = array();
    foreach ($visits as $visit) {
      $response[$visit->id_visit] = array(
        "id" => $visit->id_visit,
        "status" => $visit->status_visit,
        "user_id" => $visit->id_user_visit, 
        "lesson_data" => $visit->lesson_date,
        "lesson_time" => $visit->lesson_time,
        "discip_name" => $visit->name_discipline,
        "group_name" => $visit->group_name
      );
    }
    echo json_encode($response);
  } else {
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о посещаемости"));
  }
  