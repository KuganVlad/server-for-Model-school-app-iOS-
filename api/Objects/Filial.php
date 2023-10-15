<?php

class Filial
{
    // Подключение к БД таблице "filial_table"
    private $conn;
    private $table_name = "filial_table";

    // Свойства 
    public $filial_id; 
    public $filial_name; 
    public $filial_adress; 
    public $fk_id_city; 
    public $fk_director_name;
    public $name_city;
    public $director;
    


    // Конструктор класса Casting
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllFilial()
    {
        $query = "SELECT
        filial_table.filial_id, filial_table.filial_name, filial_table.filial_adress, city.name_city, 
        CONCAT_WS(' ', management.lastname_management, management.firstname_management, management.surname_management, management.phonenumber_management) AS director
        FROM filial_table
        LEFT JOIN city ON filial_table.fk_id_city = city.id_city
        LEFT JOIN management ON filial_table.fk_director_name = management.id_management";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
       
        $filials = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $filial = new Filial($this->conn);
            $filial->filial_id = $row['filial_id'];
            $filial->filial_name = $row['filial_name'];
            $filial->filial_adress = $row['filial_adress'];
            $filial->name_city = $row['name_city'];
            $filial->director = $row['director'];

            array_push($filials, $filial);
        }

        return $filials;
    }
}