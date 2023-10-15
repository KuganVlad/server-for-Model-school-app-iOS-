<?php

class Photography
{
    // Подключение к БД таблице "photography_table"
    private $conn;
    private $table_name = "photography_table";

    public $user_id;
    public $group_id;
    // Свойства
    public $id_photargaphy; 
    public $session_name; 
    public $session_date; 
    public $session_time; 
    public $session_location; 
    public $session_status; 
    public $fk_id_group;

    // Конструктор класса Casting
    public function __construct($db)
    {
        $this->conn = $db;
    }



    // Метод для создания нового пользователя
    public function getAllPhotography()
    {
        $query = "SELECT fk_group_id 
        FROM user
        WHERE fk_type_user = 2
        AND id_user = :id
        LIMIT 0,1";
        $stmt_tmp = $this->conn->prepare($query);
        $stmt_tmp->bindParam(":id", $this->user_id);
        $stmt_tmp->execute();
        $row_tmp = $stmt_tmp->fetch(PDO::FETCH_ASSOC);

        $this->group_id = $row_tmp['fk_group_id'];



        $query = "SELECT p.id_photargaphy, p.session_name, p.session_date, p.session_time, p.session_location, p.session_status, g.group_name
        FROM photography_table p
        JOIN group_table g ON g.group_id = p.fk_id_group
        WHERE group_id = :id";

        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->group_id));
        $stmt->bindParam(":id", $this->group_id);
        $stmt->execute();

        $photographys = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $photo = new Photography($this->conn);
            $photo->id_photargaphy = $row['id_photargaphy'];
            $photo->session_name = $row['session_name'];
            $photo->session_date = $row['session_date'];
            $photo->session_time = $row['session_time'];
            $photo->session_location = $row['session_location'];
            $photo->session_status = $row['session_status'];
            $photo->fk_id_group = $row['group_name'];
            array_push($photographys, $photo);
        }

        return $photographys;
    }

          
}