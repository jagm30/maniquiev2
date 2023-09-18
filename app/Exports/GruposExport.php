<?php

namespace App\Exports;

use App\Grupo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class GruposExport implements FromCollection
{
	use Exportable;
	protected $grupos;
 
    public function __construct($grupos = null)
    {
        $this->grupos = $grupos;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->grupos ?: Grupo::all();
    }
}
