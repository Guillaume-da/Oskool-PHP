<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Students extends CoreModel
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
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $teacher_id;

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
     *
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
     *
     * @return  self
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

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
     *
     * @return  self
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of teacher_id
     *
     * @return  int
     */
    public function getTeacherId()
    {
        return $this->teacher_id;
    }

    /**
     * Set the value of teacher_id
     *
     * @param  int  
     *
     * @return  self
     */
    public function setTeacherId(int $teacher_id)
    {
        $this->teacher_id = $teacher_id;

        return $this;
    }

    /**
     * 
     * @return Students[]
     * 
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `student`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Students');
        return $results;
    }

    /**
     * Find a student ID
     * 
     * @param int $studentId 
     * @return $student
     */
    public static function find($studentId)
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `student` WHERE `id` =' . $studentId;
        $pdoStatement = $pdo->query($sql);
        $student = $pdoStatement->fetchObject('App\Models\Students');
        return $student;
    }

    /**
     * @return bool
     */
    public function create()
    {
        $pdo = Database::getPDO();
        $sql = "
            INSERT INTO `student` (firstname, lastname, teacher_id, status)
            VALUES (:firstname, 
                    :lastname,
                    :teacher_id,
                    :status)
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':teacher_id' => $this->teacher_id,
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
     * Saving in database
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();
        $sql = "
            INSERT INTO `student` (firstname, lastname, teacher_id, status)
            VALUES (:firstname, 
                    :lastname, 
                    :teacher_id, 
                    :status)
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':teacher_id' => $this->teacher_id,
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
     * Update a student in database 
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $sql = "
            UPDATE `student`
            SET
                firstname = :firstname,
                lastname = :lastname, 
                teacher_id = :teacher_id,
                status = :status,
                updated_at = NOW()
            WHERE id = :id
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':teacher_id' => $this->teacher_id,
            ':status' => $this->status,
            ':id' => $this->id,
        ]);
        $updatedRows = $query->rowCount();
        return ($updatedRows > 0);
    }

    /**
     * Delete a Student
     *
     * @return void
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $sql = "
            DELETE FROM `student`
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
