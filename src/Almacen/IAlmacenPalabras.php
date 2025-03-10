<?php

namespace App\Almacen;

/*
 * Interface que representa la funcionalidad pública de un almacén de palabras
 */

interface IAlmacenPalabras {

    /**
     * Obtiene una palabra aleatoria
     * 
     * 
     * @returns string Palabra aleatoria
     */
    public function obtenerPalabraAleatoria(): string;
}

