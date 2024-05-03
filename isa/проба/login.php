<?php
session_start();
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);
// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обработка данных из формы входа
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL запрос для проверки введенных данных
    $sql = "SELECT * FROM users WHERE login='$username' And password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        while($row=$result->fetch_assoc()){

            header("Location: index.html");
            
        } 
    } else {
        echo "Пользователь не найден";
    }
}

// Закрытие соединения
$conn->close();
?>
