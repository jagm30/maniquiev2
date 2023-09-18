<?php

namespace App\Exports;

use App\Grupoalumno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;


class GrupoalumnosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
	protected $grupoalumnos;
 
    public function __construct($grupoalumnos = null)
    {
        $this->grupoalumnos = $grupoalumnos;
    }

    public function collection()
    {
        return $this->grupoalumnos ?:Grupoalumno::all();
    }
}
