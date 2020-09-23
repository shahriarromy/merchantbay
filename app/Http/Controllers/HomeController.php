<?php

namespace App\Http\Controllers;
use App\Exports;
use App\Countries;
use App\Headings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{

    public function index()
    {
//        $user = Auth::user();
        //$user = Auth::user()->user_type;
        $headings = Headings::whereBetween('fk_hs_code',[50, 63])
                    ->orderBy('view_orders')
                    ->paginate(20);
        foreach ($headings as $key=>$heading) {
            if(!empty($headings[$key]->headings_image))
                $headings[$key]->headings_image = URL::asset('headings_images').'/'.$heading->headings_image;
        }
        //dd($headings->next());
        return view('home',['headings' => $headings]);
    }
}
