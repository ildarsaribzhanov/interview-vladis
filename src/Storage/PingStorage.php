<?php

namespace App\Storage;


use App\Domain\ServerPing;
use App\Storage\Contracts\PingStorageContract;
use Exception;
use PDO;

/**
 * Class PingStorage
 *
 * @package App\Storage
 */
class PingStorage implements PingStorageContract
{
    /**
     * @var PDO
     */
    private $pdo;

    private $table = 'interview_ping';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param array $row
     *
     * @return ServerPing
     * @throws Exception
     */
    private function parseOne(array $row): ServerPing
    {
        $id            = (int)$row['id'];
        $server_id     = (int)$row['server_id'];
        $status        = $row['status'];
        $response_time = (int)$row['response_time'];


        $ping = new ServerPing($id, $server_id);
        $ping->setStatus($status);
        $ping->setResponseTime($response_time);

        return $ping;
    }

    /**
     * Поиск сервера по id
     *
     * @param int $id
     *
     * @return ServerPing
     * @throws Exception
     */
    public function findById(int $id): ServerPing
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row  = $stmt->fetch(PDO::FETCH_LAZY);
        $ping = $this->parseOne($row);

        return $ping;
    }

    /**
     * Выборка всех серверов
     *
     * @return array
     * @throws Exception
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
     * @param ServerPing $ping
     *
     * @return bool
     */
    public function save(ServerPing $ping): bool
    {
        $sql = "update $this->table set server_id = :server_id, status = :status, response_time = :response_time where id = :id";

        $data = [
            'server_id'     => $ping->getServerId(),
            'status'        => $ping->getStatus(),
            'response_time' => $ping->getResponseTime(),
            'id'            => $ping->getId(),
        ];

        $stm = $this->pdo->prepare($sql);
        $stm->execute($data);

        return true;
    }

    /**
     * Создание нового сервера
     *
     * @param int    $server_id
     * @param string $status
     * @param int    $response_time
     *
     * @return ServerPing
     * @throws Exception
     */
    public function create(int $server_id, string $status = 'wait', int $response_time = 0): ServerPing
    {
        $sql = "INSERT INTO $this->table set server_id = :server_id, status = :status, response_time = :response_time";

        $data = [
            'server_id'     => $server_id,
            'status'        => $status,
            'response_time' => $response_time,
        ];

        $stm = $this->pdo->prepare($sql);

        print_r($stm);
        $stm->execute($data);

        $ping = new ServerPing($this->pdo->lastInsertId(), $server_id);
        $ping->setStatus($status);
        $ping->setResponseTime($response_time);

        return $ping;
    }
}