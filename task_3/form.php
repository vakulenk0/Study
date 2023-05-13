<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Задание 3</title>
    <link rel="stylesheet" href="style3.css">
</head>

<body>
    <div class="container">
      <!-- <?php
      echo '<div> <strong>HELLOO</strong> </div>';
      ?> -->
      <div class="large-wrap">
        <form id="form" action="" method="POST">
        <div>
          <div class="wrap">
            <label>
              <strong><h3>Имя:</h3></strong>
              <input class="input-normal" name="name" placeholder="Введите ваше имя"/>
            </label> <br>
          </div>

          <div class="wrap">
            <label>
              <strong><h3>Ваш email:</h3></strong>
              <input class="input-normal" name="email" type="email" placeholder="Введите вашу почту"/>
            </label><br>
          </div>

          <div class="wrap">
            <label >
              <strong><h3>Дата рождения: </h3></strong>
              <input class="input-normal" name="data" type="date"/>
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
              <select  name="abilities[]" multiple="multiple">
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