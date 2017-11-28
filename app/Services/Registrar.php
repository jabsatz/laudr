<?php namespace App\Services;

use App\Follow;
use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Illuminate\Http\Request;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
    $file_name = make_file_name('.jpg');

    $data['profile_picture']->move(public_path(profile_picture()), $file_name);

    $user = new User;

    $user->username        = $data['name'];
    $user->email           = $data['email'];
    $user->password        = bcrypt($data['password']);
    $user->profile_picture = $file_name;
    $user->private         = $data['private'] === 'on';

    $user->save();

    Follow::create([
      'follower_id' => $user->id,
      'user_id'     => $user->id]);

    return $user;
	}

}
