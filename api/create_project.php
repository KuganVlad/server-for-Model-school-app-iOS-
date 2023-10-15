<?php

// Заголовки
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Подключение к БД
// Файлы, необходимые для подключения к базе данных
include_once "./Config/Database.php";
include_once "./Objects/Project.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$project = new Project($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));


// Устанавливаем значения
$project->project_name = $data->name;
$project->project_date = $data->date;
$project->project_location = $data->location;
$project->project_status = $data->status;
$project->project_text = $data->text;
$project->fk_contact_director = $data->fk_contact_director;
$project->fk_contact_custommer = $data->fk_contact_custommer;


// Создание пользователя
if (
    !empty($project->project_name) &&
    !empty($project->project_date) &&
    !empty($project->project_location) &&
    !empty($project->project_status) &&
    !empty($project->project_text) &&
    (!empty($project->fk_contact_director) OR
    !empty($project->fk_contact_custommer)) &&
    $project->create()
) {
    // Устанавливаем код ответа
    http_response_code(200);
    // Покажем сообщение о том, что пользователь был создаy
    echo json_encode(array("message" => "Проект создан"));
}

// Сообщение, если не удаётся создать проект
else {
    // Устанавливаем код ответа
    http_response_code(400);
    // Покажем сообщение о том, что создать проект не удалось
    echo json_encode(array("message" => "Невозможно создать проект"));
}
