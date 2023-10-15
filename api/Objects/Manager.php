<?php

class Manager
{
    // Подключение к БД таблице "manager"
    private $conn;
    private $table_name = "management";

    // Свойства
    public $id;
    public $email;
    public $password;
    public $type_user;
    public $firstname;
    public $lastname;
    public $surname;
    public $phonenumber;
    public $city;
    public $acadeic_discipline;
    public $manager_image;
    


    // Конструктор класса Manager
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // Проверка, существует ли электронная почта в нашей базе данных
    function emailManagerExists() {

        // Запрос, чтобы проверить, существует ли электронная почта
        $query = "SELECT id_management, password_management, fk_type_user
            FROM " . $this->table_name . "
            WHERE email_management = ?
            AND status_check_manager = 1
            LIMIT 0,1";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->email=htmlspecialchars(strip_tags($this->email));

        // Привязываем значение e-mail
        $stmt->bindParam(1, $this->email);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если электронная почта существует,
        // Присвоим значения свойствам объекта для легкого доступа и использования для php сессий
        if ($num > 0) {

            // Получаем значения
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Присвоим значения свойствам объекта
            $this->id = $row["id_management"];
            $this->password = $row["password_management"];
            $this->type_user = $row["fk_type_user"];

            // Вернём "true", потому что в базе данных существует электронная почта
            return true;
        }

        // Вернём "false", если адрес электронной почты не существует в базе данных
        return false;
    }

    function managerGetData() {

        $query = "SELECT *
        FROM " . $this->table_name . "
        WHERE id_management = :id
        LIMIT 0,1";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        // Инъекция
        $this->id=htmlspecialchars(strip_tags($this->id));

        // Привязываем значение code
        $stmt->bindParam(":id", $this->id);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Если пользователь с указанным кодом существует,
        // Присвоим значения свойствам объекта для легкого доступа и использования для php сессий
        if ($num > 0) {
            // Получаем значения
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Присвоим значения свойствам объекта
            $this->id = $row["id_management"];
            $this->email = $row["email_management"];
            $this->password = $row["password_management"];
            $this->type_user = $row["fk_type_user"];
            $this->firstname = $row["firstname_management"];
            $this->lastname = $row["lastname_management"];
            $this->surname = $row["surname_management"];
            $this->phonenumber = $row["phonenumber_management"];
            $this->city = $row["city_management"];
            $this->acadeic_discipline = $row["fk_acadeic_discipline"];
            $this->manager_image = $row["image"];
            

            // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
            if($stmt->execute()) {
                return true;
            }else{
                return false;
            }
        }
            // Вернём "false", если адрес code не существует в базе данных
            return false;
    }

