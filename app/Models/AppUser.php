<?php

namespace App\Models;

use App\Models\CoreModel;
use App\Utils\Database;
use PDO;


class AppUser extends CoreModel
{
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $role;
    /**
     * @var int
     */
    private $status;

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    /**
     * Get the value of role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Find a user by ID
     * 
     * @param int $userId
     * @return AppUser
     */
    public static function find($userId)
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM `app_user`
            WHERE id = :id';
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([
            ':id' => $userId
        ]);
        $result = $pdoStatement->fetchObject(self::class);
        return $result;
    }

    /**
     * 
     * @return AppUser[]
     * 
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        return $results;
    }

    /**
     *
     * @param $email
     * @return AppUser
     * 
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * from app_user WHERE email=:email';
        $pdo = Database::getPDO();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->bindValue(':email', $email);
        $pdoStatement->execute();
        return $pdoStatement->fetchObject(self::class);
    }

    /**
     *
     * @return void
     * 
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = "
            DELETE FROM `app_user`
            WHERE id = :id
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':id' => $this->id,
        ]);
        $deletedRows = $query->rowCount();
        return ($deletedRows > 0);
    }

    /**
     * 
     * @return bool
     * 
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = "
            INSERT INTO `app_user` (email, name, password, status, role)
            VALUES (:email, :name, :password, :status, :role)
        ";
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute([
            ':email' => $this->email,
            ':name' => $this->name,
            ':password' => $this->password,
            ':status' => $this->status,
            ':role' => $this->role,
        ]);
        $insertedRows = $pdoStatement->rowCount();
        if ($insertedRows === 1) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Add an AppUser
     * 
     * @return bool
     * 
     */
    public function create()
    {
        $pdo = Database::getPDO();
        $sql = " 
            INSERT INTO `app_user` (email, name, password, role, status)
            VALUES (:email, 
                    :name, 
                    :password,
                    :role, 
                    :status)
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':email' => $this->email,
            ':name' => $this->name,
            ':password' => $this->password,
            ':role' => $this->role,
            ':status' => $this->status
        ]);

        $insertedRows = $query->rowCount();
        if ($insertedRows === 1) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }


    /**
     * 
     * @return bool
     * 
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $sql = "
            UPDATE `app_user`
            SET
                email= :email,
                password=:password, 
                name=:name, 
                status=:status, 
                role=:role,
                updated_at = NOW()
            WHERE id = :id
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':email' => $this->email,
            ':password' => $this->password,
            ':name' => $this->name,
            ':status' => $this->status,
            ':role' => $this->role,
            ':id' => $this->id
        ]);
        $updatedRows = $query->rowCount();
        return ($updatedRows > 0);
    }
}
