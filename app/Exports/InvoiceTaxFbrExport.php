<?php

namespace App\Exports;
use App\Models\Invoice;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoiceTaxFbrExport implements FromCollection,WithHeadings, WithMapping
{
    private $date = null;

    public function __construct($date){
        $this->date = $date;
    }
    public function collection()
    {
        return Invoice::with(['user'])->where('tax_paid', 0)->whereYear('created_at', date('Y',strtotime($this->date)))->whereMonth('created_at', date('m',strtotime($this->date)))->get();
    }

    public function headings(): array
    {
        return ["Payment Section", "TaxPayer_NTN", "TaxPayer_CNIC", "TAXPayer_NAME", "TaxPayer_City", "TaxPayer_Address", "TaxPayer _Satus", "TaxPayer_Business", "Taxable_Amount", "Tax_Amount"];
    }

    public function map($invoice): array
    {
        return [
            '236(1)(d)',
            $invoice->user->ntn,
            (is_null($invoice->user->ntn)) ? $invoice->user->nic : '',
            $invoice->user->name,
            'Hyderabad',
            'Hyderabad',
            $invoice->user->user_type,
            $invoice->user->business_name,
            $invoice->pkg_price+$invoice->sales_tax,
            $invoice->adv_inc_tax,
        ];
    }
}
