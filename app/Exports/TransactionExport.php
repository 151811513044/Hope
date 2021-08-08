<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExport implements FromView
{
    private $_results;

    /**
     * Create a new exporter instance.
     *
     * @param array $results query result
     *
     * @return void
     */
    public function __construct($results)
    {
        $this->_results = $results;
    }

    /**
     * Load the view.
     *
     * @return void
     */
    public function view(): View
    {
        $total = 0;
        foreach ($this->_results as $td) {
            $total += $td->total_harga;
        }
        return view(
            'admin.laporan.transaction_xlsx',
            [
                'total' => $total,
                'transaction_detail' => $this->_results,
            ]
        );
    }
}
