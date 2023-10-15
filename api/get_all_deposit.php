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
include_once "./Objects/Pay.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "Casting"
$deposit_pay = new Pay($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));


$deposit_pay->id = $data->id;

$deposits = $deposit_pay->getAllDepositData();

// Устанавливаем код ответа
http_response_code(200);

if (!empty($deposits)) {
    // Покажем сообщение о том, что данные получены
    $response = array();
    foreach ($deposits as $deposit_pay) {
      $response[$deposit_pay->id_deposit] = array(
        "id" => $deposit_pay->id_deposit,
        "sum" => $deposit_pay->sum_desposited_amount,
        "date" => $deposit_pay->date_desposited_amount, 
        "user" => $deposit_pay->fk_user_id_desposited,
      );
    }
    echo json_encode($response);
  } else {
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о платежах"));
  }
  