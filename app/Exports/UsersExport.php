<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select(
            'id', 'name', 'apellido_paterno', 'apellido_materno',
            'nacionalidad', 'sexo', 'estado_civil', 'fecha_nacimiento',
            'telefono', 'direccion', 'tipo_origen', 'dni', 'email'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Nombre', 'Apellido Paterno', 'Apellido Materno',
            'Nacionalidad', 'Sexo', 'Estado Civil', 'Fecha Nacimiento',
            'Teléfono', 'Dirección', 'Tipo Origen', 'DNI', 'Email'
        ];
    }
}
