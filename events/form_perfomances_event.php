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
  $errors['stad'] = !empty($_COOKIE['sport_error']);
  

  if ($errors['name']) {
    setcookie('name_error', '', 100000);
    setcookie('name_value', '', 100000);
    $messages[] = '<div class="error">Выберите имя!</div>';
  }
  

  
  if ($errors['stad']) {
    setcookie('stad_error', '', 100000);
    setcookie('stad_value', '', 100000);
    $messages[] = '<div class="error">Выберите стадион!</div>';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['yaer'] = empty($_COOKIE['yaer_value']) ? '' : $_COOKIE['year_value'];
  $values['month'] = empty($_COOKIE['month_value']) ? '' : $_COOKIE['month_value'];
  $values['day'] = empty($_COOKIE['day_value']) ? '' : $_COOKIE['day_value'];
  $values['stad'] = empty($_COOKIE['stad_value']) ? '' : $_COOKIE['stad_value'];

  if (empty($errors) && !empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['id'])) {
      include('data.php');

      $formId = $_SESSION['id'];


      try {
       
        $sth = $db->prepare('SELECT date, place FROM performances WHERE id = :id');
          $sth->execute(['id' => $formId]);
          while ($row = $sth->fetch()) {
            $mas = explode(".", $row['date']);
            $values['day'] = $mas[0];
            $values['month'] = $mas[1];
            $values['year'] = $mas[2];
            $values['stad'] = $row['place'];
          }

          $sth = $db->prepare('SELECT id_memder FROM performances_members WHERE id_performance = :id');
          $sth->execute(['id' => $formId]);
          $row = $sth->fetchAll();
          $langsCV = '';

          for($i = 0; $i < count($row); $i++){
            $langsCV .= $rowl[$i] . ",";
          }
          $values['name'] = $langsCV;
      
      }
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
      }
      
      setcookie('name_value', $values['name'], time() + 30 * 24 * 60 * 60);
      setcookie('yaer_value', $values['year'], time() + 30 * 24 * 60 * 60);
      setcookie('month_value', $values['month'], time() + 30 * 24 * 60 * 60);
      setcookie('day_value', $values['day'], time() + 30 * 24 * 60 * 60);
      setcookie('stad_value', $values['stad'], time() + 30 * 24 * 60 * 60);
      

  }
 
  include('./pages/form_performances.php');

}
else {
 
  $errors = FALSE;
  $name='';
  if(!empty($_POST['name']))
  {
    for($i = 0; $i < count($_POST['name']); $i++)
    {
      $name .= $_POST['name'][$i] . ",";
    }
  }
  $stad ;
  if(!empty($_POST['stad']))
  {
    for($i = 0; $i < count($_POST['stad']); $i++)
    {
      $stad = $_POST['stad'][$i];
    }
  }
  setcookie('year_value', $_POST['year'], time() + 24 * 60 * 60);
  setcookie('month_value', $_POST['month'], time() + 24 * 60 * 60);
  setcookie('day_value', $_POST['day'], time() + 24 * 60 * 60);

    if (empty($_POST['name']) ) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
      else{setcookie('name_value', $name, time() + 30 * 24 * 60 * 60);}
    if (empty($_POST['stad']) ) {
      setcookie('stad_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else{setcookie('stad_value', $stad, time() + 30 * 24 * 60 * 60);}


    if ($errors) {
      // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
      header('Location: form_perfomances_event.php');
      exit();
    }
    else {
      // Удаляем Cookies с признаками ошибок.
      setcookie('name_error', '', 100000);
      setcookie('stad_error', '', 100000);
      // TODO: тут необходимо удалить остальные Cookies.
    }


    include('data.php');
    // Проверяем меняются ли ранее сохраненные данные или отправляются новые.
  if (!empty($_COOKIE[session_name()]) &&
  session_start() && !empty($_SESSION['id'])) {
  // TODO: перезаписать данные в БД новыми данными,
  // кроме логина и пароля.
  $formId = $_SESSION['id'];
 
  $stmt = $db->prepare("UPDATE performances SET date = :name, place = :place WHERE id = :id");
  $stmt -> execute(['name'=>$_POST['day'] . '.' . $_POST['month'] . '.' . $_POST['year'],'place'=>$stad, 'id' => $formId]);
  
  $stmt = $db->prepare("Delete from performances_members WHERE id_performance = :id");
  $stmt -> execute([ 'id' => $formId]);
  $stmt = $db->prepare("insert into performances_members (id_performance, id_member) values (:id_performance, :id_member)");
  foreach ($_POST['name'] as $id_lang) {
    $stmt->bindParam(':id_performance', $id_user);
    $stmt->bindParam(':id_member', $id_lang);
    $id_user = $formId;
    $stmt->execute();
}

  }

  else {
    include('data.php');

    try {
      $stmt = $db->prepare("INSERT INTO performances (date, place) VALUES (?, ?)");
      $stmt->execute([$_POST['day'] . '.' . $_POST['month'] . '.' . $_POST['year'], $stad]);

      $id = $db->lastInsertId();

      $stmt = $db->prepare("insert into performances_members (id_performance, id_member) values (:id_performance, :id_member)");
      foreach ($_POST['name'] as $id_lang) {
        $stmt->bindParam(':id_performance', $id_user);
        $stmt->bindParam(':id_member', $id_lang);
        $id_user = $id;
        $stmt->execute();
      }
      print('Данные успешно сохранены!');
    } catch (PDOException $e) {
      print('Error : ' . $e->getMessage());
      exit();
    }
  
  }

    setcookie('save', '1');
    header('Location: form_perfomances_event.php');
}