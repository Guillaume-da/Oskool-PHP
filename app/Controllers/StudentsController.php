<?php

namespace App\Controllers;

use App\Models\Students;


class StudentsController extends CoreController
{
    /**
     * URL : /students/add
     *
     * @return void
     */
    public function add()
    {
        $this->show('students/add', [
            'students' => new Students(),
        ]);
    }

    /**
     * Students list
     *
     * @return void
     * 
     */
    public function studentsList()
    {
        $students = Students::findAll();
        $dataToDisplay = [
            'students' => $students
        ];
        $this->show('students/list', $dataToDisplay);
    }

    /**
     * Student addform
     * URL : /category/add
     *
     * @return void
     * 
     */
    public function newStudent()
    {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $teacher_id = filter_input(INPUT_POST, 'teacher_id', FILTER_SANITIZE_NUMBER_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $errorList = [];
        if (empty($firstname)) {
            $errorList[] = 'Vous devez saisir un prénom';
        }
        if (empty($lastname)) {
            $errorList[] = 'Vous devez saisir un nom';
        }
        if (empty($teacher_id)) {
            $errorList[] = 'Vous devez choisir un prof';
        }
        if (empty($status)) {
            $errorList[] = 'Vous devez choisir un statut';
        }
        if (empty($errorList)) {
            $student = new Students();

            $student->setFirstname($firstname);
            $student->setLastname($lastname);
            $student->setTeacherId($teacher_id);
            $student->setStatus($status);

            $inserted = $student->create();

            if ($inserted) {
                global $router;
                header('Location: ' . $router->generate('students-list'));
                return;
            } else {
                $errorList[] = 'L\'insertion des données s\'est mal passée';
            }
        }

        if (!empty($errorList)) {
            $student = new Students();
            $student->setFirstname($firstname);
            $student->setLastname($lastname);
            $student->setTeacherId($teacher_id);
            $student->setStatus($status);
            $this->show('students/add', [
                'errorList' => $errorList,
                'student' => $student
            ]);
        }
    }

    /**
     * 
     * @return void
     * 
     */
    public function update($student_id)
    {
        $student = Students::find($student_id);
        $dataToDisplay = [
            'student' => $student,
        ];
        $this->show('students/update', $dataToDisplay);
    }

    /**
     * 
     * @return void
     * 
     */
    public function edit($student_id)
    {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $teacher = filter_input(INPUT_POST, 'teacher', FILTER_SANITIZE_NUMBER_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $student = Students::find($student_id);

        $student->setFirstname($firstname);
        $student->setLastname($lastname);
        $student->setTeacherId($teacher);
        $student->setStatus($status);

        $errorList = [];
        if (empty($firstname)) {
            $errorList[] = 'Vous devez saisir un prénom';
        }
        if (empty($lastname)) {
            $errorList[] = 'Vous devez saisir un nom';
        }
        if (empty($teacher)) {
            $errorList[] = 'Vous devez choisir un prof';
        }
        if (empty($status)) {
            $errorList[] = 'Vous devez choisir un statut';
        }
        if (empty($errorList)) {
            $updated = $student->update();

            if ($updated) {
                global $router;
                $urlRedirect = $router->generate(
                    'students-list',
                    ['student_id' => $student_id]
                );
                header('Location: ' . $urlRedirect);
                return;
            } else {
                $errorList[] = 'L\'insertion des données s\'est mal passée';
            }
        }
        if (!empty($errorList)) {
            $this->show('students/update', [
                'errorList' => $errorList,
                'student' => $student
            ]);
        }
    }

    /**
     * Delete a student
     *
     * @param int $student_id
     * @return void
     * 
     */
    public function delete($student_id)
    {
        $student = Students::find($student_id);
        $queryExecuted  = $student->delete();
        if ($queryExecuted) {
            global $router;
            $urlLocation = $router->generate('students-list');
            header('Location: ' . $urlLocation);
        }
    }
}
