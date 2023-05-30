<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
$auth = FALSE;
if(session_start() && !empty($_SESSION['id'])){
  $auth = TRUE;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $saved = FALSE;
  if (isset($_COOKIE['saved'])) {
    $saved = TRUE;
    setcookie('saved',NULL,1);
    if (isset($_COOKIE['changed'])) {
      $changed = TRUE;
      setcookie('changed',NULL,1);
    }else{
      $login = $_COOKIE['login'];
      $password = $_COOKIE['password'];
      setcookie('login',NULL,1);
      setcookie('password',NULL,1);
    } 
  }
  if($auth && empty($_COOKIE['name'])){
    try{
      $user = 'u52961'; // Заменить на ваш логин uXXXXX
      $pass = '4288671'; // Заменить на пароль, такой же, как от SSH
      $db = new PDO('mysql:host=localhost;dbname=u52961', $user, $pass,
      [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

      $stmt = $db->prepare("select * from application where id=:id");
      $stmt->execute(['id'=>$_SESSION['id']]);
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $atributes = $stmt->fetchAll(); //Достаём из бд строку с данными нашего пользователя


      $stmt = $db->prepare("select s.sup_id from power s join application_power a on s.sup_id=a.sup_id where id=:id");
      $stmt->execute(['id'=>$_SESSION['id']]);
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $gg = $stmt->fetchAll(); // Достаём из бд строку с нашими способностями для данного пользователя
      
      $sups = array();
      foreach($tgg as $value) { 
        array_push($sups, $value['sup_id']);
      }

      setcookie('data',$atributes[0]['data']);  // Запоминаем куки
      setcookie('name',$atributes[0]['name']);
      setcookie('email',$atributes[0]['email']);
      setcookie('sex',$atributes[0]['sex']);
      setcookie('limbs',$atributes[0]['limbs']);
      setcookie('biography',$atributes[0]['biography']);
      setcookie('abilities',json_encode($sups)); // Сериализуем данные
      setcookie('rules','on');

      $values = array();
      $values['data']  = $atributes[0]['data'];
      $values['name']  = $atributes[0]['name'];
      $values['email']  = $atributes[0]['email'];
      $values['sex']  = $atributes[0]['sex'];
      
      $values['limbs']  = $atributes[0]['limbs'];
      $values['biography']  = $atributes[0]['biography'];
      $values['abilities']  = json_encode($sups);
      $values['rules']  = 'on';

    } 
    catch(PDOException $e){
        die($e->getMessage());
    }
    }else {
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
  
      $_SESSION['token'] = bin2hex(random_bytes(35));

      include('form.php');
      exit();
    }

    $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);

    if (!$token || $token !== $_SESSION['token']) {
      echo '<p class="error">Ошибка: неверная отправка формы</p>';
      header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
      exit;
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

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$%&';
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}


$arr = Array(
  'name' => $_POST["name"],
  'email' => $_POST["email"],
  'data' => $_POST["data"],
  'sex' => $_POST["sex"],
  'limbs' => $_POST["limbs"],
  'biography' => $_POST["biography"]
);
if($auth && !empty($_SESSION['id'])){
  try{
    $stmt = $db->prepare("UPDATE application SET name=:name,email=:email,data=:data,sex=:sex,limbs=:limbs,biography=:biography WHERE id=:id ");
    $stmt -> execute(['id'=>$_SESSION['id'], 'name'=>$_POST['name'], 'email'=>$_POST['email'],'data'=>$_POST['data'],'sex'=>$_POST['sex'],'limbs'=>$_POST['limbs'],'biography'=>$_POST['biography']]);
    $stmt -> execute();

    $stmt = $db->prepare("DELETE from application_power WHERE id=:id");
    $stmt -> execute(['id'=>$_SESSION['id']]);
    foreach ($_POST['abilities'] as $sup_id) {
      $stmt = $db->prepare("INSERT INTO application_power (app_id, sup_id) VALUES (:app_id,:sup_id)");
      $stmt -> execute(['app_id'=>$_SESSION['id'], 'sup_id'=>$sup_id]);
    }
    $ap_id = $_SESSION['id'];
    setcookie('changed',TRUE);
  } catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
  }
}else{
  $login = generate_string($permitted_chars, 8);
  $password = generate_string($permitted_chars, 8);

  $ap_id = 0;
  try{
    $stmt = $db->prepare("INSERT INTO application (login, password, name,email,data,sex,limbs,biography) VALUES (:login,:password,:name,:email,:data,:sex,:limbs,:biography)");
    $stmt -> execute(['login'=>$login, 'password'=>password_hash($password,PASSWORD_DEFAULT), 'name'=>$_POST['name'], 'email'=>$_POST['email'],'data'=>$_POST['data'],'sex'=>$_POST['sex'],'limbs'=>$_POST['limbs'],'biography'=>$_POST['biography']]);
    $stmt = $db->prepare("SELECT MAX(id) from application");
    $stmt->execute();
    $ap_id = $stmt->fetchColumn();
    foreach ($_POST['abilities'] as $sup_id) {
      $stmt = $db->prepare("INSERT INTO application_power (app_id, sup_id) VALUES (:app_id,:sup_id)");
      $stmt -> execute(['app_id'=>$ap_id, 'sup_id'=>$sup_id]);
    }
  } catch(PDOException $e){
      print('Error : ' . $e->getMessage());
      exit();
  }
}

$errors = array();

// setcookie('name',null,1);
// setcookie('email',null,1);
// setcookie('data',null,1);
// setcookie('sex','М',1);
// setcookie('limbs',1,1);
// setcookie('abilities',null,1);
// setcookie('biography',null,1);
// setcookie('rules',null,1);
// setcookie('saved',1);
// header('Location: index.php');

session_start();
$_SESSION['id'] = $ap_id;
setcookie('saved',1);
setcookie('login',$login);
setcookie('password',$password);
header('Location: .');
?>