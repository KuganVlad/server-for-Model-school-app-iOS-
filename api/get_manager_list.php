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
include_once "./Objects/Manager.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Manager"
$manager = new Manager($db);
// Получаем данные
$data = json_decode(file_get_contents("php://input"));

$manager->city = $data->city;

$array_managers = $manager->getManagerList();

// Устанавливаем код ответа
http_response_code(200);

if (!empty($array_managers)) {

    $response = array();
    foreach($array_managers as $manager){
        $response[$manager->id] = array(
            "message" => "200",
            "type_manager" => "$manager->type_user",
            "first_name" => "$manager->firstname",
            "last_name" => "$manager->lastname",
            "phone_number" => "$manager->phonenumber",
            "image" => "$manager->manager_image"
        );
        
    }

    echo json_encode($response);
}else{
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о руководстве"));
}
  