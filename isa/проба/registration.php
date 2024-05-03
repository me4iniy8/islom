<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "isa";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Соединение не установлено: " . $conn->connect_error);
}

// Обработка данных из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    if(isset($_POST["submit"])){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
    
        $errors=array();
        if(empty($username) OR empty($email) OR empty($password) OR empty($cpassword)){
            array_push($errors, "Строки не могут быть пустыми");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email не действителен");
        }
        if(strlen($password)<8){
            array_push($errors, "Пароль должен содержать не менее 8 символов");
        }
        if($password!==$cpassword){
            array_push($errors, "Пароль не совпадает");
        }
    
        if(count($errors)>0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
    // Проверка пароля
    if ($password != $cpassword) {
        echo "Пароли не совпадают!";
    } else {
        // Хэширование пароля
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        

        // SQL запрос для вставки данных в таблицу
        $sql = "INSERT INTO users (login, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            // Успешная регистрация
            
                  header('Location: auth.html'); 
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
        }
    }}
}

// Закрытие соединения
$conn->close();
?>

