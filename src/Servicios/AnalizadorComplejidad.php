<?php

namespace App\Servicios;

class AnalizadorComplejidad {

    /**
     * Determina la complejidad de una palabra.
     * @param string $palabra La palabra a analizar.
     * @return int Nivel de complejidad (0-4).
     */
    /*  function complejidadPalabra(string $palabra): int {
        $palabraArray = str_split($palabra);
        $longitud = strlen($palabra);
        if ($longitud > 8) {
            if (array_intersect($palabraArray, str_split('zxqkhyw'))) {
                $resultado = 4;
            } else {
                $resultado = 3;
            }
        } else {
            if (($longitud >= 5) && (count(array_intersect($palabraArray, str_split('mntslcrbdpaeiou'))) == count($palabraArray)) &&
                    (substr($palabra, -2) == 'ar' || substr($palabra, -2) == 'er' || substr($palabra, -2) == 'ir')) {
                $resultado = 0;
            } elseif ($longitud >= 1 && $longitud <= 8) {
                foreach (str_split('aeiou') as $vocal1) {
                    foreach (str_split('aeiou') as $vocal2) {
                        $vocales[] = $vocal1 . $vocal2;
                    }
                }
                if (array_filter(fn($x) => strpos($palabra, $x) !== false, $vocales)) {
                    $resultado = 1;
                } else {
                    $resultado = 2;
                }
            }
        }
        return $resultado;
    }
     */

    function complejidadPalabra(string $palabra): int {
        $longitud = strlen($palabra);
        $resultado = match (true) {
        // Regla 0: 5 a 8 letras, contiene solo m, n, t, s, l, c, r, b, d, p y termina en ar, er o ir
            ($longitud >= 5 && $longitud <= 8 && preg_match('/^[mntslcrbdpaeiou]+(ar|er|ir)$/i', $palabra)) => 0,
            // Regla 1: 1 a 8 letras sin secuencia de 2 vocales seguidas
            ($longitud >= 1 && $longitud <= 8 && !preg_match('/[aeiou]{2}/i', $palabra)) => 1,
            // Regla 2: 1 a 8 letras que no cumplen las reglas 0 o 1
            ($longitud >= 1 && $longitud <= 8) => 2,
            // Regla 3: Más de 8 letras sin z, x, q, k, h, y, w
            ($longitud > 8 && !preg_match('/[zxqkhyw]/i', $palabra)) => 3,
            default => 4
        };
        // Regla 4: Cualquier palabra que no cumpla las reglas anteriores
        return $resultado;
    }
}
