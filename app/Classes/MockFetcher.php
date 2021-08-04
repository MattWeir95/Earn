<?php

namespace App\Classes;

use Carbon\Carbon;
use App\Models\Sales;
use App\Classes\InvoiceGenerator;

class MockFetcher extends InvoiceFetcherInterface {

    /**
     * Returns an array of invoices generated since last fetch
     * @return Array $invoices
     */
    function fetchInvoices() {
        $gen = new InvoiceGenerator;
        $invoices = [];
        for ($i = 0; $i < $this->lastFetch->diffInRealMinutes(now()); $i++) {
            array_push($invoices,$gen->getInvoice(now()->subMinutes($i)));
        }
        $this->lastFetch = now('AEST');
        return $invoices;
    }
}


