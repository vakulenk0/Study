<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
$values = array();
$errors = array();
$messages = array();
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $saved = FALSE;
  if (isset($_COOKIE['saved'])) {
    $saved = TRUE;
    setcookie('saved','1',1);
  }

  $errors['name'] = '';
  $errors['email'] = '';
  $errors['data'] = '';
  $errors['sex'] = '';
  $errors['limbs'] = '';
  $errors['abilities'] = '';
  $errors['biography'] = '';
  $errors['rules'] = '';


  if (!empty($_COOKIE['name'])){
    $errors['name'] = $_COOKIE['name'];
    setcookie('name','',1);
  }
  if (!empty(($_COOKIE['email']))){
    $errors['email'] = $_COOKIE['email'];
    setcookie('email','',1);
  }
  if (!empty(($_COOKIE['data']))){
    $errors['data'] = $_COOKIE['data'];
    setcookie('data','',1); 
  }
  if (!empty(($_COOKIE['sex']))){
    $errors['sex'] = $_COOKIE['sex'];
    setcookie('sex','',1); 
  }
  if (!empty(($_COOKIE['limbs']))){
    $errors['limbs'] = $_COOKIE['limbs'];
    setcookie('limbs','',1); 
  }
  if (!empty(($_COOKIE['abilities']))){
    $errors['abilities'] = $_COOKIE['abilities'];
    setcookie('abilities','',1); 
  }
  if (!empty(($_COOKIE['biography']))){
    $errors['biography'] = $_COOKIE['biography'];
    setcookie('biography','',1); 
  }
  if (!empty(($_COOKIE['rules']))){
    $errors['rules'] = $_COOKIE['rules'];
    setcookie('rules','',1); 
  }

  $values['name']  = empty($_COOKIE['name']) ? "" : $_COOKIE['name'];
  $values['email']  = empty($_COOKIE['email'])? "" : $_COOKIE['email']; 
  $values['data']  = empty($_COOKIE['data']) ? "" : $_COOKIE['data'];
  $values['sex']  = empty($_COOKIE['sex']) ? "": $_COOKIE['sex'];
  $values['limbs']  = empty($_COOKIE['limbs']) ? "" : $_COOKIE['limbs'];
  $values['abilities']  = empty($_COOKIE['abilities']) ? "" : $_COOKIE['abilities'];
  $values['biography']  = empty($_COOKIE['biography']) ? "" : $_COOKIE['biography'];
  $values['rules']  = empty($_COOKIE['rules']) ? 0 : $_COOKIE['rules'];

  include('form.php');
  exit();
}
// В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  // Массив для временного хранения сообщений пользователю.

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
setcookie('name', '');
} else {
  setcookie('name', $_POST['name']);
  $errors['name'] = false;
}

if(empty($_POST['email']) || !preg_match('/\w+\@+\w+\.+\w/', $_POST['email'])){
$messages[] = '<div class="error">Некорректный email.<br/><br/></div>';
$errors['email'] = TRUE;
setcookie('email', '');
} else {
  setcookie('email', $_POST['email']);
  $errors['email'] = false;
}

if (empty($_POST['data'])) {
$messages[] = '<div class="error">Заполните год.<br/><br/></div>';
$errors['data'] = TRUE;
setcookie('data', '');
} else {
  setcookie('data', $_POST['data']);
  $errors['data'] = false;
}

if(empty($_POST['sex'])){
$messages[] = '<div class="error">Отметьте ваш пол.<br/><br/></div>';
$errors['sex'] = TRUE;
setcookie('sex', '');
} else {
  setcookie('sex', $_POST['sex']);
  $errors['sex'] = false;
}

if(empty($_POST['limbs'])){
$messages[] = '<div class="error">Отметьте кол-во конечностей.<br/><br/></div>';
$errors['limbs'] = TRUE;
setcookie('limbs', '');
} else {
  setcookie('limbs', $_POST['limbs']);
  $errors['limbs'] = false;
}

if(empty($_POST['abilities'])){
$messages[] = '<div class="error">Отметьте ваши способности.<br/><br/></div>';
$errors['abilities'] = TRUE;
setcookie('abilities', '');
} else {
  setcookie('abilities', $_POST['abilities']);
  $errors['abilities'] = false;
}

if(empty($_POST['biography']) || !preg_match('/\w{10,}/', $_POST['biography'])){
$messages[] = '<div class="error">Либо ваша биография пуста, либо в ней 
использован запрещённый символ(разрешены только буквы и цифры).<br/><br/></div>';
$errors['biography'] = TRUE;
setcookie('biography', '');
} else {
  setcookie('biography', $_POST['biography']);
  $errors['biography'] = false;
}

if(empty($_POST['rules'])){
$messages[] = '<div class="error">Вы не согласились с контрактом.</div>';
$errors['rules'] = TRUE;
setcookie('rules', '');
} else {
  setcookie('rules', $_POST['rules']);
  $errors['rules'] = false;
}

// Включаем содержимое файла form.php.
include('form.php');

if($errors){
  // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
  header('Location: index.php');
  exit();
  } else {
    setcookie('save', '1', 1);
    header('Location: index.php');
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