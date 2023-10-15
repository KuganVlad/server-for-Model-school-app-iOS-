<?php

class VisitLesson
{
    // Подключение к БД таблице "visit_lesson_table"
    private $conn;
    private $table_name = "visit_lesson_table";

    public $user_id;
    // Свойства
    public $id_visit;
    public $status_visit;
    public $id_user_visit;
    public $lesson_date;
    public $lesson_time;
    public $name_discipline; 
    public $group_name;

    // Конструктор класса Casting
    public function __construct($db)
    {
        $this->conn = $db;
    }



    // Метод для создания нового пользователя
    public function getAllVisitInfo()
    {
        $query = "SELECT visit_lesson_table.id_visit, visit_lesson_table.status_visit, visit_lesson_table.id_user_visit, 
        schedule_table.lesson_date, schedule_table.lesson_time,
        academic_discipline_table.name_discipline, group_table.group_name
        FROM visit_lesson_table
        JOIN schedule_table ON visit_lesson_table.id_lesson_schedule = schedule_table.id_schedule
        JOIN academic_discipline_table ON schedule_table.fk_id_academic_dis = academic_discipline_table.id_academic_discipline
        JOIN group_table ON schedule_table.fk_id_group = group_table.group_id
        WHERE id_user_visit = :id
        AND lesson_status = 0";

        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->user_id));
        $stmt->bindParam(":id", $this->user_id);
        $stmt->execute();

        $visit_lessons = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $visit = new VisitLesson($this->conn);
            $visit->id_visit = $row['id_visit'];
            $visit->status_visit = $row['status_visit'];
            $visit->id_user_visit = $row['id_user_visit'];
            $visit->lesson_date = $row['lesson_date'];
            $visit->lesson_time = $row['lesson_time'];
            $visit->name_discipline = $row['name_discipline'];
            $visit->group_name = $row['group_name'];
            array_push($visit_lessons, $visit);
        }

        return $visit_lessons;
    }

          
}