<?php

namespace App\Services;


use App\Domain\ServerPing;
use App\Storage\Contracts\PingStorageContract;
use App\Storage\Contracts\ServerStorageContract;

/**
 * Class PingService
 *
 * @package App\Services
 */
class PingService
{
    /**
     * @var PingStorageContract
     */
    private $pingStorage;

    /**
     * @var \App\Storage\Contracts\ServerStorageContract
     */
    private $serverStorage;

    /**
     * PingService constructor.
     *
     * @param PingStorageContract   $pingStorageContract
     * @param ServerStorageContract $serverStorage
     */
    public function __construct(PingStorageContract $pingStorageContract, ServerStorageContract $serverStorage)
    {
        $this->pingStorage   = $pingStorageContract;
        $this->serverStorage = $serverStorage;
    }

    /**
     * По идее пинг может быть не очень быстрой операцией, и в этом случае всё подвиснет.
     * Я бы клал задачу в очередь и отдавал пользователю после получения какого-то ответа
     *
     * @param int $server_id
     *
     * @throws \App\Exceptions\UndefinedStatusException
     */
    public function sendPing(int $server_id)
    {
        $ping   = $this->pingStorage->create($server_id);
        $server = $this->serverStorage->findById($server_id);

        $this->ping($ping, $server->getIp());
    }

    /**
     * Непосредственно пинг
     *
     * @param ServerPing $ping
     * @param string     $ip
     *
     * @throws \App\Exceptions\UndefinedStatusException
     */
    private function ping(ServerPing $ping, string $ip): void
    {
        $ch = curl_init($ip);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $time     = curl_getinfo($ch, CURLINFO_TOTAL_TIME);

        curl_close($ch);

        if ($httpcode >= 200 && $httpcode < 300) {
            $ping->setStatus('success');
            $ping->setResponseTime($time * 1000);

            $this->pingStorage->save($ping);

            return;
        }

        $ping->setStatus('fail');
        $this->pingStorage->save($ping);
    }
}