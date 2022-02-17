<!-- CONNEXION A LA BDD -->
<?php

require('vendor/autoload.php');


if($_SERVER['HTTP_HOST'] != "coffee-k6-dm.herokuapp.com") {

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
}

function dbaccess() {
  $dbConnection = "mysql:dbname=". $_ENV['DB_NAME'] ."; host=". $_ENV['DB_HOST'] .":". $_ENV['DB_PORT'] ."; charset=utf8";
  $user = $_ENV['DB_USERNAME'];
  $pwd = $_ENV['DB_PASSWORD'];
  
  $db = new PDO ($dbConnection, $user, $pwd, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

  return $db;
}
  
$db = dbaccess();

$req = $db->query('SELECT name FROM waiter')->fetchAll();

foreach ($req as $dbreq) {
  echo $dbreq['name'] . "<br>";
}


//affichage café 1.3

?>
<h3>Cafés</h3>
<?php

$base = $db->query('SELECT name, price FROM edible WHERE FORMAT(price,1) = "1.3" ');

foreach ($base as $dbbase) {

        echo $dbbase['name'] . ' ' . $dbbase['price'] . ' €' . "<br>";

}

