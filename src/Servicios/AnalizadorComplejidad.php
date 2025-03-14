<?php

namespace App\Servicios;

class AnalizadorComplejidad {
    /**
     * Determina la complejidad de una palabra.
     * @param string $palabra La palabra a analizar.
     * @return int Nivel de complejidad (0-4).
     */
    public function complejidadPalabra(string $palabra): int {
        $longitud = strlen($palabra);
        
        // Regla 0: 5 a 8 letras, contiene solo m, n, t, s, l, c, r, b, d, p y termina en ar, er o ir
        if ($longitud >= 5 && $longitud <= 8 && preg_match('/^[mntslcrbdpaeiou]+$/i', $palabra) && preg_match('/(ar|er|ir)$/i', $palabra)) {
            return 0;
        }
        
        // Regla 1: 1 a 8 letras sin secuencia de 2 o 3 vocales seguidas
        if ($longitud >= 1 && $longitud <= 8 && !preg_match('/[aeiou]{2,3}/i', $palabra)) {
            return 1;
        }
        
        // Regla 2: 1 a 8 letras que no cumplen las reglas 0 o 1
        if ($longitud >= 1 && $longitud <= 8) {
            return 2;
        }
        
        // Regla 3: Más de 8 letras sin z, x, q, k, h, y, w
        if ($longitud > 8 && !preg_match('/[zxqkhyw]/i', $palabra)) {
            return 3;
        }
        
        // Regla 4: Cualquier palabra que no cumpla las reglas anteriores
        return 4;
    }
}