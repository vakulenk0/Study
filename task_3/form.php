<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Задание 3</title>
    <link rel="stylesheet" href="style3.css">
</head>

<body>
    <div>
        <form id="form" action="/" method="POST">
            <h2 class="pb-4 pt-3 text-left mx-3 text-sm-center">Форма</h2><br>
      <div class="text-sm-center text-left mx-2" id="form_text">
        <label>
          Имя: <br>
          <input name="name" value="Введите ваше имя"/>
        </label> <br>

        <label>
          Ваш email: <br>
          <input name="email" type="email" value="Введите email"/>
        </label><br>

        <label >
          Дата: <br>
          <input name="data" type="date" value=""/>
        </label> <br>

        <label>
          Ваш пол: <br>
          <input type="radio" name="sex">
          М
        </label>

        <label >
          <input type="radio" name="sex">
          Ж
        </label><br>

        Кол-во конечностей: <br>
        <label>
          <input type="radio" name="limbs">
          1
        </label>
        <label>
          <input type="radio" name="limbs">
          2
        </label>
        <label>
          <input type="radio" name="limbs">
          3
        </label>
        <label>
          <input type="radio" name="limbs">
          4
        </label><br>

        <label>
          Сверхспособности:
          <br >
          <select name="abilities" multiple="multiple">
            <option>
              Бессмертие
            </option>
            <option >
              Прохождение сквозь стены
            </option>
            <option >
              Левитация
            </option>

          </select>
        </label><br />

        <label >
          Биография: <br>
          <textarea name="biography" >Введите начало своей биографии
        </textarea>
        </label><br>

        <label >
          <input type="checkbox" name="rules">
        </label>

        С контрактом ознакомлен (а)<br>
        <label >
          <input type="submit" value="Отправить">
        </label>
      </div>
        </form>
    </div>

</body>
</html>