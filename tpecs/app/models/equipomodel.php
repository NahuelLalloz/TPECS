<?php
require_once 'app/models/config.php';
class EquipoModel extends Model
{


    function __construct()
    {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=cstpe;charset=' . DB_Charset, DB_USER, DB_PASS);
    }

    function getEquipos()
    {
        $query = $this->db->prepare('SELECT * FROM `equipos`');



        $query->execute();

        $equipos = $query->fetchAll(PDO::FETCH_OBJ);

        return $equipos;
    }
    function getEquiposDetalle()
    {
        $query = $this->db->prepare('SELECT id_equipo, nombre_equipo, ranking, region FROM equipos');

        $query->execute();

        $equipos = $query->fetchAll(PDO::FETCH_OBJ);

        return $equipos;
    }


    public function getEquipoById($id_equipo)
    {
        $query = $this->db->prepare('SELECT * FROM equipos WHERE id_equipo = :id_equipo');
        $query->bindParam(':id_equipo', $id_equipo, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function getJugadorById($idJugador)
    {
        $query = $this->db->prepare('
        SELECT jugadores.*, equipos.nombre_equipo
        FROM jugadores
        INNER JOIN equipos ON jugadores.fk_equipo = equipos.id_equipo
        WHERE jugadores.id_jugador = ?
    ');
        $query->execute([$idJugador]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    public function insertEquipo($nombre_equipo, $ranking, $region, $imagenURL)
    {
        $query = $this->db->prepare("INSERT INTO equipos (nombre_equipo, ranking, region, imagen_url) VALUES (?, ?, ?, ?)");
        $query->execute([$nombre_equipo, $ranking, $region, $imagenURL]);

        return $this->db->lastInsertId();
    }
    function deleteEquipoById($id_equipo)
    {
        $query = $this->db->prepare('DELETE FROM equipos WHERE id_equipo = ?');
        $query->execute([$id_equipo]);
    }
    public function existsEquipo($nombre_equipo, $ranking)
    {
        $query = $this->db->prepare('SELECT COUNT(*) FROM equipos WHERE nombre_equipo = ? OR ranking = ?');
        $query->execute([$nombre_equipo, $ranking]);


        return $query->fetchColumn() > 0;
    }
    public function updateEquipo($id_equipo, $nombre_equipo, $ranking, $region)
    {

        $query = $this->db->prepare('UPDATE equipos SET nombre_equipo = ?, ranking = ?, region = ? WHERE id_equipo = ?');

        $query->execute([$nombre_equipo, $ranking, $region, $id_equipo]);
    }
    public function getEquipoAndJugador($idEquipo)
    {
        $query = $this->db->prepare('SELECT equipos.*, jugadores.nombre_jugador
        FROM equipos
        INNER JOIN jugadores ON jugadores.fk_equipo = equipos.id_equipo
        WHERE equipos.id_equipo = ?');
        $query->execute([$idEquipo]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
