<?php

// Заголовки
header("Access-Control-Allow-Origin: http://authentication-jwt/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Файлы необходимые для соединения с БД
include_once "./Config/Database.php";
include_once "./Objects/User.php";
include_once "./Objects/Casting.php";

// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new User($db);


// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Устанавливаем значения
$user->id = $data->id;

$user_casting = $user->getUserCastingData();


//Если данные о кастинге присутствуют
if (!empty($user_casting)) {
    // Код ответа
    http_response_code(200);
    $response = array();
    foreach ($user_casting as $casting) {
      echo json_encode(
        array(
        "id" => $casting->id_casting,
        "city" => $casting->name_city_casting,
        "type" => $casting->type_casting, 
        "date" => $casting->date_casting,
        "time" => $casting->time_casting,
        "address" => $casting->adress_casting,
        "x" => $casting->x_coordinate_casting,
        "y" => $casting->y_coordinate_casting
        )
      );
    }
    
}
// Если электронная почта не существует или код не совпадает,
// Сообщим пользователю, что он не может войти в систему
else {

    // Код ответа
    http_response_code(401);
    // Скажем пользователю что войти не удалось
    echo json_encode(array("message" => "Пользователь не записан на кастинги"));
}
?>