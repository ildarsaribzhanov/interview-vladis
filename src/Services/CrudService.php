<?php


namespace App\Services;


use App\Storage\Contracts\GroupStorageContract;
use App\Storage\Contracts\ServerStorageContract;
use Exception;

/**
 * Class CrudService
 *
 * @package App\Services
 */
class CrudService
{
    /**
     * @var ServerStorageContract
     */
    private $serverStorage;

    /**
     * @var \App\Storage\Contracts\GroupStorageContract
     */
    private $groupStorage;

    /**
     * CrudService constructor.
     *
     * @param ServerStorageContract $serverStorage
     * @param GroupStorageContract  $groupStorage
     */
    public function __construct(ServerStorageContract $serverStorage, GroupStorageContract $groupStorage)
    {
        $this->serverStorage = $serverStorage;
        $this->groupStorage  = $groupStorage;
    }

    /**
     * Создание сервера
     *
     * @param string $ip
     * @param int    $group_id
     * @param string $comment
     *
     * @return bool
     * @throws Exception
     */
    public function createServer(string $ip, int $group_id, string $comment = '')
    {
        if (!$this->validateIp($ip)) {
            throw new Exception('Неверный формат ip');
        }

        if (!$this->groupStorage->findById($group_id)) {
            throw new Exception('Указанная группа не существует');
        }

        $this->serverStorage->create($group_id, $ip, $comment);

        return true;
    }


    /**
     * Проыерка ip на валидность
     *
     * @param string $ip
     *
     * @return bool
     */
    private function validateIp(string $ip)
    {
        $ip_sections = explode('.', $ip);

        if (count($ip_sections) != 4) {
            return false;
        }

        foreach ($ip_sections as $ip_section_itm) {
            if ((int)$ip_section_itm < 0 || (int)$ip_section_itm > 255) {
                return false;
            }
        }

        return true;
    }
}