<?php
require 'vendor/autoload.php';
$env = Dotenv\Dotenv::createImmutable(__DIR__, '/.env');
$env->load();
$servername = $_ENV['SQLSERVER'];
$username = $_ENV['SQLUSERNAME'];
$password = $_ENV['SQLPASSWORD'];
$database = $_ENV['SQLDB'];
// Create  connection with database
try {
    $conn = mysqli_connect(
        $servername,
        $username,
        $password,
        $database,
    );
    if ($conn) {
        // echo 'db connected';
    } else {
        echo 'Sql not connected';
        die("Error" . mysqli_connect_error());
    }
} catch (\Throwable $th) {
    echo $th;
}

?>

<?php
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', "tcp://localhost:6379?auth=root");
session_start();
$count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;
echo $count;
$_SESSION['count'] = ++$count;
?>
<?php

require 'vendor/autoload.php';
$env = Dotenv\Dotenv::createImmutable(__DIR__, '/.env');
$env->load();
try {
    $client = new MongoDB\Client(
        $_ENV['MONGO']
    );


    $profileCollection = $client->guvi_task->profile;
    // echo "Connection to database successfully";
} catch (Throwable $e) {
    echo "Captured Throwable for connection : " . $e->getMessage() . PHP_EOL;
}
?>