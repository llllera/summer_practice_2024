<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();

    if (!empty($_COOKIE['save'])) {
      setcookie('save', '', 100000);
      $messages[] = 'Спасибо, результаты сохранены.';
       // Если в куках есть пароль, то выводим сообщение.
    }
     // Складываем признак ошибок в массив.
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']); // если не пусто присваивается TRUE
  $errors['phone'] = !empty($_COOKIE['phone_error']);
  $errors['sport'] = !empty($_COOKIE['sport_error']);
  

  if ($errors['name']) {
    if($_COOKIE['name_error']=='1'){
      $messages[] = '<div class="error">Заполните имя!</div>';
    }
    else{
      $messages[] = '<div class="error">Поле должно содержать только буквы и пробелы!</div>';
    }
    setcookie('name_error', '', 100000);
    setcookie('name_value', '', 100000);
  }
  
  if ($errors['phone']) {
    if($_COOKIE['phone_error']=='1'){

      $messages[] = '<div class="error">Заполните номер телефона!</div>';
    }
    else{
      $messages[] = '<div class="error">Поле должно содержать только знак + и цифры!</div>';
    }
    setcookie('phone_error', '', 100000);
    setcookie('phone_value', '', 100000);
  }
  
  if ($errors['sport']) {
    setcookie('sport_error', '', 100000);
    setcookie('sport_value', '', 100000);
    $messages[] = '<div class="error">Выберите вид спорта!</div>';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
  $values['sport'] = empty($_COOKIE['sport_value']) ? '' : $_COOKIE['sport_value'];

  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['id'])) {
      include('data.php');
      $formId = $_SESSION['id'];
      try {
       
        $sth = $db->prepare('SELECT name, phone, sport FROM sportsmen WHERE id = :id');
          $sth->execute(['id' => $formId]);
          while ($row = $sth->fetch()) {
            $values['name'] = $row['name'];
            $values['phone'] = $row['phone'];
            $values['sport'] = $row['sport'];
          }
      }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }
      
      setcookie('name_value', $values['name'], time() + 30 * 24 * 60 * 60);
      setcookie('phone_value', $values['phone'], time() + 30 * 24 * 60 * 60);
      setcookie('sport_value', $values['sport'], time() + 30 * 24 * 60 * 60);
  }
 
  include('./pages/form_sport.php');
}

else {
  $errors = FALSE;

  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $spost ;
  if(!empty($_POST['sport']))
  {
    for($i = 0; $i < count($_POST['sport']); $i++)
    {
      $sport = $_POST['sport'][$i];
    }
  }

    if (empty($name)) {
      // Выдаем куку на день с флажком об ошибке в поле fio.
      setcookie('name_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $name)){
      setcookie('name_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    // Сохраняем ранее введенное в форму значение на месяц.
    else{setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);}

    if (empty($phone) ) {
      setcookie('phone_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else if(!preg_match('/^(\+\d+|\d+)$/', $phone)){
      setcookie('phone_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);}

   
    if (empty($_POST['sport']) ) {
      setcookie('sport_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('sport_value', $sport, time() + 30 * 24 * 60 * 60);}


    if ($errors) {
      // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
      header('Location: form_sport_event.php');
      exit();
    }
    else {
      // Удаляем Cookies с признаками ошибок.
      setcookie('name_error', '', 100000);
      setcookie('phone_error', '', 100000);
      setcookie('sport_error', '', 100000);

    }

    include('data.php');
    if (!empty($_COOKIE[session_name()]) &&
    session_start() && !empty($_SESSION['id'])) {

    $formId = $_SESSION['id'];
    
    $stmt = $db->prepare("UPDATE sportsmen SET name = :name, phone = :phone, sport = :sport WHERE id = :id");
    $stmt -> execute(['name'=>$name,'phone'=>$phone, 'sport'=>$sport,'id' => $formId]);
  }

  else {
    include('data.php');

    try {
      $stmt = $db->prepare("INSERT INTO sportsmen (name, phone, sport) VALUES (?, ?, ?)");
      $stmt->execute([$name, $phone, $sport]);
      
      print('Данные успешно сохранены!');
    } catch (PDOException $e) {
      print('Error : ' . $e->getMessage());
      exit();
    }
  
  }
    setcookie('save', '1');
    header('Location: form_sport_event.php');
}