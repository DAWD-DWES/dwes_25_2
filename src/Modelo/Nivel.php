<?php

namespace App\modelo;

enum Nivel: string {

    case PRINCIPIANTE = 'Principiante';
    case INTERMEDIO = 'Intermedio';
    case AVANZADO = 'Avanzado';

    // Método para obtener un caso de enum por su valor asociado
    public static function fromString(string $value): self {
        return self::tryFrom($value) ?? throw new \InvalidArgumentException("Valor no válido para Nivel: $value");
    }
}
