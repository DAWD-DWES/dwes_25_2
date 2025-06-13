<?php

namespace App\Modelo;

use App\Modelo\Nivel;

/**
 * Clase que representa al usuario que está usando la aplicación
 */
class Usuario {

    /**
     * @var string $id identificador del usuario
     */
    private string $id;

    /**
     * @var string $nombre nombre del usuario
     */
    private string $nombre;

    /**
     * @var string $clave Clave del usuario
     */
    private string $clave;

    /**
     * @var string $email Email del usuario
     */
    private ?string $email;

    /*
     * @var string $nivel Nivel del usuario
     */
    private string $nivel;

    /**
     * Constructor de la clase Usuario
     * 
     * @param string $nombre Nombre del usuario
     * @param string $clave Clave del usuario
     * @param string $email Email del usuario
     * @param string $nivel Nivel del usuario
     * 
     * @returns Usuario
     */
    public function __construct(string $nombre = null, string $clave = null, string $email = null, string $nivel = null) {
        if (func_num_args() > 0) {
            $this->nombre = $nombre;
            $this->clave = $clave;
            $this->email = $email;
            $this->nivel = $nivel ?? 'Principiante';
        }
    }

    /**
     * Recupera el Id del usuario
     * 
     * @returns int Id del usuario
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Recupera el nombre del usuario
     * 
     * @returns string Nombre del usuario
     */
    public function getNombre(): string {
        return $this->nombre;
    }

    /**
     * Establece el nombre del usuario
     * 
     * @param string $nombre Nombre del usuario
     * 
     * @returns void
     */
    public function setNombre(string $nombre) {
        $this->nombre = $nombre;
    }

    /**
     * Recupera la clave del usuario
     * 
     * @returns string Clave del usuario
     */
    public function getClave(): string {
        return $this->clave;
    }

    /**
     * Establece la clave del usuario
     * 
     * @param string $clave Clave del usuario
     * 
     * @returns void
     */
    public function setClave(string $clave) {
        $this->clave = $clave;
    }

    /**
     * Recupera el email del usuario
     * 
     * @returns string Email del usuario
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * Establece el email del usuario
     * 
     * @param string $email Email del usuario
     * 
     * @returns void
     */
    public function setEmail(string $email) {
        $this->email = $email;
    }
    
    /**
     * Recupera el nivel del usuario
     * 
     * @returns string Nivel del usuario
     */
    public function getNivel(): string {
        return $this->nivel;
    }

    /**
     * Establece el Nivel del usuario
     * 
     * @param string $nivel Nivel del usuario
     * 
     * @returns void
     */
    public function setNivel(string $nivel) {
        $this->nivel = $nivel;
    }
}
