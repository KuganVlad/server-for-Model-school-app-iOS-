<?php

// Заголовки
header("Access-Control-Allow-Origin: http://authentication-jwt/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Файлы необходимые для соединения с БД
include_once "./Config/Database.php";
include_once "./Objects/Schedule.php";

// Получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();


$schedule = new Schedule($db);


// Получаем данные
$data = json_decode(file_get_contents("php://input"));

// Устанавливаем значения
$schedule->user_id = $data->id;

$user_schedule = $schedule->getScheduleToGroup();

http_response_code(200);

//Если данные о кастинге присутствуют
if (!empty($user_schedule)) {
    // Код ответа
    $response = array();
    foreach ($user_schedule as $schedule) {
       $response[$schedule->id_schedule] = array(
        "id_schedule" => $schedule->id_schedule,
        "date" => $schedule->lesson_date,
        "time_lesson" => $schedule->lesson_time,
        "academic_dis" => $schedule->fk_id_academic_dis,
        "group_id" => $schedule->fk_id_group,
        "filial_id" => $schedule->fk_id_filial,
        "discipline" => $schedule->name_discipline,
        "group_name" => $schedule->group_name,
        "lastname_teacher" => $schedule->lastname_management,
        "firstname_management" => $schedule->firstname_management,
        "surname_management" => $schedule->surname_management
        );
    }
      echo json_encode($response);
}else {
  // Код ответа
  http_response_code(401);
  // Скажем пользователю что войти не удалось
  echo json_encode(array("message" => "Невозможно получить информацию о рассписании"));
}
    


?>