<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BankNiftyNseData;
use App\Models\NiftyNseData;
use Response; 
use DateTime;  
use DB;  

class ChartController extends Controller
{ 
    public function chartHome() { 
        return view('chart');
    }

    public function getChartData(Request $request) { 


        $next_expiry_date = new DateTime();
        $next_expiry_date->modify('next thursday');
        $next_expiry_date = $next_expiry_date->format('d-M-Y'); 
        
        //dd($next_expiry_date);


        $nifty_data = NiftyNseData::select(array( 
                        "nifty_nse_data.nifty_expiry", 
                        "nifty_nse_data.filtered_nifty_nse_data", 
                         DB::raw("DATE_FORMAT(created_at, '%h:%i %p') as format_created_at"),
                    ))->get()->toArray();


        $chart_data = array();
        $upper_range = $request->get('range');
        $down_range = $request->get('range');
        $time = $oi_diff = $oi_change_diff = $vol_diff = array(); 

        foreach ($nifty_data as $nifty_key => $nifty_value) {
            $filtered_nifty_nse_data = json_decode($nifty_value['filtered_nifty_nse_data']); 
            
            $strike_price = $call_oi_sum = $call_oichange_sum = $call_vol_sum = $put_oi_sum = $put_oichange_sum = $put_vol_sum = 0;
 
            foreach ($filtered_nifty_nse_data->data as $key => $value) {  
                if($strike_price == 0)
                $strike_price = $value->CE->underlyingValue; 
                $start_index = $strike_price - $upper_range;
                $end_index = $strike_price + $down_range;

                if($value->strikePrice >= $start_index && $value->strikePrice <= $end_index && isset($value->CE)) { 
                    $call_oi_sum += $value->CE->openInterest;
                    $call_oichange_sum += $value->CE->changeinOpenInterest;
                    $call_vol_sum += $value->CE->totalTradedVolume;
                    $put_oi_sum += $value->PE->openInterest;
                    $put_oichange_sum += $value->PE->changeinOpenInterest; 
                    $put_vol_sum += $value->PE->totalTradedVolume; 
                }
            }

            $chart_data[$nifty_key]['format_created_at'] = $nifty_value['format_created_at']; 
            $chart_data[$nifty_key]['strike_price'] = $strike_price; 
            $chart_data[$nifty_key]['call_oi_sum'] = $call_oi_sum; 
            $chart_data[$nifty_key]['call_oichange_sum'] = $call_oichange_sum; 
            $chart_data[$nifty_key]['call_vol_sum'] = $call_vol_sum; 
            $chart_data[$nifty_key]['put_oi_sum'] = $put_oi_sum; 
            $chart_data[$nifty_key]['put_oichange_sum'] = $put_oichange_sum; 
            $chart_data[$nifty_key]['put_vol_sum'] = $put_vol_sum; 

            $time[] = $nifty_value['format_created_at'];
            $oi_diff[] = $call_oi_sum - $put_oi_sum;
            $oi_change_diff[] = $call_oichange_sum - $put_oichange_sum;
            $vol_diff[] = $call_vol_sum - $put_vol_sum; 
        }

        $calc_data['nifty'] = $chart_data;
        $calc_data['nifty_time'] = $time;
        $calc_data['nifty_oi_diff'] = $oi_diff;
        $calc_data['nifty_oi_change_diff'] = $oi_change_diff;
        $calc_data['nifty_vol_diff'] = $vol_diff;

        $bank_nifty_nifty_data = BankNiftyNseData::select(array( 
                        "bank_nifty_nse_data.bank_nifty_expiry", 
                        "bank_nifty_nse_data.filtered_bank_nifty_nse_data", 
                         DB::raw("DATE_FORMAT(created_at, '%h:%i %p') as format_created_at"),
                    ))->get()->toArray();


        $bank_nifty_chart_data = array();
        $upper_range = $request->get('range');
        $down_range = $request->get('range'); 
        $time = $oi_diff = $oi_change_diff = $vol_diff = array();

        foreach ($bank_nifty_nifty_data as $bank_nifty_key => $bank_nifty_value) {
            $filtered_bank_nifty_nse_data = json_decode($bank_nifty_value['filtered_bank_nifty_nse_data']);
            
            $strike_price = $call_oi_sum = $call_oichange_sum = $call_vol_sum = $put_oi_sum = $put_oichange_sum = $put_vol_sum = 0;
            
            foreach ($filtered_bank_nifty_nse_data->data as $key => $value) { 
                if($strike_price == 0)
                $strike_price = $value->CE->underlyingValue; 
                $start_index = $strike_price - $upper_range;
                $end_index = $strike_price + $down_range;

                if($value->strikePrice >= $start_index && $value->strikePrice <= $end_index && isset($value->CE)) { 
                    $call_oi_sum += $value->CE->openInterest;
                    $call_oichange_sum += $value->CE->changeinOpenInterest;
                    $call_vol_sum += $value->CE->totalTradedVolume;
                    $put_oi_sum += $value->PE->openInterest;
                    $put_oichange_sum += $value->PE->changeinOpenInterest; 
                    $put_vol_sum += $value->PE->totalTradedVolume; 
                }
            }
            $bank_nifty_chart_data[$bank_nifty_key]['format_created_at'] = $bank_nifty_value['format_created_at']; 
            $bank_nifty_chart_data[$bank_nifty_key]['strike_price'] = $strike_price; 
            $bank_nifty_chart_data[$bank_nifty_key]['call_oi_sum'] = $call_oi_sum; 
            $bank_nifty_chart_data[$bank_nifty_key]['call_oichange_sum'] = $call_oichange_sum; 
            $bank_nifty_chart_data[$bank_nifty_key]['call_vol_sum'] = $call_vol_sum; 
            $bank_nifty_chart_data[$bank_nifty_key]['put_oi_sum'] = $put_oi_sum; 
            $bank_nifty_chart_data[$bank_nifty_key]['put_oichange_sum'] = $put_oichange_sum; 
            $bank_nifty_chart_data[$bank_nifty_key]['put_vol_sum'] = $put_vol_sum; 
            
            $time[] = $bank_nifty_value['format_created_at']; 
            $oi_diff[] = $call_oi_sum - $put_oi_sum;
            $oi_change_diff[] = $call_oichange_sum - $put_oichange_sum;
            $vol_diff[] = $call_vol_sum - $put_vol_sum;
        }

       
        $calc_data['banknifty'] = $bank_nifty_chart_data;
        $calc_data['bank_nifty_time'] = $time;
        $calc_data['bank_nifty_oi_diff'] = $oi_diff;
        $calc_data['bank_nifty_oi_change_diff'] = $oi_change_diff;
        $calc_data['bank_nifty_vol_diff'] = $vol_diff;

        return $calc_data; 
    }
}
