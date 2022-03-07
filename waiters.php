<?php

  require('vendor/autoload.php');

  if($_SERVER['HTTP_HOST'] !=  "toto.com") {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
  }

  $path = "mysql:host=".$_ENV['DB_HOST'].":".$_ENV['DB_PORT'].";dbname=".$_ENV['DB_NAME'].";charset=utf8";

  $pdo = new PDO(
    $path, 
    $_ENV['DB_USERNAME'], 
    $_ENV['DB_PASSWORD']
  );


  class Waiter {
    private $id;
    private $name;

    public function __construct($data) {
      $this->id = $data["id"];
      $this->name = $data["name"];
    }

    public function info() {
      return "Salut je suis {$this->name} et j'ai l'id {$this->id}";
    }
  }

  $sqlQuery = "SELECT * FROM `Waiter`";

  $waiters = [];

  foreach($pdo->query($sqlQuery) as $res) {
    array_push(
      $waiters, 
      new Waiter($res)
    );  
  }

if(count($waiters) > 0) {
$title = "Liste des serveurs";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
</head>
<body>

<h1>Les serveurs !</h1>

<?php
  foreach ($waiters as $waiter) {
    echo "<p>" . $waiter->info() . "</p>";
  }
?>
  
</body>
</html>


<?php
} else {
$title = "Serveurs introuvables";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
</head>
<body>

<h1>Oups il n y a aucun serveur, voulez-vous en ajouter un ?</h1>

<button id="add">Ajouter un serveur</button>
  
<script type="text/javascript" src="newWaiter.js"></script>
  
</body>
</html>

<?php
}
