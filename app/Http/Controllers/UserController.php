<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller {

  public function __construct()
  {
    $this->middleware('auth');
  }

	/**
	 * Display the specified resource.
	 *
	 * @param  User $user
	 * @return Response
	 */
	public function profile($user)
	{
		return $user;
	}

}
