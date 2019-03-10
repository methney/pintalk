<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;
use View;
use Auth;

class UserController extends Controller {

    public function selectUser(Request $request)
    {
        $result = DB::select('
            select  email, name, level, facebook_id, avatar, id, link, aboutme, video_enable, audio_enable, youtube_enable, lat, lng, location, guide_enable
            from    t_user 
            where   email = ?
        ',[$request->input('email')]);

        return $result;
    }


    public function updateUserInfo(Request $request){

        $result = DB::update('
            update  t_user 
            set     
            aboutme = ?,
            name = ?,
            avatar = ?,
            video_enable = ?,
            audio_enable = ?,
            youtube_enable = ?,
            lat = ?,
            lng = ?,
            location = ?
            where   email = ?
        ',[$request->input('aboutme'), $request->input('name'), $request->input('avatar'), $request->input('video'), $request->input('audio'), $request->input('youtube'), $request->input('lat'), $request->input('lng'), $request->input('location'), $request->input('email')]);

        //return View::make('profile')->withInput(Input::all());
        //return response()->withInput(Input::all());

        Session::put('video_enable', $request->input('video'));
        Session::put('audio_enable', $request->input('audio'));
        Session::put('youtube_enable', $request->input('youtube'));

        return Response::json($result);
    }

    public function uploadProfileImg(Request $request){

        $imageExt = $request->file('file')->getClientOriginalExtension();
        $imageName = md5(date('YmdHis')).'.'.$imageExt;        

        $request->file('file')->move(
            base_path() . '/public/uploadProfileImages/', $imageName
        );

        // displaying file    
        $array = array(
            'filelink' => url().'/uploadProfileImages/'.$imageName,
            'fileName' => $imageName
        );
        
        echo stripslashes(json_encode($array));   

    }

    public function updateCfg(Request $request){
        $result = DB::update('
            update  t_user 
            set    
            video_enable = ?,
            youtube_enable = ?
            where email = ?
        ',[$request->input('video'), $request->input('youtube'), Auth::user()->email]);

        Session::put('cfg', 'true');
        Session::put('video_enable', $request->input('video'));
        Session::put('youtube_enable', $request->input('youtube'));
    }


    public function updateMapUse(Request $request){
        $result = DB::update('
            update t_use_cnt
            set 
            use_cnt = ?
            where email = ? and date_format(reg_dt,"%Y%m%d") = date_format(sysdate(),"%Y%m%d")
        ',[$request->input('use_cnt'), Auth::user()->email]);

        return Response::json($result);
    }


    public function updateGuide(Request $request){
        $result = DB::update('
            update t_user
            set 
            guide_enable = ?
            where email = ?
        ',[$request->input('guide_enable'), Auth::user()->email]);

        return Response::json($result);
    }
}