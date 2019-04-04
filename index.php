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

if (isset($_POST['new-ip']) && isset($_POST['group-id'])) {

    $crudService = new CrudService($serverStor, $groupStor);

    $ip      = $_POST['new-ip'];
    $group   = (int)$_POST['group-id'];
    $comment = $_POST['comment'] ?? '';

    try {
        $crudService->createServer($ip, $group, $comment);
        echo 'Сервер добавлен';
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

$allGroups = $groupStor->getAll();

echo '<br /><form method="post" style="width: 300px; padding: 20px; background-color: #afafaf;">
    <h3>Добавить новый сервер</h3>
    <input type="text" name="new-ip" style="width: 100px;" required="required" /> 
    <select name="group-id" style="width: 180px;">';

    /** @var ServerGroup $groupItm */
    foreach ($allGroups as $groupItm) {
        echo '<option value="' . $groupItm->getId() . '">' . $groupItm->getTitle() . '</option>';
    }

    echo'</select><br />
    <textarea name="comment" id="" cols="30" rows="3" style="width: 285px; box-sizing: border-box; resize: none;"></textarea>
    <br />
    <button style="width: 285px">Добавить</button>
</form><br /><hr /><br />';

echo '<table>';
/** @var ServerGroup $groupItm */
foreach ($allGroups as $groupItm) {
    echo '<tr><td colspan="3"><h3>Группа серверов: ' . $groupItm->getTitle() . '</h3></td></tr>';

    $servers = $groupItm->getServers($serverStor);

    /*
     * todo добавить защиту nonce
     */
    foreach ($servers as $serverItm) {
        echo '<tr>
            <td>ip сервера: ' . $serverItm->getIp() . '<br />' . $serverItm->getComment() . '</td>
            <td><h4>История проверок:</h4>';
            $pings = $serverItm->getPings($pingStor);
            /** @var ServerPing $pingItm */
            foreach ($pings as $pingItm) {
                echo '<b>Дата:</b> <i>' . $pingItm->getDateForView() . '</i>; 
                            <b>Статус:</b> <i>' . $pingItm->getStatus() . '</i>;
                            <b>Время запроса:</b> <i>' . $pingItm->getResponseTime() . 'мс</i><br/>';
            }
            echo '</td>
            <td>
                <form method="post">
                    <input type="hidden" name="server-id" value="' . $serverItm->getId() . '" />
                    <button>Проверить отклик сервера</button>
                 </form>
            </td>
        </tr>';
    }
}
echo '</table>';