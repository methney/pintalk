<?php namespace App\Http\Controllers;

use Session;
use App\User;
use Socialize;
use DB;
use Redirect;
use Auth;
use View;
use Illuminate\Http\Request;
use Input;
use Facebook;
use URL;

class FacebookController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request)
    {
        Session::put('redirectUrl', Input::get('redirectUrl'));

        $permissions = array(
        'email',
        //'user_location',
        //'user_birthday',
        //'publish_actions',
        //'publish_pages',
        //'manage_pages',
        'public_profile',
        //'user_likes'
        );

        //return Socialize::with('facebook')->redirect();
        return Socialize::with('facebook')->scopes($permissions)->redirect();
        // 권한참고 https://developers.facebook.com/docs/facebook-login/permissions#reference-email
    }

    /**
     * Obtain the user information from GitHub.
     * service.php에 지정된 콜백 주소로...
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        $user = Socialize::with('facebook')->user();
        /*       
        User {#237 ▼
        +token: "EAALSDJXCvKkBABiq0AMHbQezZAFVlJYcAwVBEfaTStdTHZCeOGJQGVcPPO31gqXQlbNXZCyqZCPbzRmAdzdgmF8fIqx7jIGorBYlVF5TtUZCaEIuwkZCB9XDhiRZAx3S4SiNL3ySlfGnZAKmhdDDcMBn2cVEJIypWk0ZD"
        +refreshToken: null
        +expiresIn: "5111099"
        +id: "1729557173741097"
        +nickname: null
        +name: "Gyu-Ho Lee"
        +email: "mindcure@gmail.com"
        +avatar: "https://graph.facebook.com/v2.8/1729557173741097/picture?type=normal"
        +user: array:6 [▶]
        +"avatar_original": "https://graph.facebook.com/v2.8/1729557173741097/picture?width=1920"
        +"profileUrl": "https://www.facebook.com/app_scoped_user_id/1729557173741097/"
        }
        */
        
        $authUser = $this->checkUser($user);
        $token = $user->token;
        $tokenUser = Socialize::with('facebook')->userFromToken($token);

        Auth::login($authUser,true);
        
        if (Auth::check()){
            // session
            Session::put('facebook_access_token',$tokenUser->token);
            Session::put('link',$user->profileUrl);
            Session::put('email',$user->email);
            Session::put('name', $user->name);
            Session::put('facebook_id',$user->id);
            Session::put('video_enable', Auth::user()->video_enable);
			Session::put('audio_enable', Auth::user()->audio_enable);
            Session::put('youtube_enable', Auth::user()->youtube_enable);
            Session::put('guide_enable', Auth::user()->guide_enable);
            Session::put('cfg', 'false');
            Session::put('fromFacebook', 'true');
            
            if($user->avatar){
				Session::put('avatar', $user->avatar);
			}else{
				Session::put('avatar', url().'/assets/img/member-2.jpg');
			}

            // 맵컨트롤 회수제한을 위한 코드
			$use_cnt = $this->getUsageCnt($request, $user);
			Session::put('use_cnt', $use_cnt);
            
            //return Redirect::intended(Session::get('redirectUrl'));
            return redirect(Session::get('redirectUrl'));
        }else{
            session()->regenerate();
        }
    }

    public function getUsageCnt(Request $request, $user){
		$result = DB::select('
			select 	use_cnt
			from 	t_use_cnt
			where 	date_format(reg_dt,"%Y%m%d") = date_format(sysdate(),"%Y%m%d") and email = ?
		',[$user->email]);

		// 오늘 로그인이 처음이 아니면,
		if(sizeof($result)>0){
			return $result[0]->use_cnt;
		}else{
			$result_user = DB::select('
				select email, default_use_cnt
				from 	t_user 
				where 	email = ? 
			',[$user->email]);

			// 오늘 처음로그인이라면, t_use_cnt에 기본 default_use_cnt 를 세팅 
			DB::insert('insert into t_use_cnt (email, use_cnt, reg_dt
					) values (?,?, sysdate())
			',[$user->email,$result_user[0]->default_use_cnt]);

			return $result_user[0]->default_use_cnt;

		}
	}

    private function checkUser($user){

        $authUser = User::where('facebook_id', $user->id)->first();
 
        if ($authUser){
            return $authUser;
        }

        $results = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'facebook_id' => $user->id,
            'avatar' => $user->avatar,
            'password' => bcrypt(str_random()),
            'link' => $user->profileUrl
        ]);

        return $results;

    }


    public function checkUserFromHead(Request $request){
        $user = Socialize::with('facebook')->user();
        $results = $this->checkUser($user);
        return $results;
    }

    public function linktest(){
        $fb = new Facebook\Facebook([
        'app_id' => '793901447429289',
        'app_secret' => '83421aa012db9c5d14a7e4b3024b411b',
        'default_graph_version' => 'v2.2',
        ]);

        $linkData = [
        'link' => 'https://pintalk.co.kr',
        'message' => 'User provided message',
        ];

        try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->post('/me/feed', $linkData, Session::get('facebook_access_token'));
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
        }

        $graphNode = $response->getGraphNode();

        echo 'Posted with id: ' . $graphNode['id'];
    }
   
}

