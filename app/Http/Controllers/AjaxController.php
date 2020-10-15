<?php

namespace App\Http\Controllers;

use App\Exports;
use App\Headings;
use App\Rfq;
use App\Suppliers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function chartcountry(Request $request)
    {
        $bd_export_db = Exports::select('fiscal_year', 'usd', 'country_id')
            ->where('chapter_heading_id', '=', $request->heading_id)
            ->where('country_id', '=', $request->country_id)
            ->orderBy('fiscal_year')
            ->get();
        $fiscal = array();
        $data = array();
        $usd = array();
        $i = 0;
        foreach ($bd_export_db as $array) {
            //with unique fiscal year and amount merged for multiple
            if (!in_array($array['fiscal_year'], $fiscal)) {
                $fiscal[$i] = $array['fiscal_year'];
                $usd[$array['fiscal_year']] = (float)$array['usd'];
            } else {
                $usd[$array['fiscal_year']] += (float)$array['usd'];
            }
            $i++;
        }
        if (!empty($usd)) {
            $max_val = (max(array_values($usd)) / 4) + max(array_values($usd));

            if (max(array_values($usd)) > 10000) {
                foreach ($usd as $key => $val) {
                    $usd[$key] = round(($val / 1000000), 5);
                }
                $data['max'] = round(($max_val / 1000000), 2);
                $data['yaxis'] = 'Millions (USD)';
            } else {
                foreach ($usd as $key => $val) {
                    $usd[$key] = round(($val / 1000), 5);
                }
                $data['max'] = round(($max_val / 1000), 2);
                $data['yaxis'] = 'Thousand (USD)';
            }
        }
        $data['labels'] = array_keys($usd);
        $data['value'] = array_values($usd);
        echo json_encode($data);
    }

    public function ajaxchartinit(Request $request)
    {
        $bd_export_db = Exports::select('fiscal_year', 'usd', 'country_id')
            ->where('chapter_heading_id', '=', $request->heading_id)
            ->orderBy('fiscal_year')
            ->get();
//        echo '<pre>';
//        print_r($bd_export_db[0]->countries);exit();
        $fiscal = array();
        $data = array();
        $usd = array();
        $country = array();
        $i = 0;
        foreach ($bd_export_db as $array) {
            if (!in_array($array['country_id'], $country))
                $country['countries'][$i]['id'] = $array['country_id'];
            $country['countries'][$i]['name'] = $array->countries['name'];
            //with unique fiscal year and amount merged for multiple
            if (!in_array($array['fiscal_year'], $fiscal)) {
                $fiscal[$i] = $array['fiscal_year'];
                $usd[$array['fiscal_year']] = (float)$array['usd'];
            } else {
                $usd[$array['fiscal_year']] += (float)$array['usd'];
            }
            $i++;
        }
        if (!empty($usd)) {
            $max_val = (max(array_values($usd)) / 4) + max(array_values($usd));

            if (max(array_values($usd)) > 10000) {
                foreach ($usd as $key => $val) {
                    $usd[$key] = round(($val / 1000000), 5);
                }
                $data['max'] = round(($max_val / 1000000), 2);
                $data['yaxis'] = 'Millions (USD)';
            } else {
                foreach ($usd as $key => $val) {
                    $usd[$key] = round(($val / 1000), 5);
                }
                $data['max'] = round(($max_val / 1000), 2);
                $data['yaxis'] = 'Thousand (USD)';
            }
        }
        $data['labels'] = array_keys($usd);
        $data['value'] = array_values($usd);
        echo json_encode($data);
    }

    public function ajaxloadmore(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id > 0) {
//                $suppliers = Suppliers::where('id', '<', $request->id)
//                    ->orderBy('id', 'DESC')
//                    ->limit(4)
//                    ->get();
                $suppliers = DB::table('users')
                    ->select('users.id','users.payment_confirmation','users.is_verified','users.uname','user_profiles.company_logo','user_profiles.company_name','user_profiles.company_info')
                    ->leftJoin('user_profiles','users.id','=','user_profiles.user_id')
                    ->where([['is_verified',1],['payment_confirmation',1]])
                    ->whereIn('user_type',['supplier', 'both'])
                    ->limit(4)
                    ->get();
            } else {
//                $suppliers = Suppliers::orderBy('id', 'DESC')
//                    ->limit(4)
//                    ->get();
                $suppliers = DB::table('users')
                    ->select('users.id','users.payment_confirmation','users.is_verified','users.uname','user_profiles.company_logo','user_profiles.company_name','user_profiles.company_info')
                    ->leftJoin('user_profiles','users.id','=','user_profiles.user_id')
                    ->where([['is_verified',1],['payment_confirmation',1]])
                    ->whereIn('user_type',['supplier', 'both'])
                    ->limit(8)
                    ->get();
            }
