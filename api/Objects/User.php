<?php

class User
{
    // Подключение к БД таблице "users"
    private $conn;
    private $table_name = "user";

    // Свойства
    public $id;
    public $email;
    public $password;
    public $type_user;
    public $first_name;
    public $last_name;
    public $sur_name;
    public $age;
    public $phone_number;
    public $city;
    public $organization;
    public $position;
    public $status_account;
    public $portfolio;
    public $payments;
    public $casting;
    public $group;
    public $code;
    public $user_id_table;
    public $user_image;
    public $create_date;
    public $mod_date;


    // Конструктор класса User
    public function __construct($db)
    {
        $this->conn = $db;
    }


    function userListGroupData() {

        $query = "SELECT
        id_user, email_user, password_user, fk_type_user, created, modified, firstname_user, lastname_user, surname_user, age_user, phonenumber_user, city_user, organization_customer, position_customer, status_check_user, activation_code, fk_id_casting, fk_group_id, user_image
        FROM user
        WHERE fk_type_user = 2
        AND fk_group_id = :group_id";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":group_id", $this->group);
        $stmt->execute();

        $users = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($this->conn);
            $user->id = $row["id_user"];
            $user->email = $row["email_user"];
            $user->password = $row["password_user"];
            $user->type_user = $row["fk_type_user"];
            $user->create_date = $row["created"];
            $user->mod_date = $row["modified"];
            $user->first_name = $row["firstname_user"];
            $user->last_name = $row["lastname_user"];
            $user->sur_name = $row["surname_user"];
            $user->age = $row["age_user"];
            $user->phone_number = $row["phonenumber_user"];
            $user->city = $row["city_user"];
            $user->organization = $row["organization_customer"];
            $user->position = $row["position_customer"];
            $user->status_account = $row["status_check_user"];
            $user->code = $row["activation_code"];
            $user->casting = $row["fk_id_casting"];
            $user->group = $row["fk_group_id"];
            $user->user_image = $row["user_image"];
            
            array_push($users, $user);
        }
        return $users;
    }

    public function userListGroupUpdate()
    {

        $email_set=!empty($this->email) ? "email_user = :email" : "";
        $password_set=!empty($this->password) ? ", password_user = :password" : "";
        $type_user_set=!empty($this->type_user) ? ", fk_type_user = :type_user" : "";
        $first_name_set=!empty($this->first_name) ? ", firstname_user = :first_name" : "";
        $last_name_set=!empty($this->last_name) ? ", lastname_user = :last_name" : "";
        $sur_name_set=!empty($this->sur_name) ? ", surname_user = :sur_name" : "";
        $age_set=!empty($this->age) ? ", age_user = :age" : "";
        $phone_number_set=!empty($this->phone_number) ? ", phonenumber_user = :phone_number" : "";
        $city_set=!empty($this->city) ? ", city_user = :city" : "";
        $organization_set=!empty($this->organization) ? ", organization_customer = :organization" : "";
        $position_set=!empty($this->position) ? ", position_customer = :position" : "";
        $status_account_set=!empty($this->status_account) ? ", status_check_user = :status_account" : "";
        $code_set=!empty($this->code) ? ", activation_code = :code" : "";
        $group_set=!empty($this->group) ? ", fk_group_id = :group" : "";
        $user_image_set=!empty($this->user_image) ? ", user_image = :user_image" : "";
        
        $query = "UPDATE user
        SET 
        {$email_set}
        {$password_set}
        {$type_user_set}
        {$first_name_set}
        {$last_name_set}
        {$sur_name_set}
        {$age_set}
        {$phone_number_set}
        {$city_set}
        {$organization_set}
        {$position_set}
        {$status_account_set}
        {$code_set}
        {$group_set}
        {$user_image_set}
        WHERE id_user = :id";

        $stmt = $this->conn->prepare($query);

        if(!empty($this->email)){
            $this->email=htmlspecialchars(strip_tags($this->email));
            $stmt->bindParam(":email", $this->email);
        }
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);
        }
        if(!empty($this->type_user)){
            $this->type_user=htmlspecialchars(strip_tags($this->type_user));
            $stmt->bindParam(":type_user", $this->type_user);
        }
        if(!empty($this->first_name)){
            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $stmt->bindParam(":first_name", $this->first_name);
        }
        if(!empty($this->last_name)){
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $stmt->bindParam(":last_name", $this->last_name);
        }
        if(!empty($this->sur_name)){
            $this->sur_name=htmlspecialchars(strip_tags($this->sur_name));
            $stmt->bindParam(":sur_name", $this->sur_name);
        }
        if(!empty($this->age)){
            $this->age=htmlspecialchars(strip_tags($this->age));
            $stmt->bindParam(":age", $this->age);
        }
        if(!empty($this->phone_number)){
            $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
            $stmt->bindParam(":phone_number", $this->phone_number);
        }
        if(!empty($this->city)){
            $this->city=htmlspecialchars(strip_tags($this->city));
            $stmt->bindParam(":city", $this->city);
        }
        if(!empty($this->organization)){
            $this->organization=htmlspecialchars(strip_tags($this->organization));
            $stmt->bindParam(":organization", $this->organization);
        }
        if(!empty($this->position)){
            $this->position=htmlspecialchars(strip_tags($this->position));
            $stmt->bindParam(":position", $this->position);
        }
        if(!empty($this->status_account)){
            $this->status_account=htmlspecialchars(strip_tags($this->status_account));
            $stmt->bindParam(":status_account", $this->status_account);
        }
        if(!empty($this->code)){
            $this->code=htmlspecialchars(strip_tags($this->code));
            $stmt->bindParam(":code", $this->code);
        }
        if(!empty($this->group)){
            $this->group=htmlspecialchars(strip_tags($this->group));
            $stmt->bindParam(":group", $this->group);
        }
        if(!empty($this->user_image)){
            $this->user_image=htmlspecialchars(strip_tags($this->user_image));
            $stmt->bindParam(":user_image", $this->user_image);
        }
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if($stmt->execute()) {
            return true;
        }

        return false;

    }
    
    function userListGroupCreate()
    {
        $email_set=!empty($this->email) ? "email_user = :email" : "";
        $password_set=!empty($this->password) ? ", password_user = :password" : "";
        $type_user_set=!empty($this->type_user) ? ", fk_type_user = :type_user" : "";
        $first_name_set=!empty($this->first_name) ? ", firstname_user = :first_name" : "";
        $last_name_set=!empty($this->last_name) ? ", lastname_user = :last_name" : "";
        $sur_name_set=!empty($this->sur_name) ? ", surname_user = :sur_name" : "";
        $age_set=!empty($this->age) ? ", age_user = :age" : "";
        $phone_number_set=!empty($this->phone_number) ? ", phonenumber_user = :phone_number" : "";
        $city_set=!empty($this->city) ? ", city_user = :city" : "";
        $organization_set=!empty($this->organization) ? ", organization_customer = :organization" : "";
        $position_set=!empty($this->position) ? ", position_customer = :position" : "";
        $status_account_set=!empty($this->status_account) ? ", status_check_user = :status_account" : "";
        $code_set=!empty($this->code) ? ", activation_code = :code" : "";
        $group_set=!empty($this->group) ? ", fk_group_id = :group" : "";
        $user_image_set=!empty($this->user_image) ? ", user_image = :user_image" : "";
        
        $query = "INSERT INTO user
        SET
        {$email_set}
        {$password_set}
        {$type_user_set}
        {$first_name_set}
        {$last_name_set}
        {$sur_name_set}
        {$age_set}
        {$phone_number_set}
        {$city_set}
        {$organization_set}
        {$position_set}
        {$status_account_set}
        {$code_set}
        {$group_set}
        {$user_image_set}";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        if(!empty($this->email)){
            $this->email=htmlspecialchars(strip_tags($this->email));
            $stmt->bindParam(":email", $this->email);
        }
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);
        }
        if(!empty($this->type_user)){
            $this->type_user=htmlspecialchars(strip_tags($this->type_user));
            $stmt->bindParam(":type_user", $this->type_user);
        }
        if(!empty($this->first_name)){
            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $stmt->bindParam(":first_name", $this->first_name);
        }
        if(!empty($this->last_name)){
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $stmt->bindParam(":last_name", $this->last_name);
        }
        if(!empty($this->sur_name)){
            $this->sur_name=htmlspecialchars(strip_tags($this->sur_name));
            $stmt->bindParam(":sur_name", $this->sur_name);
        }
        if(!empty($this->age)){
            $this->age=htmlspecialchars(strip_tags($this->age));
            $stmt->bindParam(":age", $this->age);
        }
        if(!empty($this->phone_number)){
            $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
            $stmt->bindParam(":phone_number", $this->phone_number);
        }
        if(!empty($this->city)){
            $this->city=htmlspecialchars(strip_tags($this->city));
            $stmt->bindParam(":city", $this->city);
        }
        if(!empty($this->organization)){
            $this->organization=htmlspecialchars(strip_tags($this->organization));
            $stmt->bindParam(":organization", $this->organization);
        }
        if(!empty($this->position)){
            $this->position=htmlspecialchars(strip_tags($this->position));
            $stmt->bindParam(":position", $this->position);
        }
        if(!empty($this->status_account)){
            $this->status_account=htmlspecialchars(strip_tags($this->status_account));
            $stmt->bindParam(":status_account", $this->status_account);
        }
        if(!empty($this->code)){
            $this->code=htmlspecialchars(strip_tags($this->code));
            $stmt->bindParam(":code", $this->code);
        }
        if(!empty($this->group)){
            $this->group=htmlspecialchars(strip_tags($this->group));
            $stmt->bindParam(":group", $this->group);
        }
        if(!empty($this->user_image)){
            $this->user_image=htmlspecialchars(strip_tags($this->user_image));
            $stmt->bindParam(":user_image", $this->user_image);
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
    function userListGroupDelete(){
        $query = "DELETE FROM user
        WHERE id_user = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
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



    function userListGetData() {

        $query = "SELECT
        id_user, email_user, password_user, fk_type_user, created, modified, firstname_user, lastname_user, surname_user, age_user, phonenumber_user, city_user, organization_customer, position_customer, status_check_user, activation_code, fk_id_casting, fk_group_id, user_image
        FROM user
        WHERE fk_type_user = 1";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $users = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($this->conn);
            $user->id = $row["id_user"];
            $user->email = $row["email_user"];
            $user->password = $row["password_user"];
            $user->type_user = $row["fk_type_user"];
            $user->create_date = $row["created"];
            $user->mod_date = $row["modified"];
            $user->first_name = $row["firstname_user"];
            $user->last_name = $row["lastname_user"];
            $user->sur_name = $row["surname_user"];
            $user->age = $row["age_user"];
            $user->phone_number = $row["phonenumber_user"];
            $user->city = $row["city_user"];
            $user->organization = $row["organization_customer"];
            $user->position = $row["position_customer"];
            $user->status_account = $row["status_check_user"];
            $user->code = $row["activation_code"];
            $user->casting = $row["fk_id_casting"];
            $user->group = $row["fk_group_id"];
            $user->user_image = $row["user_image"];
            
            array_push($users, $user);
        }
        return $users;
    }

    public function userListUpdate()
    {

        $email_set=!empty($this->email) ? "email_user = :email" : "";
        $password_set=!empty($this->password) ? ", password_user = :password" : "";
        $type_user_set=!empty($this->type_user) ? ", fk_type_user = :type_user" : "";
        $first_name_set=!empty($this->first_name) ? ", firstname_user = :first_name" : "";
        $last_name_set=!empty($this->last_name) ? ", lastname_user = :last_name" : "";
        $sur_name_set=!empty($this->sur_name) ? ", surname_user = :sur_name" : "";
        $age_set=!empty($this->age) ? ", age_user = :age" : "";
        $phone_number_set=!empty($this->phone_number) ? ", phonenumber_user = :phone_number" : "";
        $city_set=!empty($this->city) ? ", city_user = :city" : "";
        $organization_set=!empty($this->organization) ? ", organization_customer = :organization" : "";
        $position_set=!empty($this->position) ? ", position_customer = :position" : "";
        $status_account_set=!empty($this->status_account) ? ", status_check_user = :status_account" : "";
        $code_set=!empty($this->code) ? ", activation_code = :code" : "";
        $group_set=!empty($this->group) ? ", fk_group_id = :group" : "";
        $user_image_set=!empty($this->user_image) ? ", user_image = :user_image" : "";
        
        $query = "UPDATE user
        SET 
        {$email_set}
        {$password_set}
        {$type_user_set}
        {$first_name_set}
        {$last_name_set}
        {$sur_name_set}
        {$age_set}
        {$phone_number_set}
        {$city_set}
        {$organization_set}
        {$position_set}
        {$status_account_set}
        {$code_set}
        {$group_set}
        {$user_image_set}
        WHERE id_user = :id";

        $stmt = $this->conn->prepare($query);

        if(!empty($this->email)){
            $this->email=htmlspecialchars(strip_tags($this->email));
            $stmt->bindParam(":email", $this->email);
        }
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);
        }
        if(!empty($this->type_user)){
            $this->type_user=htmlspecialchars(strip_tags($this->type_user));
            $stmt->bindParam(":type_user", $this->type_user);
        }
        if(!empty($this->first_name)){
            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $stmt->bindParam(":first_name", $this->first_name);
        }
        if(!empty($this->last_name)){
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $stmt->bindParam(":last_name", $this->last_name);
        }
        if(!empty($this->sur_name)){
            $this->sur_name=htmlspecialchars(strip_tags($this->sur_name));
            $stmt->bindParam(":sur_name", $this->sur_name);
        }
        if(!empty($this->age)){
            $this->age=htmlspecialchars(strip_tags($this->age));
            $stmt->bindParam(":age", $this->age);
        }
        if(!empty($this->phone_number)){
            $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
            $stmt->bindParam(":phone_number", $this->phone_number);
        }
        if(!empty($this->city)){
            $this->city=htmlspecialchars(strip_tags($this->city));
            $stmt->bindParam(":city", $this->city);
        }
        if(!empty($this->organization)){
            $this->organization=htmlspecialchars(strip_tags($this->organization));
            $stmt->bindParam(":organization", $this->organization);
        }
        if(!empty($this->position)){
            $this->position=htmlspecialchars(strip_tags($this->position));
            $stmt->bindParam(":position", $this->position);
        }
        if(!empty($this->status_account)){
            $this->status_account=htmlspecialchars(strip_tags($this->status_account));
            $stmt->bindParam(":status_account", $this->status_account);
        }
        if(!empty($this->code)){
            $this->code=htmlspecialchars(strip_tags($this->code));
            $stmt->bindParam(":code", $this->code);
        }
        if(!empty($this->group)){
            $this->group=htmlspecialchars(strip_tags($this->group));
            $stmt->bindParam(":group", $this->group);
        }
        if(!empty($this->user_image)){
            $this->user_image=htmlspecialchars(strip_tags($this->user_image));
            $stmt->bindParam(":user_image", $this->user_image);
        }
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if($stmt->execute()) {
            return true;
        }

        return false;

    }
    
    function userListCreate()
    {
        $email_set=!empty($this->email) ? "email_user = :email" : "";
        $password_set=!empty($this->password) ? ", password_user = :password" : "";
        $type_user_set=!empty($this->type_user) ? ", fk_type_user = :type_user" : "";
        $first_name_set=!empty($this->first_name) ? ", firstname_user = :first_name" : "";
        $last_name_set=!empty($this->last_name) ? ", lastname_user = :last_name" : "";
        $sur_name_set=!empty($this->sur_name) ? ", surname_user = :sur_name" : "";
        $age_set=!empty($this->age) ? ", age_user = :age" : "";
        $phone_number_set=!empty($this->phone_number) ? ", phonenumber_user = :phone_number" : "";
        $city_set=!empty($this->city) ? ", city_user = :city" : "";
        $organization_set=!empty($this->organization) ? ", organization_customer = :organization" : "";
        $position_set=!empty($this->position) ? ", position_customer = :position" : "";
        $status_account_set=!empty($this->status_account) ? ", status_check_user = :status_account" : "";
        $code_set=!empty($this->code) ? ", activation_code = :code" : "";
        $group_set=!empty($this->group) ? ", fk_group_id = :group" : "";
        $user_image_set=!empty($this->user_image) ? ", user_image = :user_image" : "";
        
        $query = "INSERT INTO user
        SET
        {$email_set}
        {$password_set}
        {$type_user_set}
        {$first_name_set}
        {$last_name_set}
        {$sur_name_set}
        {$age_set}
        {$phone_number_set}
        {$city_set}
        {$organization_set}
        {$position_set}
        {$status_account_set}
        {$code_set}
        {$group_set}
        {$user_image_set}";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        if(!empty($this->email)){
            $this->email=htmlspecialchars(strip_tags($this->email));
            $stmt->bindParam(":email", $this->email);
        }
        if(!empty($this->password)){
            $this->password=htmlspecialchars(strip_tags($this->password));
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);
        }
        if(!empty($this->type_user)){
            $this->type_user=htmlspecialchars(strip_tags($this->type_user));
            $stmt->bindParam(":type_user", $this->type_user);
        }
        if(!empty($this->first_name)){
            $this->first_name=htmlspecialchars(strip_tags($this->first_name));
            $stmt->bindParam(":first_name", $this->first_name);
        }
        if(!empty($this->last_name)){
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $stmt->bindParam(":last_name", $this->last_name);
        }
        if(!empty($this->sur_name)){
            $this->sur_name=htmlspecialchars(strip_tags($this->sur_name));
            $stmt->bindParam(":sur_name", $this->sur_name);
        }
        if(!empty($this->age)){
            $this->age=htmlspecialchars(strip_tags($this->age));
            $stmt->bindParam(":age", $this->age);
        }
        if(!empty($this->phone_number)){
            $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
            $stmt->bindParam(":phone_number", $this->phone_number);
        }
        if(!empty($this->city)){
            $this->city=htmlspecialchars(strip_tags($this->city));
            $stmt->bindParam(":city", $this->city);
        }
        if(!empty($this->organization)){
            $this->organization=htmlspecialchars(strip_tags($this->organization));
            $stmt->bindParam(":organization", $this->organization);
        }
        if(!empty($this->position)){
            $this->position=htmlspecialchars(strip_tags($this->position));
            $stmt->bindParam(":position", $this->position);
        }
        if(!empty($this->status_account)){
            $this->status_account=htmlspecialchars(strip_tags($this->status_account));
            $stmt->bindParam(":status_account", $this->status_account);
        }
        if(!empty($this->code)){
            $this->code=htmlspecialchars(strip_tags($this->code));
            $stmt->bindParam(":code", $this->code);
        }
        if(!empty($this->group)){
            $this->group=htmlspecialchars(strip_tags($this->group));
            $stmt->bindParam(":group", $this->group);
        }
        if(!empty($this->user_image)){
            $this->user_image=htmlspecialchars(strip_tags($this->user_image));
            $stmt->bindParam(":user_image", $this->user_image);
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
    function userListDelete(){
        $query = "DELETE FROM user
        WHERE id_user = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
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




// Метод для создания нового пользователя
    function create()
    {


        // Запрос для добавления нового пользователя в БД
        $query = "INSERT INTO " .$this->table_name ."
                SET
                    email_user = :email,
                    password_user = :password,
                    activation_code = :code";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->code = htmlspecialchars(strip_tags($this->code));


        // Привязываем значения
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":code", $this->code);

        // Для защиты пароля
        // Хешируем пароль перед сохранением в базу данных
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $password_hash);

        // Выполняем запрос
        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
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

// Проверка, существует ли кода  в  базе данных
    function userGetData() {

        $query = "SELECT *
        FROM " . $this->table_name . "
        WHERE id_user = :id
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

            $query = "SELECT group_name 
            FROM model_school.group_table 
            WHERE group_id = :group_id;";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":group_id", $row["fk_group_id"]);
            $stmt->execute();
            if($stmt->execute()){
                $cell = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->group = $cell["group_name"];
            }else{
                $this->group = $row["fk_group_id"];
            }

            // Присвоим значения свойствам объекта
            $this->user_id_table = $row["id_user"];
            $this->email = $row["email_user"];
            $this->password = $row["password_user"];
            $this->first_name = $row["firstname_user"];
            $this->last_name = $row["lastname_user"];
            $this->sur_name = $row["surname_user"];
            $this->age = $row["age_user"];
            $this->phone_number = $row["phonenumber_user"];
            $this->city = $row["city_user"];
            $this->organization = $row["organization_customer"];
            $this->position = $row["position_customer"];
            $this->portfolio = $row["fk_portfolio_user"];
            $this->payments = $row["fk_id_payments"];
            $this->casting = $row["fk_id_casting"];
            $this->user_image = $row["user_image"];
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
// Проверка, существует ли кода  в  базе данных
    function checkAuthCode() {

       
        $query = "SELECT id_user
            FROM " . $this->table_name . "
            WHERE email_user = :email
            AND activation_code = :code
            LIMIT 0,1";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);
        // Инъекция
        $this->code=htmlspecialchars(strip_tags($this->code));
        $this->email=htmlspecialchars(strip_tags($this->email));

        // Привязываем значение code
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":email", $this->email);

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
            $this->user_id_table = $row["id_user"];


            // Код обнавления данных

            // Если не введен пароль - не обновлять пароль
            $query = "UPDATE " . $this->table_name . "
            SET
                status_check_user = 1
            WHERE id_user = :id";

            // Подготовка запроса
            $stmt = $this->conn->prepare($query);

            // Привязываем значения с HTML формы
            $stmt->bindParam(":id", $this->user_id_table);

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

// Проверка, существует ли кода  в  базе данных
function userCastingRecord() {

       
    $query = "SELECT id_user
        FROM " . $this->table_name . "
        WHERE id_user = :id
        AND fk_id_casting IS NULL
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


        $query = "UPDATE " . $this->table_name . "
        SET
            fk_id_casting = :casting
        WHERE id_user = :id";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значения
        $stmt->bindParam(":casting", $this->casting);
        $stmt->bindParam(":id", $this->id);
        

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

function userCastingDeleteRecord() {

    $query = "SELECT *
        FROM " . $this->table_name . "
        WHERE id_user = :id
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
        $this->casting = $row["fk_id_casting"];


        $query = "UPDATE " . $this->table_name . "
        SET
            fk_id_casting = NULL
        WHERE id_user = :id";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Привязываем значения
        $stmt->bindParam(":id", $this->id);


        // Если выполнение успешно, то информация о пользователе будет сохранена в базе данных
        if($stmt->execute()) {

            $query = "UPDATE casting_table 
            SET views_casting = views_casting - 1
            WHERE id_casting = :casting_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":casting_id", $this->casting);
            $stmt->execute();
            return true;
        }else{
            return false;
        }

    }

    // Вернём "false", если адрес code не существует в базе данных
    return false;
}

// Проверка, существует ли электронная почта в нашей базе данных
    function emailExists() {

        // Запрос, чтобы проверить, существует ли электронная почта
        $query = "SELECT id_user, password_user, fk_type_user
            FROM " . $this->table_name . "
            WHERE email_user = ?
            AND status_check_user = 1
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
            $this->id = $row["id_user"];
            $this->password = $row["password_user"];
            $this->type_user = $row["fk_type_user"];

            // Вернём "true", потому что в базе данных существует электронная почта
            return true;
        }

        // Вернём "false", если адрес электронной почты не существует в базе данных
        return false;
    }

