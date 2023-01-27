<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignaturas extends Model
{
    `id` int(255) NOT NULL,
    `profesor_id` int(255) NOT NULL,
    `seccion_id` int(255) NOT NULL,
    `carrera_id` int(255) NOT NULL,
    `horario_id` int(255) NOT NULL,
    `nombre` varchar(255) NOT NULL,
    `unidades_credito` int(10) DEFAULT NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL
    use HasFactory;
}
