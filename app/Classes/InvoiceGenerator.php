<?php

namespace App\Classes;

use App\Models\TeamUser;
use App\Models\User;
use XeroPHP\Models\Accounting\LineItem;

class InvoiceGenerator
{
    /*
    Generates mock data for testing various parts of the API parsing component
    */
    private $services = [
        'Pick Me Up Facial' => 60,
        'Teenage Peel + LED' => 79,
        'Dermaplaning' => 89,
        'Hydrating Peel' => 99,
        '24K Gold Signature Facial' => 249,
        'De-Stress Hydra Facial' => 159,
        'Anti-ageing Powerhouse Facial' => 169,
        'Pore Refining Facial' => 120,
        'Medik8 Clarity Peel' => 119,
        'Medik8 Even Peel' => 125,
        'Medik8 Rewind Peel' => 135,
        'Brightening Energising C Facial' => 245,
        'Regenerative Stem Cell Facial' => 250,
        'Acne Control IPL' => 159,
        'IPL Skin Rejuvenation' => 209,
        'Skin-needling' => 199,
        'Micro-needling Face + Neck' => 249,
        'Cosmelan Depigmentation Method' => 1250,
        'HA Sheet Mask' => 39,
        'LED Light Therapy' => 39,
        'Manual Extraction' => 40,
        'Eye Reveal Peel' => 49,
        'Ampoules Infusion' => 50,
        'Aromatherapy' => 50
    ];

    private $locations = [
        'Home',
        'Client\'s Home',
        'Skin Management Club',
        'Eaton\'s Hill',
        'Eaton\'s Hill Village',
        'Skin Management Club, Eaton\'s Hill'
    ];

    function getInvoice() {
        /*
        Generate a randomly filled InvoiceInterface
        */
        $team_user = TeamUser::inRandomOrder()->first();
        $name = array_rand($this->services);
        $cost = $this->services[$name];
        return new Invoice($team_user,$name,$cost);
    }

    function getXeroLineItem($service_name = null, $service_cost = null, $staff = null) {
        if (is_null($service_name)) {
            $service_name = array_rand($this->services);
        }
        if (is_null($service_cost)) {
            $service_cost = $this->services[$service_name];
        }
        if (is_null($staff)) {
            $staff = User::find(rand(1, count(User::all()) - 1));
        }
        $item = new LineItem;
        $item->setDescription($this->getDescription($service_name, $staff));
        $item->setUnitAmount($service_cost);
        $item->setQuantity(1);
        return $item;
    }

    function getDescription($service_name = null, $staff_member = null) {
        /*
        Generates a random desciption with the following syntax:
        {service_name} with {staff_name} at {store_location} on {local_d_a_t}
        */
        if (is_null($service_name)) {
            $service_name = array_rand($this->services);
        }
        if (is_null($staff_member)) {
            $staff_member = User::find(rand(1, count(User::all()) - 1));
        }
        $name = $staff_member->first_name . ' ' . $staff_member->last_name;
        $location = $this->locations[rand(0,count($this->locations)-1)];
        return $service_name.' with '.$name.' at '.$location.' on '.now('Australia/Brisbane')->toCookieString();
    }

    function getPair() {
        $invoice = $this->getInvoice();
        $user = User::find($invoice->team_user->user_id);
        $item = $this->getXeroLineItem($invoice->service_name,$invoice->service_cost,$user);
        return [$item, $invoice];
    }
}