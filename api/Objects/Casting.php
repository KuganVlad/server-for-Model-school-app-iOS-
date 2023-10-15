<?php

class Casting
{
    // Подключение к БД таблице "casting"
    private $conn;
    private $table_name = "casting_table";
    private $table_second_name = "city";

    // Свойства
    public $name_city_casting;
    public $id_casting;
    public $type_casting; 
    public $date_casting;
    public $time_casting;
    public $adress_casting;
    public $x_coordinate_casting;
    public $y_coordinate_casting;
    public $status_casting;
    public $views_casting;


    // Конструктор класса Casting
    public function __construct($db)
    {
        $this->conn = $db;
    }



    // Метод для создания нового пользователя
    public function getAllCastings()
    {
        $query = "SELECT city.name_city, casting_table.id_casting, casting_table.type_casting, casting_table.date_casting, casting_table.time_casting, casting_table.adress_casting, casting_table.x_coordinate_casting, casting_table.y_coordinate_casting, casting_table.status_casting, casting_table.views_casting 
                FROM casting_table 
                JOIN city ON casting_table.fk_city_casting = city.id_city 
                WHERE casting_table.status_casting = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $castings = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $casting = new Casting($this->conn);
            $casting->name_city_casting = $row['name_city'];
            $casting->id_casting = $row['id_casting'];
            $casting->type_casting = $row['type_casting'];
            $casting->date_casting = $row['date_casting'];
            $casting->time_casting = $row['time_casting'];
            $casting->adress_casting = $row['adress_casting'];
            $casting->x_coordinate_casting = $row['x_coordinate_casting'];
            $casting->y_coordinate_casting = $row['y_coordinate_casting'];
            $casting->status_casting = $row['status_casting'];
            $casting->views_casting = $row['views_casting'];

            array_push($castings, $casting);
        }

        return $castings;
    }

    public function add_casting_record() {
        // Если не введен пароль - не обновлять пароль
        $query = "UPDATE casting_table 
        SET views_casting = views_casting + 1
        WHERE id_casting = :id";

        $stmt = $this->conn->prepare($query);

        // Инъекция (очистка)
        $this->id_casting=htmlspecialchars(strip_tags($this->id_casting));
        
        // Привязываем значения с HTML формы
        $stmt->bindParam(":id", $this->id_casting);

        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if($stmt->execute()) {

            return true;
        }

        return false;
    }
          
}