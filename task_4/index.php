<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $saved = FALSE;
  if (isset($_COOKIE['saved'])) {
    $saved = TRUE;
    setcookie('saved',NULL,1);
  }
  $errors = array();
  if (isset($_COOKIE['error_name'])){
    $errors['name'] = $_COOKIE['name'];
    setcookie('name',NULL,1);
  }
  if (isset($_COOKIE['email'])){
    $errors['email'] = $_COOKIE['email'];
    setcookie('email',NULL,1);
  }
  if (isset($_COOKIE['data'])){
    $errors['data'] = $_COOKIE['data'];
    setcookie('data',NULL,1); 
  }
  if (isset($_COOKIE['sex'])){
    $errors['sex'] = $_COOKIE['sex'];
    setcookie('sex',NULL,1);
  }
  if (isset($_COOKIE['limbs'])){
    $errors['limbs'] = $_COOKIE['limbs'];
    setcookie('limbs',NULL,1);
  }
  if (isset($_COOKIE['abilities'])){
    $errors['abilities'] = $_COOKIE['abilities'];
    setcookie('abilities',NULL,1);
  }
  if (isset($_COOKIE['biography'])){
    $errors['biography'] = $_COOKIE['biography'];
    setcookie('biography',NULL,1);
  }
  if (isset($_COOKIE['rules'])){
    $errors['rules'] = $_COOKIE['narulesme'];
    setcookie('rules',NULL,1);
  }
  $values = array();
  $values['name']  = empty($_COOKIE['name']) ? "" : $_COOKIE['name'];
  $values['email']  = empty($_COOKIE['email'])? "" : $_COOKIE['email']; 
  $values['data']  = empty($_COOKIE['data']) ? "" : $_COOKIE['data'];
  $values['sex']  = isset($_COOKIE['sex'])?$_COOKIE['sex']:1 ;
  $values['limbs']  = isset($_COOKIE['limbs'])?$_COOKIE['limbs']:4 ;
  $values['abilities']  = empty($_COOKIE['abilities']) ? "" : $_COOKIE['abilities'];
  $values['biography']  = empty($_COOKIE['biography']) ? "" : $_COOKIE['biography'];
  $values['rules']  = empty($_COOKIE['rules']) ? 0 : $_COOKIE['rules'];
  

  include('form.php');
  exit();
}

setcookie('name',$_POST['name']);
setcookie('email',$_POST['email']); 
setcookie('data',$_POST['data']);
setcookie('sex',$_POST['sex']);
setcookie('limbs',$_POST['limbs']);
setcookie('abilities',$_POST['abilities']);
setcookie('biography',$_POST['biography']);
setcookie('rules',$_POST['rules']);

$errors = array();

 if (empty($_POST['name']) || !preg_match('/\w{2,}/', $_POST['name']) || preg_match('/[0-9]/', $_POST['name'])
|| preg_match('/\W/', $_POST['name'])) 
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

if(empty($_POST['limbs'])){
$errors['limbs'] = '<div class="error">Отметьте кол-во конечностей.<br/><br/></div>';
}

if(empty($_POST['abilities'])){
$errors['abilities'] = '<div class="error">Отметьте ваши способности.<br/><br/></div>';

}

if(empty($_POST['biography']) || !preg_match('/\w{10,}/', $_POST['biography'])){
$errors['biography'] = '<div class="error">Либо ваша биография пуста, либо в ней 
использован запрещённый символ(разрешены только буквы и цифры).<br/><br/></div>';
}

if(empty($_POST['rules'])){
$errors['rules'] = '<div class="error">Вы не согласились с контрактом.</div>';
}
// Включаем содержимое файла form.php.
include('form.php');

if ($errors) {
  foreach ($errors as $key => $value) {
    setcookie($key, $value);
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
  $stmt = $db->prepare("INSERT INTO application (name, email, data, sex, limbs, biography) 
  VALUES (:name, :email, :data, :sex, :limbs, :biography)");

  $stmt->bindParam(':name', $arr['name']);
  $stmt->bindParam(':email', $arr['email']);
  $stmt->bindParam(':data', $arr['data']);
  $stmt->bindParam(':sex', $arr['sex']);
  $stmt->bindParam(':limbs', $arr['limbs']);
  $stmt->bindParam(':biography', $arr['biography']);
  $stmt->execute();

  $stmt = $db->prepare("SELECT MAX(id) from application");
  $stmt->execute();
  $id = $stmt->fetchColumn();

  $stmt = $db->prepare("INSERT INTO application_power (id, app_id, sup_id) VALUES (null, :app_id, :sup_id)");
  $stmt->bindParam(':app_id', $id);
  $stmt->bindParam(':sup_id', ($_POST['abilities'])[0]);
  $stmt->execute();
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
setcookie('name',NULL,1);
setcookie('email',NULL,1);
setcookie('data',NULL,1);
setcookie('sex',NULL,1);
setcookie('limbs',NULL,1);
setcookie('abilities',NULL,1);
setcookie('biography',NULL,1);
setcookie('rules',NULL,1);
setcookie('saved',1);
header('Location: index.php');
?>
<br /><b>Warning</b>:  
Undefined variable $values in <b>C:\Users\Dmitry\WebstormProjects\Study\task_4\form.php</b> 
on line <b>33</b><br /><br /><b>Warning</b>:  
Trying to access array offset on value of type null in 
<b>C:\Users\Dmitry\WebstormProjects\Study\task_4\form.php</b> on line <b>33</b><br />