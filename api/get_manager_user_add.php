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
include_once "./Objects/User.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new User($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));


// Устанавливаем значения
$user->email = $data->email;
$user->password = $data->password;
$user->type_user = $data->type_user;
$user->first_name = $data->first_name;
$user->last_name = $data->last_name;
$user->sur_name = $data->sur_name;
$user->age = $data->age;
$user->phone_number = $data->phone_number;
$user->city = $data->city;
$user->organization = $data->organization;
$user->position = $data->position;
$user->status_account = $data->status_account;
$user->code = $data->code;
$user->casting = $data->casting;
$user->group = $data->group;
$user->user_image = $data->user_image;
// Создание пользователя

if (
    !empty($user->email) &&
    !empty($user->password) &&
    !empty($user->type_user) &&
    $user->userListCreate()
) {
    // Устанавливаем код ответа
    http_response_code(200);
    // Покажем сообщение о том, что пользователь был создаy
    echo json_encode(array("message" => "Пользователь создан"));
}

// Сообщение, если не удаётся создать проект
else {
    // Устанавливаем код ответа
    http_response_code(400);
    // Покажем сообщение о том, что создать проект не удалось
    echo json_encode(array("message" => "Невозможно создать пользователя"));
}
