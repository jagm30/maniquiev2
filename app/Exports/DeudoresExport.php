<?php

namespace App\Exports;

use App\Cobro;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class DeudoresExport implements FromView
{
	use Exportable;
	protected $deudores;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($deudores = null, $fecha_actual = null)
    {
        $this->deudores 	= $deudores;
        $this->fecha_actual = $fecha_actual;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('./cobros.deudoresexcel', [
            'deudores' => $this->deudores ?: Cobro::all(),
            'fecha_actual' => $this->fecha_actual
        ]);
    }
}
