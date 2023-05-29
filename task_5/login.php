<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

if (!empty($_SESSION['id'])) {
    session_destroy();
    setcookie('name',NULL,1);
    setcookie('email',NULL,1);
    setcookie('data',NULL,1);
    setcookie('sex',NULL,1);
    setcookie('limbs',NULL,1);
    setcookie('biography',NULL,1);
    setcookie('abilities',NULL,1);
    setcookie('rules',NULL,1);
}

$er_msg = '';
$login = '';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_COOKIE['er_msg'])){
        $er_msg = $_COOKIE['er_msg'];
        setcookie('er_msg',NULL,1);
    }
    if (isset($_COOKIE['login'])){
        $login = $_COOKIE['login'];
        setcookie('login',NULL,1);
    }

?>

<meta charset="UTF-8">
<title>Задание 5</title>
<link rel="stylesheet" href="style5.css">
<div class='href'>
  <a style="text-decoration: none;" href='index.php'>На главную</a>
</div>

<form id="form" action="" method="POST" >
    <div class="large-wrap">
        <div class="wrap">
            <label>
            <strong><h3>Логин:</h3></strong>
            <input class="input-normal <?php if (!empty($er_msg)) print('error'); ?>" 
            name="login" placeholder="Введите ваш логин"  
            
            value="<?php !empty($login) ? print($login) : print(''); ?>">
            </label> <br>
        </div>

        <div class="wrap">
            <label>
            <strong><h3>Пароль:</h3></strong>
            <input class="input-normal <?php if (!empty($er_msg)) print('error'); ?>" name="password" type="password" placeholder="Введите ваш пароль" />
            </label><br>
            </div>
            <br>

        <label >
            <input style="margin-bottom: 30px; width: 20%;" type="submit" value="Отправить">
        </label>

    </div>
</form>

<?php
}
else {
    if(empty($_POST['login']) || empty($_POST['password'])){
        setcookie('er_msg','Введите логин и пароль');
        header('Refresh: 0');
    }else{
        try{
            $user = 'u52961'; // Заменить на ваш логин uXXXXX
            $pass = '4288671'; // Заменить на пароль, такой же, как от SSH
            $db = new PDO('mysql:host=localhost;dbname=u52961', $user, $pass,
                [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            
            $stmt = $db->prepare("select id, login, password from application where login=:login");
            $stmt->execute(['login'=>$_POST['login']]);
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $atributes = $stmt->fetchAll();
            if(empty($atributes)){
                setcookie('er_msg','Неверные учетные данные');
                header('Refresh: 0');
            }else{
                setcookie('login',$_POST['login'], time() + 86400);
                if(password_verify($_POST['password'],$atributes[0]['password'])){
                    $_SESSION['id'] = $atributes[0]['id'];
                    setcookie('login',NULL,1);
                    header('Location: ./');
                }else{
                    setcookie('er_msg','Неверные учетные данные');
                    header('Refresh: 0');
                }
            }
        } catch(PDOException $e){
            die($e->getMessage());
        }
    }
}