// Обновить запись пользователя
    public function update() {

        // Если в HTML-форме был введен пароль (необходимо обновить пароль)
        $password_set=!empty($this->password) ? ", password_user = :password" : "";
        $firstname_set=!empty($this->first_name) ? ", firstname_user = :first_name" : "";
        $last_name_set=!empty($this->last_name) ? ", lastname_user = :last_name" : "";
        $sur_name_set=!empty($this->sur_name) ? ", surname_user = :sur_name" : "";
        $age_set=!empty($this->age) ? ", age_user = :age" : "";
        $phone_number_set=!empty($this->phone_number) ? ", phonenumber_user = :phone_number" : "";
        $city_set=!empty($this->city) ? ", city_user = :city_user" : "";
        $organization_set=!empty($this->organization) ? ", organization_customer = :organization" : "";
        $position_set=!empty($this->position) ? ", position_customer = :position" : "";
        $user_image_set=!empty($this->user_image) ? ", user_image = :user_image" : "";

        // Если не введен пароль - не обновлять пароль
        $query = "UPDATE " . $this->table_name . "
            SET
                email_user = :email
                {$password_set}
                {$firstname_set}
                {$last_name_set}
                {$sur_name_set}
                {$age_set}
                {$phone_number_set}
                {$city_set}
                {$organization_set}
                {$position_set}
                {$user_image_set}
            WHERE id_user = :id";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция (очистка)
        $this->email=htmlspecialchars(strip_tags($this->email));
        // Привязываем значения с HTML формы
        $stmt->bindParam(":email", $this->email);


        if(!empty($this->first_name)){
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $stmt->bindParam(":first_name", $this->first_name);
        }
        if(!empty($this->last_name)){
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $stmt->bindParam(":last_name", $this->last_name);
        }
        if(!empty($this->sur_name)){
        $this->sur_name=htmlspecialchars(strip_tags($this->sur_name));
        $stmt->bindParam(":sur_name", $this->sur_name);
        }
        if(!empty($this->age)){
        $this->age=htmlspecialchars(strip_tags($this->age));
        $stmt->bindParam(":age", $this->age);
        }
        if(!empty($this->phone_number)){
        $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
        $stmt->bindParam(":phone_number", $this->phone_number);
        }
        if(!empty($this->city)){
        $this->city=htmlspecialchars(strip_tags($this->city));
        $stmt->bindParam(":city_user", $this->city);
        }
        if(!empty($this->organization)){
        $this->organization=htmlspecialchars(strip_tags($this->organization));
        $stmt->bindParam(":organization", $this->organization);
        }
        if(!empty($this->position)){
        $this->position=htmlspecialchars(strip_tags($this->position));
        $stmt->bindParam(":position", $this->position);
        }
        if(!empty($this->user_image)){
        $this->user_image=htmlspecialchars(strip_tags($this->user_image));
        $stmt->bindParam(":user_image", $this->user_image);
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
// Получение данных о кастингах пользователя
    function getUserCastingData() {

        // Запрос, чтобы проверить, существует ли электронная почта
        $query = "SELECT casting_table.id_casting, casting_table.fk_city_casting, casting_table.type_casting, casting_table.date_casting, casting_table.time_casting, casting_table.adress_casting, casting_table.x_coordinate_casting, casting_table.y_coordinate_casting
            FROM " . $this->table_name . "
            JOIN casting_table ON user.fk_id_casting = casting_table.id_casting
            WHERE user.fk_type_user = 1
            AND casting_table.status_casting = 1
            AND user.id_user = :id";

        // Подготовка запроса
        $stmt = $this->conn->prepare($query);

        // Инъекция
        $this->id=htmlspecialchars(strip_tags($this->id));

        // Привязываем значение e-mail
        $stmt->bindParam(":id", $this->id);

        // Выполняем запрос
        $stmt->execute();

        // Получаем количество строк
        $num = $stmt->rowCount();

        // Присвоим значения свойствам объекта для легкого доступа и использования для php сессий
        if ($num > 0) {

            $castings = array();
            // Получаем значения
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $casting = new Casting($this->conn);
            $casting->id_casting = $row['id_casting'];
            $casting->name_city_casting = $row['fk_city_casting'];
            $casting->type_casting = $row['type_casting'];
            $casting->date_casting = $row['date_casting'];
            $casting->time_casting = $row['time_casting'];
            $casting->adress_casting = $row['adress_casting'];
            $casting->x_coordinate_casting = $row['x_coordinate_casting'];
            $casting->y_coordinate_casting = $row['y_coordinate_casting'];
            array_push($castings, $casting);
            // Вернём "true", потому что в базе данных существует электронная почта
            return $castings;
        }

    }
}