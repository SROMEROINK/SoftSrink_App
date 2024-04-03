<?php

namespace App\Models\Fabricacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Listado_de_OF\Listado_OF;
use App\Models\Productos\Producto;

class Registro_de_Fabricacion extends Model
{
    use HasFactory;
    protected $table = 'registro_de_fabricacion';
    protected $primaryKey = 'Id_OF';
    protected $fillable = [

    "Id_OF",
    "Nro_OF",
    "Id_Producto",
    "Nro_Parcial",
    "Cant_Piezas",
    "Fecha_Fabricacion",
    "Horario",
    "Nombre_Operario",
    "Turno",
    "Cant_Horas_Extras",
    "Total_Mts_MP",
    "Precio_Unitario_Pieza",
    "Total_Fabricado_ARS",
    "Ultima_Carga",
    "Status_OF"
];

public $timestamps = false;

public function listado_of()
{
    // La clave foránea en Listado_OF: 'Producto_Id'
    // La clave primaria en producto: 'Id_Producto'
    return $this->belongsTo(Listado_OF::class, 'Nro_OF','Id_OF'); // Cambia el nombre del modelo a Producto y especifica correctamente el namespace
}


}
