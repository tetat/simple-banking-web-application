<?php

namespace App\Core\DB;

use PDO;

class SqlDb
{
    public function __construct(
        private PDO $db
    ){}

    public function insert(string $query, array $data)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        $id = $this->db->lastInsertId();
        return $id;
    }

    public function getAll(string $query)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $data = (array) $stmt->fetchAll();

        return $data;
    }

    public function getOne(string $query, array $data) {

        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        $data = (array) $stmt->fetch();

        return $data;
    }

    public function update(string $query, array $request)
    {
        $stmt = $this->db->prepare($query);
        $stmt->execute($request);
    }

    public static function create(PDO $db)
    {
        $instance = new static($db);

        return $instance;
    }
}