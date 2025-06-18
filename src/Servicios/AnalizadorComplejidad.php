<?php

namespace App\Servicios;

class AnalizadorComplejidad {

    /**
     * Determina la complejidad de una palabra.
     * @param string $palabra La palabra a analizar.
     * @return int Nivel de complejidad (0-4).
     */
    function complejidadPalabra2(string $palabra): int {
        $palabraArray = str_split($palabra);
        $longitud = strlen($palabra);
        if ($longitud > 8) {
            if (array_intersect($palabraArray, str_split('ZXQKHYW'))) {
                $resultado = 4;
            } else {
                $resultado = 3;
            }
        } else {
            $palabraUnicas = array_unique($palabraArray);
            if (($longitud >= 5) && (count(array_intersect($palabraUnicas, str_split('MNTSLCRBDPAEIOU'))) == count($palabraUnicas)) &&
                    (substr($palabra, -2) == 'AR' || substr($palabra, -2) == 'ER' || substr($palabra, -2) == 'IR')) {
                $resultado = 0;
            } elseif ($longitud >= 1 && $longitud <= 8) {
                foreach (str_split('AEIOU') as $vocal1) {
                    foreach (str_split('AEIOU') as $vocal2) {
                        $vocales[] = $vocal1 . $vocal2;
                    }
                }
                if (array_filter($vocales, fn($x) => strpos($palabra, $x) !== false)) {
                    $resultado = 2;
                } else {
                    $resultado = 1;
                }
            }
        }
        return $resultado;
    }

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
            // Regla 4: Cualquier palabra que no cumpla las reglas anteriores
            default => 4
        };
        return $resultado;
    }
}
