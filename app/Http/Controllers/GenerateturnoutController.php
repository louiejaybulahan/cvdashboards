<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Auth;

class GenerateturnoutController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() { 
        //$region_id = Auth::user()->REGION_ID;
        $region = DB::table('lib_regions')->where('REGION_ID','<>',18)->get();
        $periodActive = DB::table('lib_periods')->where('is_status',1)->first();
        
        return view('generateturnout.index',['region' => $region, 'periodActive'=>$periodActive]);
    }  
    
    public function generate(Request $request){
        $year = $request->input('year');
        $period = $request->input('period');
        $region = $request->input('region');
        //Query Process
        


        
        
        
        
        
        
        
        
        
        ///End query
        return view('generateturnout.generate',['region'=>$region, 'year'=>$year, 'period'=>$period]);
        
    }
}    