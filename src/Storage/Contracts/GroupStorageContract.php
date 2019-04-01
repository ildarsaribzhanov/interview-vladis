<?php

namespace App\Storage\Contracts;


use App\Domain\ServerGroup;

interface GroupStorageContract
{
    /**
     * Поиск группы по id
     *
     * @param int $id
     *
     * @return ServerGroup
     */
    public function findById(int $id): ServerGroup;

    /**
     * Выборка всех групп
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Сохранить группу
     *
     * @param ServerGroup $group
     *
     * @return bool
     */
    public function save(ServerGroup $group): bool;

    /**
     * Создание новой группы
     *
     * @param string $title
     *
     * @return ServerGroup
     */
    public function create(string $title): ServerGroup;
}