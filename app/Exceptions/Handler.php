<?php namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\CustomException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if ($this->isHttpException($e))
		{
			switch($e->getStatusCode()){
				case 404:
				return redirect()->route('notfound');

				case 500:
				return redirect()->route('somethingWrong');
				break;
			}
			return redirect()->route('somethingWrong');
		}
		else if($e instanceof CustomException){
			return redirect()->to('exception/error');
		}
		else
		{
			return parent::render($request, $e);
			//return redirect()->route('somethingWrong');
		}
	}

}
