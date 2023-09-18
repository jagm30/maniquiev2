<?php

namespace App\Exports;

use App\Grupoalumno;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class GrupoalumnosExportView implements FromView
{
	use Exportable;
	protected $grupoalumnos;
 
    public function __construct($grupoalumnos = null)
    {
        $this->grupoalumnos = $grupoalumnos;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('./grupoalumnos.table', [
            'grupoalumnos' => $this->grupoalumnos ?: Grupoalumno::all()
        ]);


    }
}