<?php  
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

Class Counter
{	
    public static function get_counter($type)
	{
		
		$counter = DB::table('counter')->select('DATE')->limit(1)->first();
		if(@$counter->DATE != date("Y-m-d"))
		{
			$objResult_c = DB::table('counter')
				->select(DB::raw(date('Y-m-d',strtotime("-1 day"))." , count(*) as intYesterday"))
				->where('DATE', date('Y-m-d',strtotime("-1 day")))
				->first();

			DB::table('daily')->insert(['DATE' => date('Y-m-d',strtotime("-1 day")),'NUM' => $objResult_c->intYesterday,]);
			DB::table('counter')->where('DATE','!=', date("Y-m-d"))->delete();  

		}
		
		$rs = DB::table('counter')->select('DATE')->where('IP',$_SERVER["REMOTE_ADDR"])->count();
		if($rs<=0)
		{
			$data = array(
					'DATE' => date("Y-m-d"),
					'IP' => $_SERVER["REMOTE_ADDR"],
			);
			DB::table('counter')->insert($data);
		}

		switch ($type) {
			case 'strToday':
				$objResult = DB::table('counter')->select(DB::raw('count(DATE) as strToday'))->where('DATE',date("Y-m-d"))->first();
				if(!empty($objResult)){
					$data_count = $objResult->strToday;
				}else{
					$data_count = 0;
				}
				break;
			case 'strYesterday':
				$objResult = DB::table('daily')->select('NUM')->where('DATE',date("Y-m-d",strtotime("-1 day")))->first();
				if(!empty($objResult)){
					$data_count = $objResult->NUM;
				}else{
					$data_count = 0;
				}
				break;
			case 'strThisMonth':
				$objResult = DB::table('daily')->select(DB::raw('SUM(NUM) as strThisMonth'))->whereYear('DATE',date("Y"))->whereMonth('DATE',date("m"))->first();
				if(!empty($objResult)){
					$data_count = $objResult->strThisMonth;
				}else{
					$data_count = 0;
				}
				break;
			case 'strLastMonth':
				$objResult = DB::table('daily')->select(DB::raw('SUM(NUM) as strLastMonth'))->where('DATE',date('Y-m',strtotime("-1 month")))->first();
				if(!empty($objResult)){
					$data_count = $objResult->strLastMonth;
				}else{
					$data_count = 0;
				}
				break;
			case 'strThisYear':
				$objResult = DB::table('daily')->select(DB::raw('SUM(NUM) as strThisYear'))->where('DATE',date('Y'))->first();
				if(!empty($objResult)){
					$data_count = $objResult->strThisYear;
				}else{
					$data_count = 0;
				}
				break;
			case 'strLastYear':
				$objResult = DB::table('daily')->select(DB::raw('SUM(NUM) as strLastYear'))->where('DATE',date('Y',strtotime("-1 year")))->first();
				if(!empty($objResult)){
					$data_count = $objResult->strLastYear;
				}else{
					$data_count = 0;
				}
				break;
			default:
				$objResult = DB::table('daily')->select(DB::raw('SUM(NUM) as strThisTotal'))->first();
				if(!empty($objResult)){
					$data_count = $objResult->strThisTotal;
				}else{
					$data_count = 0;
				}
				break;
		}
		return $data_count;

	}
}



?>