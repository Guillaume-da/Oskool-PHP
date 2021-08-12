<?php

namespace App\Controllers;

use App\Models\AppUser;

class UserController extends CoreController
{

    /**
     * Login form
     *
     * @return void
     * 
     */
    public function login()
    {
        $this->show('users/login', []);
    }

    /**
     * Login form validation
     *
     * @return void
     * 
     */
    public function validate()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $errorList = [];
        if (empty($email)) {
            $errorList[] = 'Merci de saisir un Email';
        }
        if (empty($password)) {
            $errorList[] = 'Merci de saisir un mot de passe';
        }

        if (empty($errorList)) {
            $currentUser = AppUser::findByEmail($email);
            if ($currentUser) {
                global $router;
                if (password_verify($password, $currentUser->getPassword())) {
                    $_SESSION['userId'] = $currentUser->getId();
                    $_SESSION['userObject'] = $currentUser;
                    header('Location: ' . $router->generate('main-home'));
                } else {
                    $errorList[] = 'Email ou mot de passe invalide';
                }
            } else {
                $errorList[] = 'Email ou mot de passe invalide';
            }
        }

        if (!empty($errorList)) {
            $this->show('users/login', [
                'errorList' => $errorList
            ]);
        }
    }

    /**
     * Logout
     *
     * @return void
     * 
     */
    public function logout()
    {
        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);
        global $router;
        header('Location: ' . $router->generate('users-login'));
        exit();
    }

    public function add()
    {
        $this->show('users/add', [
            'user' => new AppUser(),
        ]);
    }

    /**
     * Teacher addform
     * URL : /teachers/add
     * 
     * @return void
     * 
     */
    public function newAppUser()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $errorList = [];
        if (empty($email)) {
            $errorList[] = 'Vous devez saisir un email';
        }
        if (empty($name)) {
            $errorList[] = 'Vous devez saisir un nom';
        }
        if (empty($password)) {
            $errorList[] = 'Vous devez saisir un mot de passe';
        }
        if (empty($role)) {
            $errorList[] = 'Vous devez saisir un rôle';
        }

        if (empty($errorList)) {
            $user = new AppUser();
            $user->setEmail($email);
            $user->setName($name);
            $user->setPassword($password);
            $user->setRole($role);
            $user->setStatus($status);

            $inserted = $user->create();

            if ($inserted) {
                global $router;
                header('Location: ' . $router->generate('appusers-list'));
                return;
            } else {
                $errorList[] = 'L\'insertion des données s\'est mal passée';
            }
        }

        if (!empty($errorList)) {
            $user = new AppUser();
            $user->setEmail($email);
            $user->setName($name);
            $user->setPassword($password);
            $user->setRole($role);
            $user->setStatus($status);

            $this->show('users/add', [
                'errorList' => $errorList,
                'user' => $user
            ]);
        }
    }

    /**
     * AppUsers list
     * 
     * @return void
     * 
     */
    public function appUsersList()
    {
        $users = AppUser::findAll();
        $dataToDisplay = [
            'users' => $users
        ];
        $this->show('users/list', $dataToDisplay);
    }

    public function update($user_id)
    {
        $appuser = AppUser::find($user_id);
        $dataToDisplay = [
            'appuser' => $appuser,
        ];

        $this->show('users/update', $dataToDisplay);
    }

    /**
     * 
     * @param $user_id
     * @return void
     * 
     */
    public function edit($user_id)
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $user = AppUser::find($user_id);

        $user->setEmail($email);
        $user->setName($name);
        $user->setPassword($password);
        $user->setRole($role);
        $user->setStatus($status);

        $errorList = [];
        if (empty($email)) {
            $errorList[] = 'Vous devez saisir un email';
        }
        if (empty($name)) {
            $errorList[] = 'Vous devez saisir un nom';
        }
        if (empty($role)) {
            $errorList[] = 'Vous devez choisir un rôle';
        }
        if (empty($status)) {
            $errorList[] = 'Vous devez choisir un statut';
        }

        if (empty($errorList)) {
            $updated = $user->update();

            if ($updated) {
                global $router;
                $urlRedirect = $router->generate(
                    'appusers-list',
                    ['user_id' => $user_id]
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
                'user' => $user
            ]);
        }
    }

    /**
     * 
     * @param $id
     * @return void
     * 
     */
    public function delete($id)
    {
        $user = AppUser::find($id);
        $queryExecuted = $user->delete();
        if ($queryExecuted) {
            global $router;
            $urlLocation = $router->generate('appusers-list');
            header('Location: ' . $urlLocation);
        }
    }
}
