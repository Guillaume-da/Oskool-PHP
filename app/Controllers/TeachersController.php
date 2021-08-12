<?php

namespace App\Controllers;

use App\Models\Teachers;


class TeachersController extends CoreController
{
    /**
     * Show Teachers list
     *
     * @return void
     * 
     */
    public function teachersList()
    {
        $teachers = Teachers::findAll();
        $dataToDisplay = [
            'teachers' => $teachers
        ];

        $this->show('teachers/list', $dataToDisplay);
    }

    /**
     * URL : /teachers/add
     *
     * @return void
     * 
     */
    public function add()
    {
        $this->show('teachers/add', [
            'teachers' => new Teachers(),
        ]);
    }

    /**
     * Teacher addform
     * URL : /teachers/add
     *
     * @return void
     * 
     */
    public function newTeacher()
    {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $job = filter_input(INPUT_POST, 'job', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $errorList = [];
        if (empty($firstname)) {
            $errorList[] = 'Vous devez saisir un prénom';
        }
        if (empty($lastname)) {
            $errorList[] = 'Vous devez saisir un nom';
        }
        if (empty($job)) {
            $errorList[] = 'Vous devez saisir un job';
        }
        if (empty($status)) {
            $errorList[] = 'Vous devez saisir un statut';
        }

        if (empty($errorList)) {
            $teacher = new Teachers();

            $teacher->setFirstname($firstname);
            $teacher->setLastname($lastname);
            $teacher->setJob($job);
            $teacher->setStatus($status);

            $inserted = $teacher->create();

            if ($inserted) {
                global $router;
                header('Location: ' . $router->generate('teachers-list'));
                return;
            } else {
                $errorList[] = 'L\'insertion des données s\'est mal passée';
            }
        }

        if (!empty($errorList)) {
            $teacher = new Teachers();
            $teacher->setFirstname($firstname);
            $teacher->setLastname($lastname);
            $teacher->setJob($job);
            $teacher->setStatus($status);

            $this->show('teachers/add', [
                'errorList' => $errorList,
                'teacher' => $teacher
            ]);
        }
    }

    /**
     * 
     * @return void
     * 
     */
    public function update($teacher_id)
    {

        $teacher = Teachers::find($teacher_id);

        $dataToDisplay = [
            'teacher' => $teacher,
        ];

        $this->show('teachers/update', $dataToDisplay);
    }

    /**
     * 
     * @return void
     * 
     */
    public function edit($teacher_id)
    {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $job = filter_input(INPUT_POST, 'job', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $teacher = Teachers::find($teacher_id);

        $teacher->setFirstname($firstname);
        $teacher->setLastname($lastname);
        $teacher->setJob($job);
        $teacher->setStatus($status);

        $errorList = [];
        if (empty($firstname)) {
            $errorList[] = 'Vous devez saisir un prénom';
        }
        if (empty($lastname)) {
            $errorList[] = 'Vous devez saisir un nom';
        }
        if (empty($job)) {
            $errorList[] = 'Vous devez saisir un poste';
        }
        if (empty($status)) {
            $errorList[] = 'Vous devez choisir un statut';
        }
        if (empty($errorList)) {
            $updated = $teacher->update();

            if ($updated) {
                global $router;
                $urlRedirect = $router->generate(
                    'teachers-list',
                    ['teacher_id' => $teacher_id]
                );
                header('Location: ' . $urlRedirect);
                return;
            } else {
                $errorList[] = 'L\'insertion des données s\'est mal passée';
            }
        }
        if (!empty($errorList)) {
            $this->show('teachers/update', [
                'errorList' => $errorList,
                'teacher' => $teacher
            ]);
        }
    }

    /**
     * Delete a teacher
     *
     * @param int $teacher_id
     * @return void
     */
    public function delete($teacher_id)
    {
        $teacher = Teachers::find($teacher_id);
        $queryExecuted  = $teacher->delete();
        if ($queryExecuted) {
            global $router;
            $urlLocation = $router->generate('teachers-list');
            header('Location: ' . $urlLocation);
        }
    }
}
