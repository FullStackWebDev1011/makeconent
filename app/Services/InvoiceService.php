<?php

namespace App\Services;

use App\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZanySoft\Zip\Zip;

class InvoiceService
{
    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function generateBulkZip(Carbon $startDate, Carbon $endDate)
    {
        $zipName = 'invoices_'.$startDate->format('Y-m-d').'__'.$endDate->format('Y-m-d').'.zip';
//        $tmpFolder = sha1(rand(0, 9999999999));
        $tmpFolder = 'invoices';
        $tmpPath = $tmpFolder;

        Storage::disk('invoices')->deleteDirectory($tmpPath);

        Storage::disk('invoices')->makeDirectory($tmpPath);

//        Log::info('generateBulkZip $startDate='.$startDate.';$endDate='.$endDate);

        $this->invoice
            ->with('user')
            ->where('created_at', '>=', $startDate->startOfDay())
            ->where('created_at', '<=', $endDate->endOfDay())
            ->chunk(30, function ($invoices) use ($tmpPath) {
                foreach ($invoices as $invoice) {
                    $pdf = app()->make('dompdf.wrapper');
                    $pdf->loadView('pdf.invoice_new', ['invoice' => $invoice, 'user' => $invoice->user]);
                    $pdf->save(storage_path('pdf/'.$tmpPath.'/'.$invoice->id.'.pdf'));
                }
            });

        $zip = Zip::create(storage_path('pdf/'.$zipName));
        $zip->add(storage_path('pdf/'.$tmpPath.'/'));
        $zip->close();

        Storage::disk('invoices')->deleteDirectory($tmpPath);

        return [
            'path' => storage_path('pdf/'.$zipName),
            'name' => $zipName,
        ];
    }
}
