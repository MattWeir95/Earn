<?php

namespace App\Http\Controllers;

use App\Classes\Invoice;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\User;
use App\Models\History;
use App\Models\Sales;
use App\Models\InvoiceServiceToken;
use XeroPHP\Models\Accounting\LineItem;
use App\Classes\InvoiceGenerator;
use App\Classes\MockFetcher;
use Carbon\Carbon;
use App\Http\Controllers\RuleController;

class PredictionController extends Controller
{

    public static $expected_normalised_sales = [1, 0.95, 0.97, 0.89, 0.9, 0.86, 0.95, 0.97, 0.93, 0.98, 1.1, 1.3];
    
    /**
     * p5js map function, linearly scales a number
     * from one range to another
     */
    public static function map($n, $start1, $stop1, $start2, $stop2) {
        return (($n-$start1)/($stop1-$start1))*($stop2-$start2)+$start2;
    }

    public static function extrapolateThisMonth(int $team_user_id) {
        /**
         * Linearly extrapolate earnings from the current month to the
         * end of the current month. Does not utilise any expected sales
         * figures.
         * @param int $team_user_id
         */
        $history = History::where('team_user_id','=',$team_user_id)
            ->firstWhere('start_time','=',now()->startOfMonth());
        return $history->total_commission/(now()->day/now()->daysInMonth);
    }

    public static function predict(int $team_user_id, $n_months = 1, $beta = 0.75) {
        /**
         * Predict the next month's commission using a weighted average over
         * a normalised sales value using the last min(count(History::all()),6)
         * month's history.
         * @param $team_user_id
         * @param $n_months
         * @param $beta : Momentum term for weighted averaging
         */
        $expected_normalised_sales = PredictionController::$expected_normalised_sales;
        
        $histories = History::where('team_user_id','=',$team_user_id)->orderBy('start_time','desc')->get()->toArray();
        $histories[0]['total_commission'] = $histories[0]['total_commission']/(now()->day/now()->daysInMonth);
        $normalised_histories = array_map(function ($history) use ($expected_normalised_sales) {
            $month = (int) substr($history['start_time'],5,2);
            return $history['total_commission']/$expected_normalised_sales[$month-1];
        },$histories);
        $window_size = min(count($normalised_histories),6)-1;
        $total = $normalised_histories[$window_size];
        for ($i = $window_size; $i > 0; $i--) {
            $total = ($total * $beta) + ((1-$beta) * $normalised_histories[$i]);
        }
        $results = [];
        for ($i = 0; $i < $n_months; $i++) {
            $pred_month = ((int) substr($histories[0]['start_time'],5,2)+$i) % 12;
            array_push($results,$total * $expected_normalised_sales[$pred_month]);
        }
        return $results;
    }
}
