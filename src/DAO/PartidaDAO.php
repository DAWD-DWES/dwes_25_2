<?php

namespace App\DAO;

use PDO;
use App\Modelo\Partida;

class PartidaDAO {

    /**
     * @var $bd Conexión a la Base de Datos
     */
    private PDO $bd;

    /**
     * Constructor de la clase UsuarioDAO
     * 
     * @param PDO $bd Conexión a la base de datos
     * 
     * @returns UsuarioDAO
     */
    public function __construct(PDO $bd) {
        $this->bd = $bd;
    }

    public function crea(Partida $partida): bool {
        $sql = "INSERT INTO partidas (numErrores, palabraSecreta, palabraDescubierta, letras, maxNumErrores, inicio, fin, complejidad, idUsuario) VALUES (:numErrores, :palabraSecreta, :palabraDescubierta, :letras, :maxNumErrores, FROM_UNIXTIME(:inicio), FROM_UNIXTIME(:fin), :complejidad, :idUsuario)";
        $stmt = $this->bd->prepare($sql);

        // Creando un array de parámetros
        $params = [
            ':numErrores' => $partida->getNumErrores(),
            ':palabraSecreta' => $partida->getPalabraSecreta(),
            ':palabraDescubierta' => $partida->getPalabraDescubierta(),
            ':letras' => $partida->getLetras(),
            ':maxNumErrores' => $partida->getMaxNumErrores(),
            ':inicio' => $partida->getInicio()->getTimestamp(),
            ':fin' => $partida->getFin() ? $partida->getFin()->getTimestamp() : null,
            ':complejidad' => $partida->getComplejidad(),
            ':idUsuario' => $partida->getIdUsuario()
        ];
        $result = $stmt->execute($params);
        return ($result ? $this->bd->lastInsertId() : false);
    }

    public function modifica(Partida $partida): bool {
        $sql = "UPDATE partidas SET numErrores = :numErrores, palabraDescubierta = :palabraDescubierta, letras = :letras, inicio = FROM_UNIXTIME(:inicio), fin = FROM_UNIXTIME(:fin), complejidad = :complejidad  WHERE id = :id";
        $stmt = $this->bd->prepare($sql);

        // Creando un array de parámetros
        $params = [
            ':id' => $partida->getId(),
            ':numErrores' => $partida->getNumErrores(),
            ':palabraDescubierta' => $partida->getPalabraDescubierta(),
            ':letras' => $partida->getLetras(),
            ':inicio' => $partida->getInicio()->getTimestamp(),
            ':fin' => $partida->getFin() ? $partida->getFin()->getTimestamp() : null
        ];

        $result = $stmt->execute($params);
        return $result;
    }

    public function elimina(int $id): bool {
        
    }
}
