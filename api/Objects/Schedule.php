<?php

class Schedule
{
    // Подключение к БД таблице "schedule_table"
    private $conn;
    private $table_name = "schedule_table";

    // Свойства
    public $id_schedule;
    public $lesson_date;
    public $lesson_time;
    public $lesson_status;
    public $fk_id_academic_dis;
    public $fk_id_group;
    public $fk_id_teacher;
    public $fk_id_filial;

    public $teacher_id;
    public $user_id;
    public $name_discipline; 
    public $group_name; 
    public $lastname_management; 
    public $firstname_management;
    public $surname_management;


    // Конструктор класса Schedule
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getScheduleToGroup(){
        $query = "SELECT fk_group_id 
        FROM user
        WHERE fk_type_user = 2
        AND id_user = :id
        LIMIT 0,1";
        $stmt_tmp = $this->conn->prepare($query);
        $stmt_tmp->bindParam(":id", $this->user_id);
        $stmt_tmp->execute();
        $row_tmp = $stmt_tmp->fetch(PDO::FETCH_ASSOC);

        $this->fk_id_group = $row_tmp['fk_group_id'];

        $query = "SELECT 
        schedule_table.id_schedule,
        schedule_table.lesson_date,
        schedule_table.lesson_time,
        schedule_table.lesson_status,
        academic_discipline_table.name_discipline,
        group_table.group_name,
        management.lastname_management,
        management.firstname_management,
        management.surname_management,
        schedule_table.fk_id_filial
        FROM 
            schedule_table
        INNER JOIN 
            academic_discipline_table 
            ON schedule_table.fk_id_academic_dis = academic_discipline_table.id_academic_discipline
        INNER JOIN 
            group_table 
            ON schedule_table.fk_id_group = group_table.group_id
        INNER JOIN 
            management 
            ON schedule_table.fk_id_teacher = management.id_management
        WHERE 
            schedule_table.fk_id_group = :group_id
            AND schedule_table.lesson_status = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":group_id", $this->fk_id_group);
        $stmt->execute();

        $schedules = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $value_schedule = new Schedule($this->conn);

            $value_schedule->id_schedule = $row["id_schedule"];
            $value_schedule->lesson_date = $row["lesson_date"];
            $value_schedule->lesson_time = $row["lesson_time"];
            $value_schedule->fk_id_academic_dis = $row["name_discipline"];
            $value_schedule->fk_id_group = $this->fk_id_group;
            $value_schedule->fk_id_filial = $row["fk_id_filial"];
            $value_schedule->name_discipline = $row["name_discipline"];
            $value_schedule->group_name = $row["group_name"];
            $value_schedule->lastname_management = $row["lastname_management"];
            $value_schedule->firstname_management = $row["firstname_management"];
            $value_schedule->surname_management = $row["surname_management"];

            array_push($schedules, $value_schedule);
        }

        return $schedules;
    }

    public function getScheduleToTeacher(){

        $query = "SELECT 
        schedule_table.id_schedule,
        schedule_table.lesson_date,
        schedule_table.lesson_time,
        schedule_table.lesson_status,
        academic_discipline_table.name_discipline,
        group_table.group_name,
        management.lastname_management,
        management.firstname_management,
        management.surname_management,
        schedule_table.fk_id_filial
        FROM 
            schedule_table
        INNER JOIN 
            academic_discipline_table 
            ON schedule_table.fk_id_academic_dis = academic_discipline_table.id_academic_discipline
        INNER JOIN 
            group_table 
            ON schedule_table.fk_id_group = group_table.group_id
        INNER JOIN 
            management 
            ON schedule_table.fk_id_teacher = management.id_management
        WHERE 
            schedule_table.fk_id_teacher = :fk_id_teacher
            AND schedule_table.lesson_status = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":fk_id_teacher", $this->teacher_id);
        $stmt->execute();

        $schedules = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $value_schedule = new Schedule($this->conn);

            $value_schedule->id_schedule = $row["id_schedule"];
            $value_schedule->lesson_date = $row["lesson_date"];
            $value_schedule->lesson_time = $row["lesson_time"];
            $value_schedule->fk_id_academic_dis = $row["name_discipline"];
            $value_schedule->fk_id_group = $this->fk_id_group;
            $value_schedule->fk_id_filial = $row["fk_id_filial"];
            $value_schedule->name_discipline = $row["name_discipline"];
            $value_schedule->group_name = $row["group_name"];
            $value_schedule->lastname_management = $row["lastname_management"];
            $value_schedule->firstname_management = $row["firstname_management"];
            $value_schedule->surname_management = $row["surname_management"];

            array_push($schedules, $value_schedule);
        }

        return $schedules;
    }
}
