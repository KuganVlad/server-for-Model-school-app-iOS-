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
include_once "./Objects/Project.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Project"
$project = new Project($db);
// Получаем данные
$data = json_decode(file_get_contents("php://input"));

$projects = $project->getAllProject();

// Устанавливаем код ответа
http_response_code(200);

if (!empty($projects)) {
    // Покажем сообщение о том, что данные получены
    $response = array();
    foreach ($projects as $project) {
      $response[$project->project_id] = array(
        "id" => $project->project_id,
        "name" => $project->project_name,
        "date" => $project->project_date, 
        "location" => $project->project_location,
        "status" => $project->project_status,
        "text" => $project->project_text,
        "id_dir" => $project->fk_contact_director,
        "id_cust" => $project->fk_contact_custommer,
        "text_user" => $project->user_and_management,
        "contact" => $project->contact
      );
    }
    echo json_encode($response);
  } else {
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о кастинге"));
  }
  