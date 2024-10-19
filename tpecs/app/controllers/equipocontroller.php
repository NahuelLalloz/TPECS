<?php
include_once "app/models/equipomodel.php";
include_once 'app/views/equipoview.php';

class EquipoController
{
    private $model;
    private $view;

    function __construct()
    {
        $this->model = new EquipoModel();
        $this->view = new EquipoView();
    }

    public function showEquipos()
    {
        $equipos = $this->model->getEquipos();
        $this->view->showEquipos($equipos);
    }

    public function showEquipoDetalles($id_equipo)
    {

        $equipo = $this->model->getEquipoById($id_equipo);

        if ($equipo) {

            $jugadores = $this->model->getEquipoAndJugador($id_equipo);

            $equipo->jugadores = $jugadores;

            $this->view->showEquiposDetalles($equipo);
        } else {

            $this->view->showError('Equipo no encontrado');
        }
    }
    public function addEquipo()
    {
        $nombre_equipo = $_POST['nombre_equipo'];
        $ranking = $_POST['ranking'];
        $region = $_POST['region'];

        try {
            if (empty($nombre_equipo) || empty($ranking) ||  empty($region)) {
                $this->view->showError("Debe completar todos los campos");
                return;
            }

            if ($this->model->existsEquipo($nombre_equipo, $ranking)) {
                $this->view->showError("El nombre del equipo o el ranking ya están en uso.");
                return;
            }

            $result = $this->model->insertEquipo($nombre_equipo, $ranking, $region);
            if ($result !== false) {
                header("Location: " . BASE_URL . "home");
                exit();
            }
        } catch (PDOException $e) {
            $this->view->ShowErrorDuplicado("Ocurrió un error durante el proceso.");
        }
    }
    function deleteEquipo($id_equipo)
    {
        $this->model->deleteEquipoById($id_equipo);
        $this->view->ShowHomeLocation();
    }
    function updateEquipo()
    {
        $id_equipo = $_POST['id_equipo'];
        $nombre_equipo = $_POST['nombre_equipo'];
        $ranking = $_POST['ranking'];
        $region = $_POST['region'];


        try {
            if (empty($nombre_equipo) || empty($ranking) ||  empty($region) || empty($id_equipo)) {
                $this->view->showError("Debe completar todos los campos");
                return;
            }

            $this->model->updateEquipo($id_equipo, $nombre_equipo, $ranking, $region);
            $this->view->ShowHomeLocation();
        } catch (PDOException $e) {
            header("refresh:10;url=" . BASE_URL . "home");
            $this->view->ShowErrorDuplicado("Redireccion");
        }
    }
}
