<?php

class Project
{
    // Подключение к БД таблице "project_table"
    private $conn;
    private $table_name = "project_table";

    // Свойства
    public $project_id; 
    public $project_name;
    public $project_date;
    public $project_location; 
    public $project_status; 
    public $project_text; 
    public $fk_contact_director;
    public $fk_contact_custommer;
    public $user_and_management; 
    public $contact;
    


    // Конструктор класса Casting
    public function __construct($db)
    {
        $this->conn = $db;
    }



    // Метод для создания нового пользователя
    public function getAllProject()
    {
        $query = "SELECT
        project_table.*,
        CONCAT_WS(' ', user.lastname_user, user.firstname_user,  user.surname_user, management.lastname_management, management.firstname_management,  management.surname_management) AS user_and_management,
        CONCAT_WS(' ', user.phonenumber_user, phonenumber_management) AS contact
        FROM
        project_table
        LEFT JOIN user ON project_table.fk_contact_custommer = user.id_user
        LEFT JOIN management ON project_table.fk_contact_director = management.id_management
        WHERE project_status = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $projects = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $project = new Project($this->conn);
            $project->project_id = $row['project_id'];
            $project->project_name = $row['project_name'];
            $project->project_date = $row['project_date'];
            $project->project_location = $row['project_location'];
            $project->project_status = $row['project_status'];
            $project->project_text = $row['project_text'];
            $project->fk_contact_director = $row['fk_contact_director'];
            $project->fk_contact_custommer = $row['fk_contact_custommer'];
            $project->user_and_management = $row['user_and_management'];
            $project->contact = $row['contact'];

            array_push($projects, $project);
        }

        return $projects;
    }

    public function projectUpdate()
    {

        $project_name_set=!empty($this->project_name) ? "project_name = :project_name" : "";
        $date_set=!empty($this->project_date) ? ", project_date = :project_date" : "";
        $location_set=!empty($this->project_location) ? ", project_location = :project_location" : "";
        $status_set=!empty($this->project_status) ? ", project_status = :project_status" : "";
        $text_set=!empty($this->project_text) ? ", project_text = :project_text" : "";


        $query = "UPDATE project_table
        SET 
        {$project_name_set}
        {$date_set}
        {$location_set}
        {$status_set}
        {$text_set}
        WHERE project_id = :id";

        $stmt = $this->conn->prepare($query);

        if(!empty($this->project_name)){
            $this->project_name=htmlspecialchars(strip_tags($this->project_name));
            $stmt->bindParam(":project_name", $this->project_name);
        }
        if(!empty($this->project_date)){
            $this->project_date=htmlspecialchars(strip_tags($this->project_date));
            $stmt->bindParam(":project_date", $this->project_date);
        }
        if(!empty($this->project_location)){
            $this->project_location=htmlspecialchars(strip_tags($this->project_location));
            $stmt->bindParam(":project_location", $this->project_location);
        }
        if(!empty($this->project_status)){
            $this->project_status=htmlspecialchars(strip_tags($this->project_status));
            $stmt->bindParam(":project_status", $this->project_status);
        }
        if(!empty($this->project_text)){
            $this->project_text=htmlspecialchars(strip_tags($this->project_text));
            $stmt->bindParam(":project_text", $this->project_text);
        }

        $stmt->bindParam(":id", $this->project_id);

        $stmt->execute();

        if($stmt->execute()) {
            return true;
        }

        return false;

    }
    
    function create()
    {
        $project_name_set=!empty($this->project_name) ? "project_name = :project_name" : "";
        $date_set=!empty($this->project_date) ? ", project_date = :project_date" : "";
        $location_set=!empty($this->project_location) ? ", project_location = :project_location" : "";
        $status_set=!empty($this->project_status) ? ", project_status = :project_status" : "";
        $text_set=!empty($this->project_text) ? ", project_text = :project_text" : "";
        $fk_contact_director_set=!empty($this->fk_contact_director) ? ", fk_contact_director = :fk_contact_director" : "";
        $fk_contact_custommer=!empty($this->fk_contact_custommer) ? ", fk_contact_custommer = :fk_contact_custommer" : "";


        $query = "INSERT INTO project_table
        SET
        {$project_name_set}
        {$date_set}
        {$location_set}
        {$status_set}
        {$text_set}
        {$fk_contact_director_set}
        {$fk_contact_custommer}";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        if(!empty($this->project_name)){
            $this->project_name=htmlspecialchars(strip_tags($this->project_name));
            $stmt->bindParam(":project_name", $this->project_name);
        }
        if(!empty($this->project_date)){
            $this->project_date=htmlspecialchars(strip_tags($this->project_date));
            $stmt->bindParam(":project_date", $this->project_date);
        }
        if(!empty($this->project_location)){
            $this->project_location=htmlspecialchars(strip_tags($this->project_location));
            $stmt->bindParam(":project_location", $this->project_location);
        }
        if(!empty($this->project_status)){
            $this->project_status=htmlspecialchars(strip_tags($this->project_status));
            $stmt->bindParam(":project_status", $this->project_status);
        }
        if(!empty($this->project_text)){
            $this->project_text=htmlspecialchars(strip_tags($this->project_text));
            $stmt->bindParam(":project_text", $this->project_text);
        }
        if(!empty($this->fk_contact_director)){
            $this->fk_contact_director=htmlspecialchars(strip_tags($this->fk_contact_director));
            $stmt->bindParam(":fk_contact_director", $this->fk_contact_director);
        }
        if(!empty($this->fk_contact_custommer)){
            $this->fk_contact_custommer=htmlspecialchars(strip_tags($this->fk_contact_custommer));
            $stmt->bindParam(":fk_contact_custommer", $this->fk_contact_custommer);
        }

        // Выполняем запрос
        // Если выполнение успешно, то информация о проект будет сохранена в базе данных
        try {
            if ($stmt->execute()) {
                return true;
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
        return false;
    }
    function delete(){
        $query = "DELETE FROM project_table
        WHERE project_id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->project_id);
        try {
            if ($stmt->execute()) {
                return true;
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }
        return false;

    }
}