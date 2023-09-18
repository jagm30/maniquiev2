<?php

namespace App\Exports;

use App\Cobro;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class CobrosExportView implements FromView
{
	use Exportable;
	protected $cobros;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($cobros = null)
    {
        $this->cobros = $cobros;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('./cobros.table', [
            'cobros' => $this->cobros ?: Cobro::all()
        ]);
    }
}
