<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
//$connect = mysqli_connect('localhost', 'u52961', '4288671', 'u52961');
//if(!mysqli_connect_errno()){
//    echo 'Не удалось подключиться: ', mysqli_connect_error();
//}
//else
//    echo 'Подключились к бд';*/

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}

include('form.php');

$errors = FALSE;
if (empty($_POST['name'])) {
  print('Некорректное имя.');
  $errors = TRUE;
}

if(empty($_POST['email'])){
  print('Некорректный email.');
  $errors = TRUE;
}

if (empty($_POST['year']) || !is_numeric($_POST['year']) || !preg_match('/^\d+$/', $_POST['year'])) {
  print('Некорректная дата.');
  $errors = TRUE;
}

if(empty($_POST['sex'])){
  print('Отметьте ваш пол.');
  $errors = TRUE;
}

if(empty($_POST['limbs'])){
  print('Отметьте кол-во конечностей.');
  $errors = TRUE;
}

if(empty($_POST['abilities[]'])){
  print('Отметьте ваши способности.');
  $errors = TRUE;
}

if(empty($_POST['biography'])){
  print('Введите начало своей биографии.');
  $errors = TRUE;
}

if(empty($_POST['rules'])){
  print('Вы не согласились с контрактом.');
  $errors = TRUE;
}

if($errors) exit();

$user = 'u52961'; // Заменить на ваш логин uXXXXX
$pass = '4288671'; // Заменить на пароль, такой же, как от SSH
$db = new PDO("mysql:host=localhost;dbname=$user", $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

// Подготовленный запрос. Не именованные метки.
try {
  $stmt = $db->prepare('INSERT INTO application VALUES ("null", ":name",
    ":email",":data",":sex",":limbs",":biography"])"');
  $stmt->execute(['null', 'name' => '$_POST["name"]','email' => '$_POST["email"]', 'data' => '$_POST["data"]',
 'sex' => '$_POST["sex"]', 'limbs' => '$_POST["limbs"]', 'biogrpahy' => '$_POST["biography"]']);
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

// $name = $_POST['name'];

// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

//  stmt - это "дескриптор состояния".

//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(['label'=>'perfect', 'color'=>'green']);

//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
?>