    public function update() {
        // Если в HTML-форме был введен пароль (необходимо обновить пароль)
        $password_set=!empty($this->password) ? ", password_management = :password" : "";
        $firstname_set=!empty($this->firstname) ? ", firstname_management = :first_name" : "";
        $last_name_set=!empty($this->lastname) ? ", lastname_management = :last_name" : "";
        $sur_name_set=!empty($this->surname) ? ", surname_management = :sur_name" : "";
        $phone_number_set=!empty($this->phonenumber) ? ", phonenumber_management = :phone_number" : "";
        $city_set=!empty($this->city) ? ", city_management = :city_user" : "";
        $discipline_set=!empty($this->acadeic_discipline) ? ", fk_acadeic_discipline = :discipline" : "";
        $manager_image_set=!empty($this->manager_image) ? ", image = :manager_image" : "";

        // Если не введен пароль - не обновлять пароль
        $query = "UPDATE " . $this->table_name . "
            SET
            email_management = :email
                {$password_set}
                {$firstname_set}
                {$last_name_set}
                {$sur_name_set}
                {$phone_number_set}
                {$city_set}
                {$discipline_set}
                {$manager_image_set}
            WHERE id_management = :id";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция (очистка)
        $this->email=htmlspecialchars(strip_tags($this->email));
        // Привязываем значения с HTML формы
        $stmt->bindParam(":email", $this->email);


        if(!empty($this->firstname)){
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $stmt->bindParam(":first_name", $this->firstname);
        }
        if(!empty($this->lastname)){
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $stmt->bindParam(":last_name", $this->lastname);
        }
        if(!empty($this->surname)){
        $this->surname=htmlspecialchars(strip_tags($this->surname));
        $stmt->bindParam(":sur_name", $this->surname);
        }
        if(!empty($this->phonenumber)){
        $this->phonenumber=htmlspecialchars(strip_tags($this->phonenumber));
        $stmt->bindParam(":phone_number", $this->phonenumber);
        }
        if(!empty($this->city)){
        $this->city=htmlspecialchars(strip_tags($this->city));
        $stmt->bindParam(":city_user", $this->city);
        }
        if(!empty($this->acadeic_discipline)){
        $this->acadeic_discipline=htmlspecialchars(strip_tags($this->acadeic_discipline));
        $stmt->bindParam(":discipline", $this->acadeic_discipline);
        }
        if(!empty($this->manager_image)){
        $this->manager_image=htmlspecialchars(strip_tags($this->manager_image));
        $stmt->bindParam(":manager_image", $this->manager_image);
        }

        // Метод password_hash () для защиты пароля пользователя в базе данных
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);
        }

        // Уникальный идентификатор записи для редактирования
        $stmt->bindParam(":id", $this->id);

        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    function getManagerList() {

        $query = "SELECT *
        FROM " . $this->table_name . "
        WHERE (fk_type_user = 5 OR fk_type_user = 6)
        AND city_management = :city OR city_management = 26;";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        // Инъекция
        $this->city=htmlspecialchars(strip_tags($this->city));

        // Привязываем значение code
        $stmt->bindParam(":city", $this->city);
        // Выполняем запрос
        $stmt->execute();

        $array_managers = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $value_manager = new Manager($this->conn);
            // Присвоим значения свойствам объекта
            $value_manager->id = $row["id_management"];
            $value_manager->type_user = $row["fk_type_user"];
            $value_manager->firstname = $row["firstname_management"];
            $value_manager->lastname = $row["lastname_management"];
            $value_manager->phonenumber = $row["phonenumber_management"];
            $value_manager->manager_image = $row["image"];
            // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных

            array_push($array_managers, $value_manager);
        }

        return $array_managers;
    }

    function getTeacherList() {

        $query = "SELECT *
        FROM " . $this->table_name . "
        WHERE fk_type_user = 4
        AND city_management = :city;";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        // Инъекция
        $this->city=htmlspecialchars(strip_tags($this->city));

        // Привязываем значение code
        $stmt->bindParam(":city", $this->city);
        // Выполняем запрос
        $stmt->execute();

        $array_teacher = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $value_techer = new Manager($this->conn);
            // Присвоим значения свойствам объекта
            $value_techer->id = $row["id_management"];
            $value_techer->acadeic_discipline = $row["fk_acadeic_discipline"];
            $value_techer->firstname = $row["firstname_management"];
            $value_techer->lastname = $row["lastname_management"];
            $value_techer->phonenumber = $row["phonenumber_management"];
            $value_techer->manager_image = $row["image"];
            // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных

            array_push($array_teacher, $value_techer);
        }

        return $array_teacher;
    }

    function getTeacherManagerList() {

        $query = "SELECT *
        FROM " . $this->table_name . "
        WHERE fk_type_user = 4;";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        // Инъекция
        $this->city=htmlspecialchars(strip_tags($this->city));

        // Выполняем запрос
        $stmt->execute();

        $array_teacher = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $value_techer = new Manager($this->conn);
            // Присвоим значения свойствам объекта
            $value_techer->id = $row["id_management"];
            $value_techer->acadeic_discipline = $row["fk_acadeic_discipline"];
            $value_techer->firstname = $row["firstname_management"];
            $value_techer->lastname = $row["lastname_management"];
            $value_techer->phonenumber = $row["phonenumber_management"];
            $value_techer->manager_image = $row["image"];
            // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных

            array_push($array_teacher, $value_techer);
        }

        return $array_teacher;
    }
}