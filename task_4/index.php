<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');


// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

  setcookie('name', $_GET['name']);
setcookie('email', $_GET['email']);
setcookie('data', $_GET['data']);
setcookie('sex', $_GET['sex']);
setcookie('limbs', $_GET['limbs']);
setcookie('abilities', $_GET['abilities']);
setcookie('biography', $_GET['biography']);
setcookie('rules', $_GET['rules']);


  // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
  // Выдаем сообщение об успешном сохранении.
  if (!empty($_COOKIE['save'])) {
    // Удаляем куку, указывая время устаревания в прошлом.
    setcookie('save', '', 100000);
    // Если есть параметр save, то выводим сообщение пользователю.
    $messages[] = 'Спасибо, результаты сохранены.';
  }

   // Складываем признак ошибок в массив.
   $errors = array();

   if (empty($_GET['name']) || !preg_match('/\w{2,}/', $_GET['name']) || preg_match('/[0-9]/', $_GET['name'])
|| preg_match('/\W/', $_GET['name'])) {
  $messages[] = 'Имя заполнено неверно.(Можно использовать только буквы и имя должно быть записано без пробелов.<br/><br/>';
  $errors['name'] = TRUE;
}else setcookie('name', $_GET['name']);

if(empty($_GET['email']) || !preg_match('/\w+\@+\w+\.+\w/', $_GET['email'])){
  $messages[] = 'Некорректный email.<br/><br/>';
  $errors['email'] = TRUE;
}else setcookie('email', $_GET['email']);

if (empty($_GET['data'])) {
  $messages[] = 'Заполните год.<br/><br/>';
  $errors['data'] = TRUE;
} else setcookie('data', $_GET['data']);

if(empty($_GET['sex'])){
  $messages[] = 'Отметьте ваш пол.<br/><br/>';
  $errors['sex'] = TRUE;
} else setcookie('sex', $_GET['sex']);

if(empty($_GET['limbs'])){
  $messages[] = 'Отметьте кол-во конечностей.<br/><br/>';
  $errors['limbs'] = TRUE;
} else setcookie('limbs', $_GET['limbs']);

if(empty($_GET['abilities'])){
  $messages[] = 'Отметьте ваши способности.<br/><br/>';
  $errors['abilities'] = TRUE;
} else setcookie('abilities', $_GET['abilities']);

if(empty($_GET['biography']) || !preg_match('/\w{10,}/', $_GET['biography'])){
  $messages[] = 'Либо ваша биография пуста, либо в ней использован запрещённый символ(разрешены только буквы и цифры).<br/><br/>';
  $errors['biography'] = TRUE;
} else setcookie('biography', $_GET['biography']);

if(empty($_GET['rules'])){
  $messages[] = 'Вы не согласились с контрактом.';
  $errors['rules'] = TRUE;
} else setcookie('rules', $_GET['rules']);

  // Включаем содержимое файла form.php.
  include('form.php');

  if($errors){
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: index.php');
    exit();
    } 
} 
else if($_SERVER['REQUEST_METHOD'] == 'POST'){
// В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  // Массив для временного хранения сообщений пользователю.
  $messages = array();

setcookie('name', $_POST['name']);
setcookie('email', $_POST['email']);
setcookie('data', $_POST['data']);
setcookie('sex', $_POST['sex']);
setcookie('limbs', $_POST['limbs']);
setcookie('abilities', $_POST['abilities']);
setcookie('biography', $_POST['biography']);
setcookie('rules', $_POST['rules']);


// В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
// Выдаем сообщение об успешном сохранении.
if (!empty($_COOKIE['save'])) {
  // Удаляем куку, указывая время устаревания в прошлом.
  setcookie('save', '', 100000);
  // Если есть параметр save, то выводим сообщение пользователю.
  $messages[] = 'Спасибо, результаты сохранены.';
}

 // Складываем признак ошибок в массив.
 $errors = array();

 if (empty($_POST['name']) || !preg_match('/\w{2,}/', $_POST['name']) || preg_match('/[0-9]/', $_POST['name'])
|| preg_match('/\W/', $_POST['name'])) {
$messages[] = '<div class="error">Имя заполнено неверно.(Можно использовать только буквы
 и имя должно быть записано без пробелов.<br/><br/></div>';
$errors['name'] = TRUE;
} else setcookie('name', $_POST['name']);

if(empty($_POST['email']) || !preg_match('/\w+\@+\w+\.+\w/', $_POST['email'])){
$messages[] = '<div class="error">Некорректный email.<br/><br/></div>';
$errors['email'] = TRUE;
} else setcookie('email', $_POST['email']);

if (empty($_POST['data'])) {
$messages[] = '<div class="error">Заполните год.<br/><br/></div>';
$errors['data'] = TRUE;
} else setcookie('data', $_POST['data']);

if(empty($_POST['sex'])){
$messages[] = '<div class="error">Отметьте ваш пол.<br/><br/></div>';
$errors['sex'] = TRUE;
} else setcookie('sex', $_POST['sex']);

if(empty($_POST['limbs'])){
$messages[] = '<div class="error">Отметьте кол-во конечностей.<br/><br/></div>';
$errors['limbs'] = TRUE;
} else setcookie('limbs', $_POST['limbs']);

if(empty($_POST['abilities'])){
$messages[] = '<div class="error">Отметьте ваши способности.<br/><br/></div>';
$errors['abilities'] = TRUE;
} else setcookie('abilities', $_POST['abilities']);

if(empty($_POST['biography']) || !preg_match('/\w{10,}/', $_POST['biography'])){
$messages[] = '<div class="error">Либо ваша биография пуста, либо в ней 
использован запрещённый символ(разрешены только буквы и цифры).<br/><br/></div>';
$errors['biography'] = TRUE;
} else setcookie('biography', $_POST['biography']);

if(empty($_POST['rules'])){
$messages[] = '<div class="error">Вы не согласились с контрактом.</div>';
$errors['rules'] = TRUE;
} else setcookie('rules', $_POST['rules']);

// Включаем содержимое файла form.php.
include('form.php');

if($errors){
  // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
  header('Location: index.php');
  exit();
  } 
}

$user = 'u52961'; // Заменить на ваш логин uXXXXX
$pass = '4288671'; // Заменить на пароль, такой же, как от SSH
$db = new PDO('mysql:host=localhost;dbname=u52961', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); // Заменить test на имя БД, совпадает с логином uXXXXX

// Подготовленный запрос. Не именованные метки.

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

  // $stmt = $db->prepare("SELECT MAX(id) from application");
  // $stmt->execute();
  // $id = $stmt->fetchColumn();
  $id = $db->lastInsertId();

  $stmt = $db->prepare("INSERT INTO application_power (id, app_id, sup_id) VALUES (null, :app_id, :sup_id)");
  $stmt->bindParam(':app_id', $id);
  $stmt->bindParam(':sup_id', ($_POST['abilities'])[0]);
  $stmt->execute();
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