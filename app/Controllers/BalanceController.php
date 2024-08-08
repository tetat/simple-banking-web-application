<?php

namespace App\Controllers;

use App\Constants\StoragePath;
use App\FormValidator\TransferForm;

class BalanceController
{
    public function store(array $balance)
    {
        $balances = $this->index();

        $balances[] = $balance;

        $balanceData = json_encode($balances, JSON_PRETTY_PRINT);
        file_put_contents(StoragePath::BALANCES, $balanceData);
    }

    public function index()
    {
        $balances = json_decode(
            file_get_contents(StoragePath::BALANCES, true)
        ) ?? [];

        return $balances;
    }

    public function show(string $handle)
    {
        $balances = $this->index();
        $balance = [];

        foreach ($balances as $b) {
            if ($b->handle === $handle) {
                $balance = [
                    'handle' => $b->handle,
                    'amount' => $b->balance
                ];
                break;
            }
        }

        return $balance;
    }

    public function update(TransferForm $form, string $handle, float $amount)
    {
        $balance = (float) $this->show($handle)['amount'];

        if ($balance === -1) {
            $form->error('404', 'Reciever not found.')->throw();
        }

        if ($balance + $amount < 0) {
            $form->error('balance', 'Your balance is insufficient.')->throw();
        }

        $balances = $this->index();

        foreach ($balances as $b) {
            if ($b->handle === $handle) {
                $b->balance = $balance + $amount;
                break;
            }
        }

        $balanceData = json_encode($balances, JSON_PRETTY_PRINT);
        file_put_contents(StoragePath::BALANCES, $balanceData);
    }
}