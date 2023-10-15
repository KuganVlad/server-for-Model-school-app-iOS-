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
$payment_pay = new Pay($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));


$payment_pay->id = $data->id;






if ($payment_pay->getAllPaymentData()) {
    http_response_code(200);
    echo json_encode(
        array(
            "message" => "200",
            "id" => "$payment_pay->id_payment",
            "full_amount" => "$payment_pay->fk_full_amount",
            "deposited" => "$payment_pay->deposited_amount",
            "remaining" => "$payment_pay->remaining_amount",
            "date_first_pay" => "$payment_pay->date_first_paymant",
            "user" => "$payment_pay->fk_user_id_payment",
        )
    );
  } else {
    // Покажем сообщение о том, что получить данные о кастинге не получилось
    echo json_encode(array("message" => "Невозможно получить данные о платежах"));
  }
  