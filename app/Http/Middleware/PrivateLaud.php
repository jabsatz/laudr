<?php namespace App\Http\Middleware;

use Closure;
use App\Laud;

class PrivateLaud {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
    //Check if Laud is private
    $user = Laud::findOrFail($request->segment(2))->user;

    //If it isn't, you're good to go
    if(!$user->private)return $next($request);

    //If it is, we'll check if you're following the author
    foreach (\Auth::user()->follows as $follows) {
      //If you are, you're good to go
      if($follows->id === $user->id) return $next($request);
    }

    //Else, you're forbidden
    return response('Forbidden', 403);
	}

}
