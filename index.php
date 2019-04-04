<?php
ini_set('error_reporting', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

use App\Domain\ServerGroup;
use App\Domain\ServerPing;
use App\Services\CrudService;
use App\Services\PingService;
use App\Storage\GroupStorage;
use App\Storage\PingStorage;
use App\Storage\ServerStorage;
use Dotenv\Dotenv;

require_once "vendor/autoload.php";

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$host = getenv('MYSQL_HOST', 'localhost');
$db   = getenv('MYSQL_DB');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASS');

$dsn = "mysql:host=$host;dbname=$db;charset=utf8";

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $opt);


$serverStor = new ServerStorage($pdo);
$groupStor  = new GroupStorage($pdo);
$pingStor   = new PingStorage($pdo);

echo '<style>
*{padding: 0; margin: 0;} 
table {border-collapse: collapse;}
td {padding:20px; vertical-align: top; border: 1px solid;}
button {padding: 5px;}
</style>';

if (isset($_POST['server-id'])) {
    $pingService = new PingService($pingStor, $serverStor);

    $pingService->sendPing((int)$_POST['server-id']);
}

require('views/create_form.php');

require('views/servers.php');