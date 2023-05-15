<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Задание 4</title>
    <link rel="stylesheet" href="style4.css">
</head>

<body>
    <div class="container">
      <div class="large-wrap">
      <?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
        <form id="form" action="" method="POST" >
        <div>
          <div class="wrap">
            <label>
              <strong><h3>Имя:</h3></strong>
              <input class="input-normal" name="name" placeholder="Введите ваше имя" 

              <?php if ($errors['name']) {print 'class="error")';} ?> value="<?php print $values['name']  ?>"/>

            </label> <br>
          </div>

          <div class="wrap">
            <label>
              <strong><h3>Ваш email:</h3></strong>
              <input class="input-normal" name="email" type="email" placeholder="Введите вашу почту"
              
              <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php if(!empty($_GET['email'])) print($_COOKIE['email']) ?>"/>
            </label><br>
          </div>

          <div class="wrap">
            <label >
              <strong><h3>Дата рождения: </h3></strong>
              <input class="input-normal" name="data" type="date"
               
              <?php if ($errors['data']) {print 'class="error"';} ?> 
              value="<?php if(!$errors['data']) print($_COOKIE['data']) ?>"
              
              />
            </label> <br>
          </div>

          <div class="wrap">
            <label>
              <strong><h3>Ваш пол:</h3></strong>
              <input class="input-radio" type="radio" name="sex" value="М">
              <span class="symbol">М</span>
            </label>
            <label >
              <input class="input-radio"  type="radio" name="sex" value="Ж">
              <span class="symbol">Ж</span>
            </label><br>
          </div>

          <div class="wrap">
            <strong><h3>Кол-во конечностей:</h3></strong>
            <label>
              <input class="input-radio"  type="radio" name="limbs" value=1>
              <span class="symbol">1</span>
            </label>
            <label>
              <input class="input-radio"  type="radio" name="limbs" value=2>
              <span class="symbol">2</span>
            </label>
            <label>
              <input class="input-radio"  type="radio" name="limbs" value=3>
              <span class="symbol">3</span>
            </label>
            <label>
              <input class="input-radio"  type="radio" name="limbs" value=4>
              <span class="symbol">4</span>
            </label><br>
          </div>

          <div class="wrap">
            <label>
              <strong><h3>Сверхспособности:</h3></strong>
              <select  name="abilities" multiple="multiple">
                <option value=1>
                  Бессмертие
                </option>
                <option value=2>
                  Прохождения сквозь стены
                </option>
                <option value=3>
                  Левитация
                </option>

              </select>
            </label><br />
          </div>

          <div class="wrap">
            <label >
              <strong><h3>Биография: </h3></strong>
              <textarea name="biography"></textarea>
            </label><br>
          </div>

          <br>
          <strong><h3>С контрактом ознакомлен (а)</h3></strong>
          <div class="wrap">
            <label >
              <input class="check" type="checkbox" name="rules">
            </label>
          </div>
          <br>
          <label >
            <input style="margin-bottom: 30px; width: 60%;" type="submit" value="Отправить">
          </label>
        </div>
          </form>
      </div>
    </div>

</body>
</html>