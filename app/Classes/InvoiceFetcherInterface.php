<?php

namespace App\Classes;

use Carbon\Carbon;
use App\Models\Sale;

abstract class InvoiceFetcherInterface {

    public Carbon $lastFetch;

    public function __construct() {
        $last_sale_date = Sale::orderByDesc('date')->first()->date;
        if (is_null($last_sale_date)) {
            $this->lastFetch = new Carbon('1/1/1970','AEST');
        } else {
            $this->lastFetch = new Carbon($last_sale_date,'AEST');
        }
    }

    /**
     * Resets the lastFetch time. When used in conjunction with
     * fetchInvoices will result in all invoices being returned.
     */
    public function resetCounter() {
        $this->lastFetch = new Carbon('1/1/1970');
    }

    /**
     * Returns an array of invoices generated since last fetch
     * @return Array $invoices
     */
    abstract function fetchInvoices($access_token);

}


