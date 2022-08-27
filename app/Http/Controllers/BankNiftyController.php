<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankNiftyNseData;
use Response;

class BankNiftyController extends Controller
{
    private $api_url = "https://www.nseindia.com/api/option-chain-indices?symbol=BANKNIFTY";
    private $headers = [
            'Content-Type' => 'application/json', 
        ]; 

    public function bankNiftyHome() { 
        return view('bank-nifty');
    }

     public function saveBankNiftyNseData() {
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $this->api_url); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $nseApiData = curl_exec($ch);
        curl_close($ch);

        $nseApiData = json_decode($nseApiData);
        $filtered_nsedata = $nseApiData->filtered;
        $all_nsedata = $nseApiData->records;

        //Save Bank Nifty NSE Data
        if($nseApiData) { 
            $nse_data_save = BankNiftyNseData::create([
                'bank_nifty_expiry' => $filtered_nsedata->data[0]->expiryDate,
                'filtered_bank_nifty_nse_data' => json_encode($filtered_nsedata),
                'all_bank_nifty_nse_data' => json_encode($all_nsedata),
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Saved Successfully', 
        ], 200);

    }

    public function getBankNiftyNseData(Request $request) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $nseApiData = curl_exec($ch);
        curl_close($ch);

        $nseApiData = json_decode($nseApiData);
        $filtered_nsedata = $nseApiData->filtered;
        $all_nsedata = $nseApiData->records;
        $index = $nseApiData->filtered->data[0]->CE->underlyingValue;  

        $max_ce_oi = 0;
        $max_ce_oi_strike = 0;

        $max_ce_oichange = 0;
        $max_ce_oichange_strike = 0;

        $max_pe_oi = 0;
        $max_pe_oi_strike = 0;

        $max_pe_oichange = 0;
        $max_pe_oichange_strike = 0;

        $selected_put_oi_sum = 0;
        $selected_put_vol_sum = 0;
        $selected_call_vol_sum = 0;
        $selected_call_oi_sum = 0;

        $selected_call_oichange_sum = 0;
        $selected_put_oichange_sum = 0;


        $upper_range = $request->get('range');
        $down_range = $request->get('range');

        $start_index = $index - $upper_range;
        $end_index = $index + $down_range;
        
        $new_data = array(); 

        foreach ($filtered_nsedata->data as $key => $value) { 
            if($value->strikePrice >= $start_index && $value->strikePrice <= $end_index) { 

                if($max_ce_oi < $value->CE->openInterest) {
                    $max_ce_oi = $value->CE->openInterest;
                    $max_ce_oi_strike = $value->strikePrice;
                }
                if($max_ce_oichange < $value->CE->changeinOpenInterest) {
                    $max_ce_oichange = $value->CE->changeinOpenInterest;
                    $max_ce_oichange_strike = $value->strikePrice;
                }
                if($max_pe_oi < $value->PE->openInterest) {
                    $max_pe_oi = $value->PE->openInterest;
                    $max_pe_oi_strike = $value->strikePrice;
                }
                if($max_pe_oichange < $value->PE->changeinOpenInterest) {
                    $max_pe_oichange = $value->PE->changeinOpenInterest;
                    $max_pe_oichange_strike = $value->strikePrice;
                }

                $selected_put_oi_sum += $value->PE->openInterest;
                $selected_put_vol_sum += $value->PE->totalTradedVolume;
                $selected_call_vol_sum += $value->CE->totalTradedVolume;
                $selected_call_oi_sum += $value->CE->openInterest;

                $selected_call_oichange_sum += $value->CE->changeinOpenInterest;
                $selected_put_oichange_sum += $value->PE->changeinOpenInterest;

                $new_data['tabledata'][] = $value;
                $new_data['chartdata']['strike'][] = $value->strikePrice;
                $new_data['chartdata']['ceoi'][] = $value->CE->openInterest;
                $new_data['chartdata']['peoi'][] = $value->PE->openInterest;
                $new_data['chartdata']['cechangeoi'][] = $value->CE->changeinOpenInterest;
                $new_data['chartdata']['pechangeoi'][] = $value->PE->changeinOpenInterest;
            }
        }  

        $new_data['total_call_oi'] = number_format($filtered_nsedata->CE->totOI);
        $new_data['total_call_volume'] = number_format($filtered_nsedata->CE->totVol);
        $new_data['total_put_oi'] = number_format($filtered_nsedata->PE->totOI);
        $new_data['total_put_volume'] = number_format($filtered_nsedata->PE->totVol);

        $new_data['total_pcr_oi'] = $filtered_nsedata->PE->totOI/$filtered_nsedata->CE->totOI;
        $new_data['total_pcr_volume'] = $filtered_nsedata->PE->totVol/$filtered_nsedata->CE->totVol;

        $new_data['max_ce_oi'] = $max_ce_oi;
        $new_data['max_ce_oi_strike'] = $max_ce_oi_strike;
        $new_data['max_ce_oichange'] = $max_ce_oichange;
        $new_data['max_ce_oichange_strike'] = $max_ce_oichange_strike;
        $new_data['max_pe_oi'] = $max_pe_oi;
        $new_data['max_pe_oi_strike'] = $max_pe_oi_strike;
        $new_data['max_pe_oichange'] = $max_pe_oichange;
        $new_data['max_pe_oichange_strike'] = $max_pe_oichange_strike;

        $new_data['selected_put_oi_sum'] = $selected_put_oi_sum;
        $new_data['selected_put_vol_sum'] = $selected_put_vol_sum;
        $new_data['selected_call_vol_sum'] = $selected_call_vol_sum;
        $new_data['selected_call_oi_sum'] = $selected_call_oi_sum;
        $new_data['selected_pcr_oi'] = $selected_put_oi_sum/$selected_call_oi_sum;

        $new_data['selected_call_oichange_sum'] = $selected_call_oichange_sum;
        $new_data['selected_put_oichange_sum'] = $selected_put_oichange_sum;

        return $new_data;
        //return $filtered_nsedata;
        //return $all_nsedata;
    }
}
