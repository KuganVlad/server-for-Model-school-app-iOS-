<?php

class Pay
{
    // Подключение к БД таблице "pay"
    private $conn;
    private $table_pay = "payment_table";
    private $table_deposite = "payment_deposited_student_table";

    // Свойства

    public $id;
    //payment_table
    public $id_payment;
    public $fk_full_amount;
    public $deposited_amount;
    public $remaining_amount;
    public $date_first_paymant;
    public $fk_user_id_payment;

    //payment_deposited_student_table
    public $id_deposit;
    public $sum_desposited_amount;
    public $date_desposited_amount; 
    public $fk_user_id_desposited;

    


    // Конструктор класса Casting
    public function __construct($db)
    {
        $this->conn = $db;
    }


    function getAllDepositData(){
        $query = "SELECT *
        FROM " . $this->table_deposite . "
        WHERE fk_user_id_desposited = :id";


         // Подготовка запроса
         $stmt = $this->conn->prepare($query);
         // Инъекция
         $this->id=htmlspecialchars(strip_tags($this->id));
 
         // Привязываем значение code
         $stmt->bindParam(":id", $this->id);
 
         // Выполняем запрос
         $stmt->execute();


        $despositeds = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $desposited = new Pay($this->conn);
            $desposited->id_deposit = $row['id_deposit'];
            $desposited->sum_desposited_amount = $row['sum_desposited_amount'];
            $desposited->date_desposited_amount = $row['date_desposited_amount'];
            $desposited->fk_user_id_desposited = $row['fk_user_id_desposited'];

            array_push($despositeds, $desposited);
        }
        return $despositeds;
    }
    
    function getAllPaymentData(){

        //обновление данных
        $query = "UPDATE payment_table
        SET deposited_amount = (
        SELECT SUM(sum_desposited_amount)
        FROM payment_deposited_student_table
        WHERE fk_user_id_desposited = :id
        )
        WHERE fk_user_id_payment = :id";
    
        $tmp_stmt = $this->conn->prepare($query);
        $tmp_stmt->bindParam(":id", $this->id);
        $tmp_stmt->execute();
        

        $query = "SELECT * 
        FROM " . $this->table_pay . "
        WHERE fk_user_id_payment = :id
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

        if($num>0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id_payment = $row['id_payment'];
            $this->fk_full_amount = $row['fk_full_amount'];
            $this->deposited_amount = $row['deposited_amount'];
            $this->remaining_amount = $row['remaining_amount'];
            $this->date_first_paymant = $row['date_first_paymant'];
            $this->fk_user_id_payment = $row['fk_user_id_payment'];

            return true;
        }else{
            return false;
        }
    }
}