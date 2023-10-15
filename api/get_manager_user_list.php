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
include_once "./Objects/User.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new User($db);
// Получаем данные
$data = json_decode(file_get_contents("php://input"));

$users = $user->userListGetData();

// Устанавливаем код ответа
http_response_code(200);

if (!empty($users)) {
    // Покажем сообщение о том, что данные получены
    $response = array();
    foreach ($users as $user) {
      $response[$user->id] = array(
        "id" => $user->id,
        "email" => $user->email,
        "password" => $user->password, 
        "type" => $user->type_user,
        "create" => $user->create_date,
        "modif" => $user->mod_date,
        "fname" => $user->first_name,
        "lname" => $user->last_name,
        "sname" => $user->sur_name,
        "age" => $user->age,
        "phone" => $user->phone_number,
        "city" => $user->city,
        "organizaion" => $user->organization,
        "position" => $user->position,
        "status" => $user->status_account,
        "code" => $user->code,
        "casting" => $user->casting,
        "group" => $user->group,
        "image" => $user->user_image
      );
    }
    echo json_encode($response);
  } else {
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о пользователях"));
  }
  