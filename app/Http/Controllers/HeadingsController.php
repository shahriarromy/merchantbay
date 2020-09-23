<?php

namespace App\Http\Controllers;

use App\Exports;
use App\Countries;
use App\Headings;
use App\Suppliers;
use Illuminate\Http\Request;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class HeadingsController extends Controller
{
    //
    public function index($heading_id){
        //$headings = Headings::where('headings_id','=',$heading_id)
        $headings = Headings::where('id','=',$heading_id)->firstOrFail();
        if (!empty($headings->headings_image))
            $headings->headings_image = URL::asset('headings_images').'/'.$headings->headings_image;
        $fiscal = array();
        $usd = array();
        $country = array();
        $allCountry = array();
        $totalUSD['amount'] = 0.00;
        $i=0;
        foreach($headings->exports as $array)
        {
            if(!in_array($array['country_id'],$country)) {
                $country[] = $array['country_id'];
                $allCountry[$i]['id'] = $array['country_id'];
                $allCountry[$i]['name'] = $array->countries['name'];
            }
            //with unique fiscal year and amount merged for multiple
            if(!in_array($array['fiscal_year'], $fiscal)) {
                $fiscal[$i] = $array['fiscal_year'];
                $usd[$array['fiscal_year']] = (float) $array['usd'];
            } else {
                $usd[$array['fiscal_year']] += (float) $array['usd'];
            }
            $totalUSD['amount']+= (float) $array['usd'];
            $i++;
        }
        $country_count = count($allCountry);
        $yaxis = '';
        if (!empty($usd)) {

            if (max(array_values($usd))>10000){
                foreach ($usd as $key=>$val) {$usd[$key] = round(($val/1000000), 5);}
                $yaxis = 'Million (USD)';
            }
            else{
                foreach ($usd as $key=>$val) {$usd[$key] = round(($val/1000), 5);}
                $yaxis = 'Thousand (USD)';
            }
            if($totalUSD['amount']>10000) {
                $totalUSD['amount'] = round($totalUSD['amount']/1000000,2);
                $totalUSD['currencyFormat'] = 'Million';
            } else {
                $totalUSD['amount'] = round($totalUSD['amount']/1000,2);
                $totalUSD['currencyFormat'] = 'Thousand';
            }
        }
        //print_r(Charts::create('line', 'highcharts')->settings());
        $chart = Charts::create('line', 'highcharts')
            ->title('Export Chart')
            ->yaxistitle($yaxis)
            ->xaxistitle('Fiscal Years')
            ->colors(['#55A860'])
            ->labels(array_keys($usd))
            ->values(array_values($usd),[5,20,100])
            ->dimensions(1000,500)
            ->responsive(true);
        return view('headings',[
            'headings'=>$headings,
            'chart' => $chart,
            'usd' => $usd,
            'country' => $allCountry,
            'country_count' => $country_count,
            'totalUSD' => $totalUSD
            ]);
    }
}
