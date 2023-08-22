<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithTitle;
// use Maatwebsite\Excel\Concerns\WithDrawings;
// use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use App\Exports\Sheets\ExportMHOneDayCN;
use App\Exports\Sheets\ExportSuppOneDayCN;




class PendingOneDayExportCN implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $date;
	protected $pending_preshipment;
	// protected $subcon_employees;
	// protected $pmi_employees_per_section;
	// protected $subcon_employees_per_section;
    // protected $suspected_employees;

    function __construct($date, $pending_preshipment)
    {
        $this->date = $date;
		$this->pending_preshipment = $pending_preshipment;
	
    }

    //for multiple sheets
    public function sheets(): array
    {
        $sheets = [];
        

    	$sheets[] = new ExportMHOneDayCN($this->date, $this->pending_preshipment['mh_1day_only_cn']);
    	$sheets[] = new ExportSuppOneDayCN($this->date, $this->pending_preshipment['supp_1day_only_cn']);
        // $sheets[] = new PMIRecordsSheet($this->date, $this->subcon_employees, 'SUBCON EMPLOYEES', 1);
    	// $sheets[] = new PMIRecordsPerSectionSheet($this->date, $this->subcon_employees_per_section, 'SUBCON EMPLOYEES PER SECTION', 1);
        // $sheets[] = new PMISuspectedEmployeesSheet($this->date, $this->suspected_employees, 'COVID-19 SUSPECTED EMPLOYEES');
    	// $sheets[] = new PMIPresentEmployeesWithoutCHASSheet($this->date, $this->present_employees_without_chas, 'PRESENT EMPLOYEES WITHOUT CHAS');
    	
        return $sheets;
    }



    // public function view(): View {
       
    //     return view('exports.pending_preshipment', ['date' => $this->date, 'pending_preshipments' => $this->pending_preshipment]);
    
    // }

    // public function title(): string
    // {
    //     return 'Pending Preshipment';
    // }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function(AfterSheet $event) {
              
    //         },
    //     ];
    // }
}
