<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CodeController extends Controller {

    public function insertCode(Request $request)
    {
        //dd($request); ajax의 경우, preview에서 return value 확인! 
        //var_dump($request);

        if($request->input('type')=='insert'){

            $result = DB::insert('insert into t_common_code (connect_cd, grp_cd, cd, cd_nm, etc, level, reg_dt) values (?,?,?,?,?,?,sysdate())', [
                $request->input('cdGrp').$request->input('cd'),
                $request->input('cdGrp'),
                $request->input('cd'), 
                $request->input('cdNm'),                
                $request->input('etc'),
                $request->input('level')
            ]);
            
            return Response::json(Input::all());
            //return response()->json(['result' => $result],200);
            //return Response::json(['result' => $result]);
            //return Redirect::to('commonCode');
        
        }else{
            $result = DB::update('
                update  t_common_code
                set     cd_nm = ?, etc = ?
                where   connect_cd = ?
            ', [ $request->input('cdNm'), $request->input('etc'), $request->input('connectCd') ]);
            
            return Response::json(Input::all());
        }
    }

    public function selectGrpCode(Request $request){
        $rep_level = ($request->input('level')!='')?' and level="'.$request->input('level').'"' :'';
        $result = DB::select('
            select  connect_cd, cd, CONCAT(REPEAT(" - ", level - 1), cd_nm) as cd_nm
            from    t_common_code 
            where   1=1 '. $rep_level.'
            order by connect_cd
        ');
        //return View::make('commonCode')->with('result',$result);
        return Response::json($result);
    }


    public function selectCodeList(Request $request){
        $result = DB::select('
            select  *
            from    t_common_code
            where   connect_cd like concat(?,"%")
            order by connect_cd, level 
        ',[$request->input('connectCd')]);   
        //return View::make('commonCode')->with('result',$result);
        return Response::json($result);
    }


    public function selectCodeListByLevel(Request $request){
        $result = DB::select('
            select  *
            from    t_common_code
            where   connect_cd like concat(?,"%")
            and     level = ?
            order by connect_cd
        ',[ $request->input('connectCd'), $request->input('level')]);   
        //return View::make('commonCode')->with('result',$result);
        return Response::json($result);
    }

    
    public function selectCodeListByGrp(Request $request){
        $result = DB::select('
            select  *
            from    t_common_code
            where   grp_cd like concat(?,"%")
            order by connect_cd, level 
        ',[$request->input('connectCd')]);   
        //return View::make('commonCode')->with('result',$result);
        return Response::json($result);
    }


    public function selectSingleCode(Request $request){
        $result = DB::select('
            select    * 
            from    t_common_code 
            where   connect_cd = ?
        ', [$request->input('connectCd')]);
        return Response::json($result);
    }


    public function deleteCode(Request $request){
        $cds = json_decode($request->input('connectCds'));
        $re = true;
        foreach($cds as $value){
            $re = $re?$this->deleteSingleCode($value):false;
        }
        return $re;
    }
          
    private function deleteSingleCode($connectCd){
        
        $result = DB::delete('
            delete 
            from    t_common_code
            where   connect_cd = ?
        ', [$connectCd]);
        return $result;
    }
    




    /*
    public function testfunction(Illuminate\Http\Request $request)
    {
        if ($request->isMethod('post')){    
            return response()->json(['response' => 'This is post method']); 
        }

        return response()->json(['response' => 'This is get method']);
        
        
        // $response = array(
        //     'status' => 'success',
        //     'msg' => 'Setting created successfully',
        // );
        // return Response::json($response);
    }
    */

}