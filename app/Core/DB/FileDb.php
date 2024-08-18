<?php

namespace App\Core\DB;

use App\Constants\StoragePath;

class FileDb
{
    public function __construct()
    {
        $data = $this->getAll(StoragePath::PRIMARYKEYS);
        if (!$data) {
            $data = [
                'user' => '0',
                'balance' => '0',
                'transaction' => '0'
            ];
            $this->insert(StoragePath::PRIMARYKEYS, $data);
        }
    }

    public function insert(string $storage_path, array $data)
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($storage_path, $jsonData);
    }

    public function getAll(string $storage_path)
    {
        $data = (array) json_decode(
            file_get_contents($storage_path, true)
        );

        return $data;
    }

    public function getOne(string $storage_path, array $request)
    {
        $data = $this->getAll($storage_path);
        $oneData = [];
        foreach($data as $d) {
            $d = (array) $d;
            if (isset($request['id'])) {
                if ($d['id'] === $request['id']) $oneData = $d;
            }
            if (isset($request['email'])) {
                if ($d['email'] === $request['email']) $oneData = $d;
            }
            if (isset($request['user_id'])) {
                if ($d['user_id'] === $request['user_id']) $oneData = $d;
            }
        }

        return $oneData;
    }

    public function update(string $storage_path, array $request)
    {
        
    }

    public static function create()
    {
        $instance = new static();

        return $instance;
    }
}