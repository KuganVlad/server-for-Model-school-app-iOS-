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
include_once "./Objects/EmailSender.php";


// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Создание объекта "User"
$user = new User($db);

// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Функция генерации случайного кода из 6 символов

function generateCode() {
    $code = '';
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for ($i = 0; $i < 6; $i++) {
        $code .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $code;
}

// Устанавливаем значения
$user->email = $data->email;
$user->password = $data->password;
$user->code = generateCode();

// Поверка на существование e-mail в БД
//$email_exists = $user->emailExists();

// Создание пользователя
if (
    !empty($user->email) &&
    // $email_exists == 0 &&
    !empty($user->password) &&
    !empty($user->code)&&
    $user->create()
) {
    // Устанавливаем код ответа
    http_response_code(200);
    $to=$data->email;
    $subject="Подтверждение электронной почты";
    $body = 'Здравствуйте! Пожалуйста, подтвердите адрес вашей электронной почты введя нижеуказанный код в приложении: <br><br><div style="text-align:center; font-size:20px; font-weight:bold;">'.$user->code.'</div>';
    require '../../vendor/autoload.php';
    $emailSender = new EmailSender();
    $emailSender->send($to, $subject, $body);
    // Покажем сообщение о том, что пользователь был создаy
    echo json_encode(array("message" => "Пользователь был создан", "codeAuth" => $user->code));
}

// Сообщение, если не удаётся создать пользователя
else {
    // Устанавливаем код ответа
    http_response_code(400);
    // Покажем сообщение о том, что создать пользователя не удалось
    echo json_encode(array("message" => "Невозможно создать пользователя"));
}
