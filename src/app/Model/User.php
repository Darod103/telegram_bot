<?php

namespace App\Model;

use PDO;
use App\Core\Database;

class User
{
    private PDO $pdo;
    private int $chatId;
    private bool $exist = false;
    private float $balance = 0;

    public function __construct(int $chatId)
    {
        $this->chatId = $chatId;
        $this->pdo = Database::connect();
        $this->createOrLoad();
    }

    /**
     * Приватный метод для создания или загрузки пользователя (использую переменную $exist как флаг).
     * @return void
     */
    private function createOrLoad(): void
    {
        $stmt = $this->pdo->prepare("SELECT balance FROM users WHERE telegram_id = :chat_id");
        $stmt->execute(['chat_id' => $this->chatId]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->exist = true;
            $this->balance = $row['balance'];


        } else {
            $stmt = $this->pdo->prepare("INSERT INTO users (telegram_id, balance) VALUES (:chat_id, 0)");
            $stmt->execute(['chat_id' => $this->chatId]);
            $this->exist = false;
            $this->balance = 0;
        }

    }

    /**
     *Метод проверяет существовать ли пользователь в БД.
     * @return bool
     */
    public function isNew(): bool
    {
        return !$this->exist;
    }

    /**
     * Метод возвращает баланс пользователя.
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * Метод обновляет баланс пользователя.
     * @param float $newBalance
     * @return bool
     */
    public function updateBalance(float $newBalance): bool
    {
        $this->pdo->beginTransaction();
        $stmt = $this->pdo->prepare('SELECT balance FROM users WHERE telegram_id = :chat_id FOR UPDATE');
        $stmt->execute(['chat_id' => $this->chatId]);
        $currentBalance = $stmt->fetchColumn();
        $newBalance = $currentBalance + $newBalance;

        if ($newBalance < 0) {
            $this->pdo->rollBack();
            return false;
        }
        $stmt = $this->pdo->prepare('UPDATE users SET balance = :balance WHERE telegram_id = :chat_id');
        $stmt->execute(['balance' => $newBalance, 'chat_id' => $this->chatId]);
        $this->pdo->commit();
        $this->balance = $newBalance;

        return true;
    }

}