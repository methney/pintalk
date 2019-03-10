<?php namespace App\Http\Controllers\Auth;

use Auth;
use Input;
use Hash;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Socialize;
use DB;
use Redirect;

//use LRedis;
use Session;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;
	

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
		$this->middleware('guest', ['except' => 'getLogout']);
		$this->redirectTo = "/";
	}

	
	public function postLogin(Request $request){

		//$this->middleware('pin');
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		/*
		$redis = LRedis::connection();
		$arr = ['email'=>Input::get('email'), 'socket_id'=>Input::get('socket_id')];
		$redis->publish('create_user', json_encode($arr));
		*/

		//dd($this->loginPath());

		$redirect_url = Input::get('redirectUrl');
		if(strpos(Input::get('redirectUrl'), '/auth')){
			$redirect_url = 'indexGuest';
		}
		
		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			// session
			Session::put('email',Input::get('email'));
			Session::put('name', Auth::user()->name);
			Session::put('link', Auth::user()->link);
			Session::put('avatar', Auth::user()->avatar);
			Session::put('cfg', 'false');

			Session::put('video_enable', Auth::user()->video_enable);
			Session::put('audio_enable', Auth::user()->audio_enable);
			Session::put('youtube_enable', Auth::user()->youtube_enable);
			Session::put('guide_enable', Auth::user()->guide_enable);
			Session::put('facebook_id','-');

			// 맵컨트롤 회수제한을 위한 코드
			$use_cnt = $this->getUsageCnt($request);
			Session::put('use_cnt', $use_cnt);

			//dd(redirect()->intended($redirect_url));
			//return redirect()->intended($this->redirectPath());
			//return redirect()->intended($redirect_url);
			//return redirect('indexGuest');
			return redirect($redirect_url);

			// 원래 모바일 때문에 고치기 전에, redirect()->intended(Input::get('redirectUrl')) 이거 였음.
			// 다만, 모바일에서는 위의 형식으로만 되고.. intended 로는 안됨. 근데, intended는 사실 내부적으로 원래 가고자하는 곳을 찾아주는게 있는모냥, 내가 해놓은 코딩은 이미 이전 url를 가지고 있으므로, redirect로 해도 무방하다고 생각하고 진행했음 (170815)




		}
		
		
		return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
					]);
    }


	public function getUsageCnt(Request $request){
		$result = DB::select('
			select 	use_cnt
			from 	t_use_cnt
			where 	date_format(reg_dt,"%Y%m%d") = date_format(sysdate(),"%Y%m%d") and email = ?
		',[Input::get('email')]);

		// 오늘 로그인이 처음이 아니면,
		if(sizeof($result)>0){
			return $result[0]->use_cnt;
		}else{
			$result_user = DB::select('
				select email, default_use_cnt
				from 	t_user 
				where 	email = ? 
			',[Input::get('email')]);

			// 오늘 처음로그인이라면, t_use_cnt에 기본 default_use_cnt 를 세팅 
			DB::insert('insert into t_use_cnt (email, use_cnt, reg_dt
					) values (?,?, sysdate())
			',[Input::get('email'),$result_user[0]->default_use_cnt]);

			return $result_user[0]->default_use_cnt;

		}
	}


	public function getLogout(Request $request)
	{
		$this->auth->logout();
		Session::flush();
		$request->session()->regenerate();
		return redirect('/');
	}

	/*
	public function authenticate(Request $request)
    {
		$email = $request->Input['email'];
		$password = $request->Input['password'];
        if (Auth::attempt(['email' => $email, 'password' => $password ]))
        {
			dd('success!');
            //return redirect()->intended('/');
        }
		//echo(Auth::attempt(['email' => $email, 'password' => $password ]));
		//echo(bcrypt($password));
		dd('fail!');
    }
	*/
	
}
