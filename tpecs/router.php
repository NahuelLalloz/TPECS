<?php
require_once '../tpecs/app/controllers/equipocontroller.php';
require_once '../tpecs/app/controllers/jugadorescontroller.php';
require_once '../tpecs/app/controllers/logincontroller.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$action = 'home';

if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

switch ($params[0]) {
    case 'home':
        $equipoController = new EquipoController();
        $equipoController->showEquipos();
        $controller = new JugadorController();
        $controller->showJugador();
        break;

    case 'viewEquipo':

        $controller = new EquipoController();
        $controller->showEquipos($params[1]);
        break;

    case 'viewEquipoDetalle':

        $controller = new EquipoController();
        $controller->showEquipoDetalles($params[1]);
        break;
    case 'agregar':

        $controller = new EquipoController();
        $controller->addEquipo();
        break;
    case 'delete':
        $controller = new EquipoController();
        $controller->deleteEquipo($params[1]);
        break;

    case 'updateEquipo':

        $controller = new EquipoController();
        $controller->updateEquipo();
        break;
    case 'auth':
        $controller = new LoginController();
        $controller->checkLogin();
    case 'login':
        $controller = new LoginController();
        $controller->showLogin();
        break;

    case 'logout':
        $controller = new LoginController();
        $controller->logout();
        break;
    case 'viewJugadorDetalle':
        $controller = new JugadorController();
        $controller->showJugadorDetalle($params[1]);
        break;
    case 'deleteJugadorID':
        $controller = new JugadorController();
        $controller->deleteJugador($params[1]);
        break;
    case 'agregarJugador':
        $controller = new JugadorController();
        $controller->addJugador();
        break;
    case 'updateJugador':
        $controller = new JugadorController();
        $controller->updateJugador($params[1]);
        break;
    default:
        echo ('404 Page not found');
        break;
}
