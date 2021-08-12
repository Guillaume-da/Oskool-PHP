<?php

namespace App\Controllers;

class CoreController
{
    /**
     * 
     * @return void
     * 
     */
    public function __construct()
    {
        global $match;
        $currentRoute = $match['name'];
        $acl =  [
            'main-home' => ['admin', 'user'],
            'students-list' => ['admin', 'user'],
            'students-add' => ['admin', 'user'],
            'teachers-list' => ['admin', 'user'],
            'teachers-add' => ['admin'],
            'teachers-update' => ['admin'],
            'appusers-list' => ['admin'],
        ];
        if (array_key_exists($currentRoute, $acl)) {
            $authorisedRoles = $acl[$currentRoute];
            $this->checkAuthorisation($authorisedRoles);
        }
    }

    /**
     * 
     * @param string $viewName
     * @param array $viewVars
     * @return void
     * 
     */
    protected function show(string $viewName, $viewVars = [])
    {
        global $router;
        $viewVars['currentPage'] = $viewName;
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];
        extract($viewVars);
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }

    /**
     *
     * @param Array $listRoles
     * @return Bool
     * 
     */
    public function checkAuthorisation($listRoles)
    {
        global $router;
        if (isset($_SESSION['userId'])) {
            $currentUser = $_SESSION['userObject'];
            $currentRole = $currentUser->getRole();
            if (in_array($currentRole, $listRoles)) {
                return true;
            } else {
                http_response_code(403);
                $this->show('error/err403');
                exit();
            }
        } else {
            header('Location: ' . $router->generate('users-login'));
            exit();
        }
    }
}
