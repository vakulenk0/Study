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
if (!empty($errors)) {
  print('<div id="messages"> <strong><h2>');
  // Выводим все сообщения.
  foreach ($errors as $message) {
    print($message);
    print('<br></br>');
  }
  print('</h2></strong></div>');
}?>
        <form id="form" action="" method="POST" >
        <div>
          <div class="wrap">
            <label>
              <strong><h3>Имя:</h3></strong>
              <input class="input-normal <?php if (!empty($errors['name'])) print('error'); ?>" 
              name="name" placeholder="Введите ваше имя"  
              value="<?php !empty($values['name']) ? print($values['name']) : print(''); ?>">

            </label> <br>
          </div>

          <div class="wrap">
            <label>
              <strong><h3>Ваш email:</h3></strong>
              <input class="input-normal <?php if (!empty($errors['email'])) print('error'); ?>" name="email" type="email" placeholder="Введите вашу почту"
              
              value="<?php print((isset($values['email'])) ? $values['email'] : ''); ?>"/>
            </label><br>
          </div>

          <div class="wrap">
            <label >
              <strong><h3>Дата рождения: </h3></strong>
              <input class="input-normal <?php if (!empty($errors['data'])) print('error');  ?>" name="data" type="date"
              value="<?php print($values['data']); ?>"/>
            </label> <br>
          </div>

          <div class="wrap">
            <label>
              <strong><h3>Ваш пол:</h3></strong>
              <input class="input-radio" type="radio" name="sex" value="М" <?php 
              if($values['sex']== 'М')
                echo 'checked';
              ?> >
              <span class="symbol">М</span>
            </label>
            <label >
              <input class="input-radio"  type="radio" name="sex" value="Ж" <?php 
              if($values['sex']=='Ж')
                echo 'checked'; ?>>
              <span class="symbol">Ж</span>
            </label><br>
          </div>

          <div class="wrap">
            <strong><h3>Кол-во конечностей:</h3></strong>
            <label>
              <input class="input-radio"  type="radio" name="limbs" value=1 <?php 
              if($values['limbs'] == 1)echo 'checked'; ?>>
              <span class="symbol">1</span>
            </label>
            <label>
              <input class="input-radio"  type="radio" name="limbs" value=2 <?php 
              if($values['limbs'] == 2)echo 'checked'; ?>>
              <span class="symbol">2</span>
            </label>
            <label>
              <input class="input-radio"  type="radio" name="limbs" value=3 <?php 
              if($values['limbs'] == 3)echo 'checked'; ?>>
              <span class="symbol">3</span>
            </label>
            <label>
              <input class="input-radio"  type="radio" name="limbs" value=4 <?php 
              if($values['limbs'] == 4)echo 'checked'; ?>>
              <span class="symbol">4</span>
            </label><br>
          </div>

          <div class="wrap">
            <label>
              <strong><h3>Сверхспособности:</h3></strong>
              <select  name="abilities[]" multiple="multiple">
                <option value=1 selected>
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
              <textarea class="<?php if (!empty($errors['biography'])) print('error'); ?>" name="biography"><?php print((isset($values['biography'])) ? $values['biography'] : ''); ?></textarea>
            </label><br>
          </div>

          <br>
          <strong><h3>С контрактом ознакомлен (а)</h3></strong>
          <div class="wrap">
            <label >
              <input class="check <?php if (!empty($errors['rules'])) print('error'); ?>" type="checkbox" name="rules" <?php 
              if(isset($_COOKIE['rules'])){
                echo 'checked';
              } ?>>
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