//            echo print_r($suppliers);
//            die();
            $output = '';
            $last_id = '';
            $images = '';
            $small_icon_one = '';
            $small_icon_two = '';
            $main_site_url = 'https://www.merchantbay.com/public/';
            $output .= '<div class="row boxWrap">';
            if (!$suppliers->isEmpty()) {
                foreach ($suppliers as $supplier) {
                    if($supplier->payment_confirmation == 1)
                        $small_icon_one = $main_site_url.'images/gold-suppliers.png';
                    else
                        $small_icon_one = $main_site_url.'images/experienced-suppliers.png';

                    if($supplier->is_verified == 1)
                        $small_icon_two = $main_site_url.'images/verified-suppliers.png';
                    else
                        $small_icon_two = $main_site_url.'images/trade-secured-suppliers.png';

                    if (!empty($supplier->company_logo)) {
                        $images = '<img src="'.asset($main_site_url.'storage/'.$supplier->company_logo).'" class="img-center"  height="75">';
                    } else {
                        $images = '<img src="'.asset($main_site_url.'images/supplier.png').'" class="img-center"  height="75">';
                    }

                    $company_info = json_decode($supplier->company_info);

                    if(Auth::user())
                        $button_text = '<a target="_blank" href="https://www.merchantbay.com/supplier/'.$supplier->uname.'" class="col-md-12 plr0 send-enq-but r" >Visit Profile</a>';
                    else
                        $button_text = '<a target="_blank" href="https://www.merchantbay.com/supplier/'.$supplier->uname.'" class="col-md-12 plr0 send-enq-but r" id="visitprofile'.$supplier->id.'">Visit Profile</a>';
                    if(empty($company_info->establishment))
                        $company_info->establishment = 'Not Available';
                    $output .= '<div class="col-md-3">
							<div class="supplier-cart">
								<!--1-->
								<div class="row img-hldr2 prd-hd-hldr">
									<div class="col-md-7 pr0 img-hd">
										<a href="javascript:void(0);">'.$images.'</a>
										<a href="https://www.merchantbay.com/supplier/'.$supplier->uname.'" class="prd-hd left" target="_blank">'.$supplier->company_name.'</a>
									</div>
									<div class="col-md-5 bh-cont">
										<div class="small-icon"><img src="'.$small_icon_one.'"></div>
										<div class="small-icon"><img src="'.$small_icon_two.'"></div>
									</div>
									<div class="clear"></div>
								</div>
								<!--/1-->
								<!--2-->
								<div class="col-md-12 piece-order-hldr">
									<div class="row">
										<!--Box-left-->
										<div class="col-md-2 plr0 lb">
											<div class="col-md-12 lb-icon-cont"><img src="'.$main_site_url.'images/industry24X24.png"></div>
											<div class="col-md-12 lb-icon-cont"><img src="'.$main_site_url.'images/sweater24X24.png"></div>
											<div class="col-md-12 lb-icon-cont"><img src="'.$main_site_url.'images/quantity.png"></div>
											<div class="col-md-12 lb-icon-cont"><img src="'.$main_site_url.'images/location24X24.png"></div>
										</div>
										<!--Box-left-->

										<!--Box-right-->
										<div class="col-md-10 pr0">
											<div class="br-cont">'.str_limit($company_info->business_type ?? "",20,"(..)").'</div>
											<div class="br-cont">'.str_limit($company_info->main_products ?? "",20,"(..)").'</div>
											<div class="br-cont">'.$company_info->establishment.'</div>
											<div class="br-cont">'.str_limit($company_info->zone ?? "",20,"(..)").'<br>'.str_limit($company_info->city ?? "",10,"(..)").'</div>
										</div>
										<!--Box-right-->
									</div>
								</div>
								<!--/2-->

								<!--3-->
								<div class="col-md-12 plr0">
									<div class="row">
										<!--left-->
                                        '.$button_text.'
										<!--/left-->
									</div>
								</div>
								<!--/3-->
							</div>
						</div>
						<!--Cart1-->';

                    $last_id = $supplier->id;
                }
                $output .= '</div>';
                $output .= '<div id="load_more">
                            <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="' . $last_id . '" id="load_more_button">Load More</button>
                           </div>';
            } else {
                $output .= '<div id="load_more">
                                <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
                            </div>';
            }
            echo $output;
        }
    }
    function postData(Request $request){
        $v = Validator::make($request->all(), [
            'rfq_name' => 'required|max:255',
            'rfq_email' => 'required|email',
            'rfq_company' => 'required',
            'rfq_description' => 'required',
        ]);
        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }
        $rfq = new Rfq;
        $rfq->rfq_name = $request->rfq_name;
        $rfq->rfq_email = $request->rfq_email;
        $rfq->rfq_company = $request->rfq_company;
        $rfq->rfq_description = $request->rfq_description;
        if($rfq->save()) {
            return redirect()->back()->with('success', 'RFQ added successfully');
        }
    }
}
