<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('<br/><br/> Спасибо, результаты сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.php');
  // Завершаем работу скрипта.
  exit();
}
$errors = FALSE;
print('<br/><br/>');
if (empty($_POST['name'])) {
  print('Заполните имя.<br/><br/>');
  $errors = TRUE;
}

if(empty($_POST['email'])){
  print('Некорректный email.<br/><br/>');
  $errors = TRUE;
} else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  print('Неверный email.<br/><br/>');
  $errors = TRUE;
}

if (empty($_POST['data'])) {
  print('Заполните год.<br/><br/>');
  $errors = TRUE;
}

if(empty($_POST['sex'])){
  print('Отметьте ваш пол.<br/><br/>');
  $errors = TRUE;
}

if(empty($_POST['limbs'])){
  print('Отметьте кол-во конечностей.<br/><br/>');
  $errors = TRUE;
}

if(empty($_POST['abilities'])){
  print('Отметьте ваши способности.<br/><br/>');
  $errors = TRUE;
}

if(empty($_POST['biography'])){
  print('Введите начало своей биографии.<br/><br/>');
  $errors = TRUE;
}

if(empty($_POST['rules'])){
  print('Вы не согласились с контрактом.');
  $errors = TRUE;
}

if($errors) exit();

$user = 'u52961'; // Заменить на ваш логин uXXXXX
$pass = '4288671'; // Заменить на пароль, такой же, как от SSH
$db = new PDO('mysql:host=localhost;dbname=u52961', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

// Подготовленный запрос. Не именованные метки.

// $ArrNames = Array(
//   "name",
//   "email",
//   "data",
//   "sex",
//   "limbs",
//   "biography"
// );

$arr = Array(
  'name' => $_POST["name"],
  'email' => $_POST["email"],
  'data' => $_POST["data"],
  'sex' => $_POST["sex"],
  'limbs' => $_POST["limbs"],
  'biography' => $_POST["biography"]
);

try {
  $stmt = $db->prepare("INSERT INTO application (name, email, data, sex, limbs, biography) 
  VALUES (:name, :email, :data, :sex, :limbs, :biography)");
//   $stmt->execute(['name' => '$_POST["name"]','email' => '$_POST["email"]', 'data' => '$_POST["data"]',
//  'sex' => '$_POST["sex"]', 'limbs' => '$_POST["limbs"]', 'biogrpahy' => '$_POST["biography"]']);
  $stmt->bindParam(':name', $arr['name']);
  $stmt->bindParam(':email', $arr['email']);
  $stmt->bindParam(':data', $arr['data']);
  $stmt->bindParam(':sex', $arr['sex']);
  $stmt->bindParam(':limbs', $arr['limbs']);
  $stmt->bindParam(':biography', $arr['biography']);
  $stmt->execute();

  $id = $stmt->lastInsertId();
  echo "stmt: ";
  echo $stmt->lastInsertId();
  echo "db: ";
  echo $db->lastInsertId();
  $st = $db->prepare("INSERT INTO application_power VALUES (null, :id, :id_abilities)");
  $st->bindParam(':id', $id);
  $st->bindParam(':id_abilities', $_POST['abilities[]']);
  $st->execute();
  // foreach ($_POST['abilities[]'] as $sup_id) {
  //   $stmt = $db->prepare("INSERT INTO application_superpower VALUES (null,:app_id,:sup_id)");
  //   $stmt -> execute(['app_id'=>$id, 'sup_id'=>$sup_id]);
  // }
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