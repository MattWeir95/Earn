<?php

namespace App\Http\Controllers;

use App\Models\InvoiceService;
use Illuminate\Http\Request;
use LangleyFoxall\XeroLaravel\OAuth2;
use League\OAuth2\Client\Token\AccessToken;
use App\Models\InvoiceServiceToken;

class XeroController extends Controller
{
    private function getOAuth2()
    {
        // This will use the 'default' app configuration found in your 'config/xero-laravel-lf.php` file.
        // If you wish to use an alternative app configuration you can specify its key (e.g. `new OAuth2('other_app')`).
        return new OAuth2();
    }

    public function redirectUserToXero()
    {
        // Step 1 - Redirect the user to the Xero authorization URL.
        return $this->getOAuth2()->getAuthorizationRedirect();
    }

    public function handleCallbackFromXero(Request $request)
    {
        // Step 2 - Capture the response from Xero, and obtain an access token.
        $accessToken = $this->getOAuth2()->getAccessTokenFromXeroRequest($request);
        
        // Step 3 - Retrieve the list of tenants (typically Xero organisations), and let the user select one.
        $tenants = $this->getOAuth2()->getTenants($accessToken);
        $selectedTenant = $tenants[0]; // For example purposes, we're pretending the user selected the first tenant.

        // Step 4 - Store the access token and selected tenant ID against the user's account for future use.
        // You can store these anyway you wish. For this example, we're storing them in the database using Eloquent.
        $teamId = auth()->user()->currentTeam->id;
        $xeroId = InvoiceService::where('app_name', 'Xero')->get()->toArray();
        $inputs = ['team_id' => $teamId, 'app_id' => $xeroId[0]['id'], 'api_id' => $selectedTenant->tenantId, 'app_name' => 'Xero', 'access_token' => json_encode($accessToken)];
        InvoiceServiceToken::create($inputs); 
    }

    //NEED TO MODIFY THIS FUNCTION TO SUIT IMPLEMENTATION
    //----------------------------------------------------
    public function refreshAccessTokenIfNecessary()
    {
        // Step 5 - Before using the access token, check if it has expired and refresh it if necessary.
        $user = auth()->user();
        $accessToken = new AccessToken(json_decode($user->xero_access_token));

        if ($accessToken->hasExpired()) {
            $accessToken = $this->getOAuth2()->refreshAccessToken($accessToken);

            $user->xero_access_token = $accessToken;
            $user->save();
        }
    }
}





