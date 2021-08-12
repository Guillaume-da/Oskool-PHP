<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Teachers extends CoreModel
{

    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $job;
    /**
     * @var int
     */
    private $status;


    /**
     * Get the value of firstname
     *
     * @return  string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     * @return  self
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     * @return  self
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of job
     * @return  string
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set the value of job
     *
     * @param  string  $job
     * @return  self
     */
    public function setJob(string $job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     * @return  self
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Teachers list
     * 
     * @return Teachers[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `teacher`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Teachers');

        return $results;
    }

    /**
     * @param int $teacherId
     * @return $teacher
     */
    public static function find($teacherId)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `teacher` WHERE `id` =' . $teacherId;
        $pdoStatement = $pdo->query($sql);
        $teacher = $pdoStatement->fetchObject('App\Models\Teachers');
        return $teacher;
    }

    /**
     * Add a teacher
     * 
     * @return bool
     */
    public function create()
    {
        $pdo = Database::getPDO();
        $sql = " 
            INSERT INTO `teacher` (firstname, lastname, job, status)
            VALUES (:firstname, 
                    :lastname, 
                    :job, 
                    :status)
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':job' => $this->job,
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
     * Saving a teacher in database
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = "
            INSERT INTO `teacher` (firstname, lastname, job, status)
            VALUES (:firstname, 
                    :lastname, 
                    :job, 
                    :status)
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':job' => $this->job,
            ':status' => $this->status,
        ]);
        $insertedRows = $query->rowCount();

        if ($insertedRows === 1) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Update a teacher in database 
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $sql = "
            UPDATE `teacher`
            SET
                firstname = :firstname,
                lastname = :lastname, 
                job = :job,
                status = :status,
                updated_at = NOW()
            WHERE id = :id
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':job' => $this->job,
            ':status' => $this->status,
            ':id' => $this->id,
        ]);
        $updatedRows = $query->rowCount();
        return ($updatedRows > 0);
    }

    /**
     * Delete a teacher
     *
     * @return void
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = "
            DELETE FROM `teacher`
            WHERE id = :id
        ";

        $query = $pdo->prepare($sql);
        $query->execute([
            ':id' => $this->id,
        ]);
        $deletedRows = $query->rowCount();
        return ($deletedRows > 0);
    }
}
