<?php

namespace App\DAO;

use PDO;
use App\Modelo\Usuario;

class UsuarioDAO {

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

    public function crea(Usuario $usuario) {
        
    }

    /**
     * Modifica un objeto usuario en la tabla usuarios
     * 
     * @param Usuario $usuario Usuario a persistir 
     * 
     * @returns bool Resultado de la operación de actualización
     */
    public function modifica($usuario) {
        $sql = "update usuarios set nombre = :nombre, clave = :clave, email = :email where id = :id";
        $sth = $this->bd->prepare($sql);
        $result = $sth->execute([":nombre" => $usuario->getNombre(), ":clave" => $usuario->getClave(), ":email" => $usuario->getEmail(), ":id" => $usuario->getId()]);
        return ($result);
    }

    public function elimina(int $id) {
        
    }

    /**
     * Recupera un objeto usuario dado su nombre de usuario y clave
     * 
     * @param string $nombre Nombre de usuario
     * @param string $pwd Clave del usuario
     * 
     * @returns Usuario que corresponde a ese nombre y clave o null en caso contrario
     */
    public function recuperaPorCredencial(string $nombre, string $pwd): ?Usuario {
        $sql = 'select * from usuarios where nombre=:nombre and clave=:pwd';
        $sth = $this->bd->prepare($sql);
        $sth->execute([":nombre" => $nombre, ":pwd" => $pwd]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
        $usuario = $sth->fetch();
        return ($usuario ?: null);
    }
}
