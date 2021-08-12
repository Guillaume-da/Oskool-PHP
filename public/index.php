<?php
require_once '../vendor/autoload.php';

session_start();
$router = new AltoRouter();
if (array_key_exists('BASE_URI', $_SERVER)) {
    $router->setBasePath($_SERVER['BASE_URI']);
}
else {
    $_SERVER['BASE_URI'] = '/';
}

/**=====================
 * General
 *=======================*/

$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController'
    ],
    'main-home'
);

$router->map(
    'GET',
    '/signin',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\UserController'
    ],
    'users-login'
);


$router->map(
    'POST',
    '/signin',
    [
        'method' => 'validate',
        'controller' => '\App\Controllers\UserController'
    ],
);

$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\UserController'
    ],
    'users-logout'
);


/**=====================
 * AppUsers
 *=======================*/


$router->map(
    'GET',
    '/appusers',
    [
        'method' => 'appUsersList',
        'controller' => '\App\Controllers\UserController'
    ],
    'appusers-list'
);

$router->map(
    'GET',
    '/appusers/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\UserController'
    ],
    'appusers-add'
);

$router->map(
    'POST',
    '/appusers/add',
    [
        'method' => 'newAppuser',
        'controller' => '\App\Controllers\UserController'
    ],
);

$router->map(
    'GET',
    '/appusers/[i:user_id]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\UserController'
    ],
    'appusers-update'
);

$router->map(
    'POST',
    '/appusers/[i:suser_id]',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\UserController'
    ],
);

$router->map(
    'GET',
    '/appusers/[i:user_id]/delete/',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\UserController'
    ],
    'user-delete'
);


/**=====================
 * Teachers
 *=======================*/

$router->map(
    'GET',
    '/teachers',
    [
        'method' => 'teachersList',
        'controller' => '\App\Controllers\TeachersController'
    ],
    'teachers-list'
);

$router->map(
    'POST',
    '/teachers',
    [
        'method' => 'teachersList',
        'controller' => '\App\Controllers\TeachersController'
    ],
);

$router->map(
    'GET',
    '/teachers/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\TeachersController'
    ],
    'teachers-add'
);

$router->map(
    'POST',
    '/teachers/add',
    [
        'method' => 'newTeacher',
        'controller' => '\App\Controllers\TeachersController'
    ],
);

$router->map(
    'GET',
    '/teachers/[i:teacher_id]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\TeachersController'
    ],
    'teachers-update'
);

$router->map(
    'POST',
    '/teachers/[i:teacher_id]',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\TeachersController'
    ],
);

$router->map(
    'GET',
    '/teachers/[i:teacher_id]/delete/',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\TeachersController'
    ],
    'teacher-delete'
);


/**=====================
 * Students
 *=======================*/

$router->map(
    'GET',
    '/students',
    [
        'method' => 'studentsList',
        'controller' => '\App\Controllers\StudentsController'
    ],
    'students-list'
);

$router->map(
    'POST',
    '/students',
    [
        'method' => 'studentsList',
        'controller' => '\App\Controllers\StudentsController'
    ],
);

$router->map(
    'GET',
    '/students/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\StudentsController'
    ],
    'students-add'
);

$router->map(
    'POST',
    '/students/add',
    [
        'method' => 'newStudent',
        'controller' => '\App\Controllers\StudentsController'
    ],
);

$router->map(
    'GET',
    '/students/[i:student_id]',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\StudentsController'
    ],
    'students-update'
);

$router->map(
    'POST',
    '/students/[i:student_id]',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\StudentsController'
    ],
);


$router->map(
    'GET',
    '/students/[i:student_id]/delete/',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\StudentsController'
    ],
    'student-delete'
);


$match = $router->match();
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
$dispatcher->dispatch();