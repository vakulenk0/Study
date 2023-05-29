<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $saved = FALSE;
  if (isset($_COOKIE['saved'])) {
    $saved = TRUE;
    setcookie('saved','');
    print('<div>Данные успешно отправлены!</div>');
  }
  $errors = array();
  if (isset($_COOKIE['error_name'])){
    $errors['name'] = $_COOKIE['error_name'];
    setcookie('error_name','');
  }
  if (isset($_COOKIE['error_email'])){
    $errors['email'] = $_COOKIE['error_email'];
    setcookie('error_email','');
  }
  if (isset($_COOKIE['error_data'])){
    $errors['data'] = $_COOKIE['error_data'];
    setcookie('error_data',''); 
  }
  if (isset($_COOKIE['error_rules'])){
    $errors['rules'] = $_COOKIE['error_rules'];
    setcookie('error_rules','');
  }
  if (isset($_COOKIE['error_biography'])){
    $errors['biography'] = $_COOKIE['error_biography'];
    setcookie('error_biography','');
  }
  if (isset($_COOKIE['error_abilities'])){
    $errors['abilities'] = $_COOKIE['error_abilities'];
    setcookie('error_abilities','');
  }
  $values = array();
  $values['data']  = empty($_COOKIE['data']) ? "" : $_COOKIE['data'];
  $values['name']  = empty($_COOKIE['name'])? "" : $_COOKIE['name']; 
  $values['email']  = empty($_COOKIE['email']) ? "" : $_COOKIE['email'];
  $values['sex']  = isset($_COOKIE['sex'])?$_COOKIE['sex']: "М" ;
  $values['limbs']  = isset($_COOKIE['limbs'])?$_COOKIE['limbs']:4 ;
  $values['biography']  = empty($_COOKIE['biography']) ? "" : $_COOKIE['biography'];
  $values['abilities']  = empty($_COOKIE['abilities']) ? "" : $_COOKIE['abilities'];
  $values['rules']  = empty($_COOKIE['rules']) ? 0 : $_COOKIE['rules'];

  include('form.php');
  exit();
}

$errors = array();

setcookie('data',$_POST['data']);
setcookie('name',$_POST['name']); 
setcookie('email',$_POST['email']);
isset($_COOKIE['sex']) ? setcookie('sex',$_POST['sex']) : 'М';
setcookie('biography',$_POST['biography']);
if(empty($_POST['rules']))
  setcookie('rules','');
else setcookie('rules', $_POST['rules']);

if (empty($_POST['name'])) 
$errors['name'] = '<div class="error">Имя заполнено неверно.(Можно использовать только буквы
 и имя должно быть записано без пробелов.<br/><br/></div>';



if(empty($_POST['email']) || !preg_match('/\w+\@+\w+\.+\w/', $_POST['email'])){
$errors['email']= '<div class="error">Некорректный email.<br/><br/></div>';
}

if (empty($_POST['data'])) {
$errors['data'] = '<div class="error">Заполните год.<br/><br/></div>';
}


if(empty($_POST['sex'])){
$errors['sex'] = '<div class="error">Отметьте ваш пол.<br/><br/></div>';
}

if(empty($_POST['abilities'])){
$errors['abilities'] = '<div class="error">Отметьте ваши способности.<br/><br/></div>';

}

if(empty($_POST['biography'])){
$errors['biography'] = '<div class="error">Либо ваша биография пуста, либо в ней 
использован запрещённый символ(разрешены только буквы и цифры).<br/><br/></div>';
}

if(empty($_POST['rules'])){
$errors['rules'] = '<div class="error">Вы не согласились с контрактом.</div>';
}


if ($errors) {
  foreach ($errors as $key => $value) {
    setcookie('error_'.$key, $value);
  }
  header('Location: index.php');
  exit();
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
  $stmt = $db->prepare("INSERT INTO application (login, password, name, email, data, sex, limbs, biography) 
  VALUES (:login, :password, :name, :email, :data, :sex, :limbs, :biography)");

  $stmt->bindParam(':name', $arr['name']);
  $stmt->bindParam(':email', $arr['email']);
  $stmt->bindParam(':data', $arr['data']);
  $stmt->bindParam(':sex', $arr['sex']);
  $stmt->bindParam(':limbs', $arr['limbs']);
  $stmt->bindParam(':biography', $arr['biography']);
  $stmt->bindParam(':login', 'login');
  $stmt->bindParam(':password', 'password');

  $stmt->execute();

  $stmt = $db->prepare("SELECT MAX(id) from application");
  $stmt->execute();
  $id = $stmt->fetchColumn();

  foreach($_POST['abilities'] as $power){
    $stmt = $db->prepare("INSERT INTO application_power (id, app_id, sup_id) VALUES (null, :app_id, :sup_id)");
    $stmt->bindParam(':app_id', $id);
    $stmt->bindParam(':sup_id', $power);
    $stmt->execute();
  }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

$errors = array();

setcookie('name',null,1);
setcookie('email',null,1);
setcookie('data',null,1);
setcookie('sex','М',1);
setcookie('limbs',1,1);
setcookie('abilities',null,1);
setcookie('biography',null,1);
setcookie('rules',null,1);
setcookie('saved',1);
header('Location: index.php');
?>