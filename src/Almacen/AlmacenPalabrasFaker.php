<?php

namespace App\Almacen;

use App\Almacen\IAlmacenPalabras;
use Faker\Factory;
use Faker\Generator;

class AlmacenPalabrasFaker implements IAlmacenPalabras {

    /**
     * 
     * @var Faker Objeto de la librería Faker
     */
    private Generator $faker;

    /**
     * Constructor de la clase AlmacenPalabrasFaker
     * 
     * 
     * @returns AlmacenPalabrasFaker
     */
    public function __construct() {
        $this->faker = Factory::create('es_Es');
    }

    /**
     * Obtiene una palabra aleatoria
     * complejidad string Complejidad de la palabra. Ejemplo '0', '0-2'
     * 
     * @returns string Palabra aleatoria
     */
    public function obtenerPalabraAleatoria(): string {
        $palabra = ($this->faker)->word();
        return $this->eliminarTildes($palabra);
    }

    private function eliminarTildes(string $texto): string {
        return strtr($texto, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U'
        ]);
    }
}
