<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NseData;
use Response; 

class HomeController extends Controller
{

    public function allData() { 
        return view('bank-nifty');
    }

    public function oldData() { 
        return view('selected-range');
    }

    public function charts() { 
        return view('selected-range');
    } 

    public function getAllNseData() {
        $ch = curl_init();
        $headers = [
        'Content-Type' => 'application/json', 
        ]; 
        curl_setopt($ch, CURLOPT_URL, "https://www.nseindia.com/api/option-chain-indices?symbol=NIFTY"); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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
        
        $new_data = array(); 

        foreach ($filtered_nsedata->data as $key => $value) {  

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

                $new_data['tabledata'][] = $value;
                $new_data['chartdata']['strike'][] = $value->strikePrice;
                $new_data['chartdata']['ceoi'][] = $value->CE->openInterest;
                $new_data['chartdata']['peoi'][] = $value->PE->openInterest;
                $new_data['chartdata']['cechangeoi'][] = $value->CE->changeinOpenInterest;
                $new_data['chartdata']['pechangeoi'][] = $value->PE->changeinOpenInterest;
             
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

        return $new_data;
        //return $filtered_nsedata;
        //return $all_nsedata;
    }
}
