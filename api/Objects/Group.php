<?php

class Group
{
    // Подключение к БД таблице "group_table"
    private $conn;
    private $table_name = "group_table";
    
    // Свойства 
    public $group_id;
    public $group_name;
    public $filial_id;
    public $fk_group_type;
    public $type_filial;

    // Конструктор класса Casting
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllGroup()
    {

        $query = "SELECT
        group_table.group_id, group_table.group_name, type_filial.type_filial
        FROM group_table
        INNER JOIN type_filial ON group_table.fk_group_type = type_filial.id_type_filial
        WHERE group_table.filial_id = :filial_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":filial_id", $this->filial_id);
        $stmt->execute();


        $groups = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $group = new Group($this->conn);
            $group->group_id = $row['group_id'];
            $group->group_name = $row['group_name'];
            $group->type_filial = $row['type_filial'];
            array_push($groups, $group);
        }
        return $groups;
    }
}