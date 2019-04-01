<?php


namespace App\Storage;


use App\Domain\ServerGroup;
use App\Storage\Contracts\GroupStorageContract;
use PDO;

/**
 * Class GroupStorage
 *
 * @package App\Storage
 */
class GroupStorage implements GroupStorageContract
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var string
     */
    private $table = 'interview_group';

    /**
     * ServerStorage constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param array $row
     *
     * @return ServerGroup
     */
    private function parseOne(array $row)
    {
        $id    = (int)$row['id'];
        $title = (int)$row['title'];

        $group = new ServerGroup($id, $title);

        return $group;
    }

    /**
     * Поиск группы по id
     *
     * @param int $id
     *
     * @return ServerGroup
     */
    public function findById(int $id): ServerGroup
    {
        $stmt = $this->pdo->prepare("SELECT * FROM $this->table WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row   = $stmt->fetch(PDO::FETCH_LAZY);
        $group = $this->parseOne($row);

        return $group;
    }

    /**
     * Выборка всех групп
     *
     * @return array
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
     * Сохранить группу
     *
     * @param ServerGroup $group
     *
     * @return bool
     */
    public function save(ServerGroup $group): bool
    {
        $sql = "update $this->table set title = :title where id = :id";

        $data = [
            'title' => $group->getTitle(),
            'id'    => $group->getId(),
        ];

        $stm = $this->pdo->prepare($sql);
        $stm->execute($data);

        return true;
    }

    /**
     * Создание новой группы
     *
     * @param int $title
     *
     * @return ServerGroup
     */
    public function create(string $title): ServerGroup
    {
        $sql = "INSERT INTO $this->table SET title = :title";

        $data = ['title' => $title];

        $stm = $this->pdo->prepare($sql);
        $stm->execute($data);

        $group = new ServerGroup($this->pdo->lastInsertId(), $title);

        return $group;
    }
}