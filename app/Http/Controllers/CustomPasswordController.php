<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Mail;
use Hash;

class CustomPasswordController extends Controller {

    public function sendMailForPass(Request $request){

        DB::beginTransaction();

        $list = array();

        /*
        // name check!
        $results = DB::select('
            select  *
            from    t_user 
            where   name = ? and email = ?
            limit 1
        ',[$request->input('name'), $request->input('email')]);
        */

        
        // token insert
        DB::delete('
            delete from password_resets
            where email =? 
        ',[Input::get('email')]);
        
        DB::insert('
            insert into password_resets
            (email, token, created_at) values (?, ?, sysdate())
        ',[Input::get('email'), Input::get('token')]);
        

        // insert log! 


        // get userInfo
        $data = array();
        $results = DB::select('
            select  *
            from    t_user 
            where   email = ?
        ',[Input::get('email')]);

        $data['email'] = $results[0]->email;
        $data['name'] = $results[0]->name;

        DB::commit();

        //if(isset($results[0]->email)){
            /*
            $data['email'] = $results[0]->email;
            $data['name'] = $results[0]->name;
            */

            Mail::send('emails.password',['token'=> Input::get('token')], function($message) use ($data){
                $message->to($data['email'], $data['name'])->subject('Pintalk sends the procedure for changing password!');
            });
            if( count(Mail::failures()) > 0 ) {
                // email 발송실패 
                foreach(Mail::failures as $email_address) {
                    array_push($list, $email_address);
                }
            }else{
                // email 발송성공
            }
            return Response::json(['success'=>true, 'failList'=>$list]);
        
        /*
        }else{
            return Response::json(['success'=>false]);
        }
        */
    }


    public function showResetForm($token=null){

        if (is_null($token))
        {
            throw new NotFoundHttpException;
        }
        // check token 
        return view('emails.reset')->with('token',$token);
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function reset(Request $request)
    {

        DB::beginTransaction();

        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        // password_resets check 
        $result = DB::select('
            select  *
            from    password_resets
            where   email = ?
        ',[$request->input('email')]);

        // 성공 
        if(isset($result[0]->token) && $result[0]->token==$request->get('token')){
            
            // password 같으면 입력 
            DB::update(' 
                update  t_user 
                set 
                password = ?
                where   email = ?
            ',[bcrypt($request->get('password')), $request->get('email')]);

            // token 삭제 
            DB::delete('
                delete from password_resets
                where email = ? 
            ',[$request->input('email')]);

            DB::commit();
            return Response::json(['success'=>true]);

        }else{ // 변경실패 
            return Response::json(['success'=>false]);
        }
    }


    public function updatePassword(Request $request){
        
        // compareing current password
        $result = DB::select('
            select  *
            from    t_user 
            where   email = ?
        ',[$request->input('email')]);

        $check = Hash::check($request->get('current-password'),$result[0]->password);

        if(!$check){
            return Response::json(['success'=>false, 'error'=>0]);
        }
     
        // update password

        if($request->input('new-password')==$request->input('confirm-new-password')){

            DB::update(' 
                update  t_user 
                set 
                password = ?
                where   email = ?
            ',[bcrypt($request->get('confirm-new-password')), $request->get('email')]);

            return Response::json(['success'=>true]);           

        }else{
            return Response::json(['success'=>false, 'error'=>1]);           
        }
    }
}