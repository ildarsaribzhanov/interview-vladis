<?php


namespace App\Storage;


use App\Domain\Server;
use App\Storage\Contracts\ServerStorageContract;
use PDO;

/**
 * Class ServerStorage
 *
 * @package App\Storage
 */
class ServerStorage implements ServerStorageContract
{
    /**
     * @var PDO
     */
    private $pdo;

    private $table = 'interview_server';

    /**
     * ServerStorage constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function parseOne(array $row)
    {
        $id       = (int)$row['id'];
        $group_id = (int)$row['group_id'];
        $ip       = $row['ip'];
        $comment  = $row['comment'];


        $server = new Server($id, $group_id, $ip);

        $server->setComment($comment);

        return $server;
    }

    /**
     * Поиск сервера по id
     *
     * @param int $id
     *
     * @return Server
     */
    public function findById(int $id): Server
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row    = $stmt->fetch(PDO::FETCH_LAZY);
        $server = $this->parseOne($row);

        return $server;
    }

    /**
     * Выборка всех серверов
     *
     * @return Server[]
     */
    public function getAll(): array
    {
        $res = [];

        $data = $this->pdo->query("SELECT * FROM $this->table")->fetchAll();

        foreach ($data as $dataItm) {
            $res[] = $this->parseOne($dataItm);
        }

        return $res;
    }

    /**
     * Сохранить сервер
     *
     * @param Server $server
     *
     * @return bool
     */
    public function save(Server $server): bool
    {
        $sql = "update $this->table set group_id = :group_id, ip = :ip, comment = :comment where id = :id";

        $data = [
            'group_id' => $server->getGroupId(),
            'ip'       => $server->getIp(),
            'comment'  => $server->getComment(),
            'id'       => $server->getId(),
        ];

        $stm = $this->pdo->prepare($sql);
        $stm->execute($data);

        return true;
    }

    /**
     * Создание нового сервера
     *
     * @param int    $group_id
     * @param string $ip
     * @param string $comment
     *
     * @return Server
     */
    public function create(int $group_id, string $ip, string $comment = ''): Server
    {
        $sql = "INSERT INTO $this->table SET group_id = :group_id, ip = :ip, comment = :comment";

        $data = ['group_id' => $group_id, 'ip' => $ip, 'comment' => $comment];

        $stm = $this->pdo->prepare($sql);
        $stm->execute($data);

        $server = new Server($this->pdo->lastInsertId(), $group_id, $ip);
        $server->setComment($comment);

        return $server;
    }
}