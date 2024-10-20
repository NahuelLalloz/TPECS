<?php

include_once "app/models/jugadormodel.php";
include_once "app/models/equipomodel.php";
include_once 'app/views/jugadorview.php';
class JugadorController
{
    private $view;
    private $model;
    private $modelc;
    private $viewc;

    function __construct()
    {
        $this->modelc = new EquipoModel();
        $this->model = new JugadorModel();
        $this->view = new JugadorView();
    }


    public function showJugador()
    {
        $jugadores = $this->model->getJugadores();
        $equipos = $this->modelc->getEquipos();
        $this->view->showJugadores($jugadores, $equipos);
    }

    public function showJugadorDetalle($id_jugador)
    {
        $jugador = $this->model->getJugadorById($id_jugador);

        if ($jugador) {
            $this->view->viewJugador($jugador);
        } else {
            $this->view->showError('Jugador no encontrado');
        }
    }

    public function deleteJugador($id_jugador)
    {
        $this->model->deleteJugador($id_jugador);
        $this->view->ShowHomeLocation();
    }
    public function addJugador()
    {
        $nombre_jugador = $_POST['nombre_jugador'];
        $posicion = $_POST['posicion'];
        $kd = $_POST['kd'];
        $fk_equipo = $_POST['fk_equipo'];

        try {
            if (empty($nombre_jugador) ||  empty($posicion) ||  empty($kd) || empty($fk_equipo)) {
                return $this->view->showError('debe completar todos los datos');
            }
            if ($this->model->existsJugador($nombre_jugador)) {
                $this->view->showError("El nombre del jugador ya esta en uso.");
                return;
            }
            $result = $this->model->insertJugador($nombre_jugador, $posicion, $kd, $fk_equipo);
            if (!$result) {
                return $this->view->showError(500);
            }

            if ($result) {
                header("Location: " . BASE_URL . "home");
            }
        } catch (PDOException $e) {
            header("refresh:10;url=" . BASE_URL . "home");
            $this->view->ShowHomeLocation("Redireccion");
        }
    }
    public function updateJugador($id_jugador)
    {
        $id_jugador = $this->model->getJugadorById($id_jugador);

        $id_jugador = $_POST['id_jugador'];
        $nombre_jugador = $_POST['nombre_jugador'];
        $posicion = $_POST['posicion'];
        $kd = $_POST['kd'];
        $fk_equipo = $_POST['fk_equipo'];


        if (empty($id_jugador) || empty($nombre_jugador) || empty($posicion) || empty($kd) || empty($fk_equipo)) {
            return $this->view->showError('debe completar todos los datos');
        }
        $this->model->updateJugador($id_jugador, $nombre_jugador, $posicion, $kd, $fk_equipo);
        header("Location: " . BASE_URL . "home");
    }
}
