<?php
require_once 'app/models/config.php';
class JugadorModel
{

    private $db;

    function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=cstpe;charset=' . DB_Charset, DB_USER, DB_PASS);
    }
    function getJugadores()
    {
        $query = $this->db->prepare('SELECT * FROM jugadores');
        $query->execute();
        $jugadores = $query->fetchAll(PDO::FETCH_OBJ);
        return $jugadores;
    }

    function getJugadorById($id_jugador)
    {

        $query = $this->db->prepare('SELECT * FROM jugadores WHERE id_jugador = ?');
        $query->execute([$id_jugador]);
        $jugadores = $query->fetchAll(PDO::FETCH_OBJ);
        return $jugadores;
    }
    function deleteJugador($id_jugador)
    {
        $query = $this->db->prepare('DELETE FROM jugadores WHERE id_jugador = ?');
        $query->execute([$id_jugador]);
    }

    function insertJugador($nombre_jugador, $posicion, $kd, $fk_equipo)
    {
        $query = $this->db->prepare('INSERT INTO jugadores(nombre_jugador, posicion, kd, fk_equipo) VALUES ( ?, ?, ?, ?)');
        $query->execute([$nombre_jugador, $posicion, $kd, $fk_equipo]);
        return $this->db->lastInsertId();
    }
    function updateJugador($id_jugador, $nombre_jugador, $posicion, $kd, $fk_equipo)
    {
        $query = $this->db->prepare('UPDATE jugadores SET nombre_jugador=?, posicion=?, kd=?, fk_equipo=?  WHERE id_jugador = ?');
        $query->execute([$nombre_jugador, $posicion, $kd, $fk_equipo, $id_jugador]);
    }
    public function finalize($id_jugador)
    {
        $query = $this->db->prepare('UPDATE jugadores SET finalizada = 1 WHERE id_jugador = ?');
        $query->execute([$id_jugador]);
    }

    function getJugadoresByEquipo($nombre_equipo)
    {
        $query = $this->db->prepare("
            SELECT jugadores.*, equipos.nombre_equipo AS equipo
            FROM jugadores
            INNER JOIN equipos ON jugadores.fk_equipo = equipos.id_equipo
            WHERE equipos.nombre_equipo = ?
        ");
        $query->execute([$nombre_equipo]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
