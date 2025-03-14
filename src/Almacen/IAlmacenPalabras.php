<?php

namespace App\Almacen;

/*
 * Interface que representa la funcionalidad pública de un almacén de palabras
 */

interface IAlmacenPalabras {

    /**
     * Obtiene una palabra aleatoria
     * $complejidad int Complejidad de la palabra (escala 0..4)
     * 
     * @returns string Palabra aleatoria
     */
    public function obtenerPalabraAleatoria(): string;
}
