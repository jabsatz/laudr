<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'private', 'profile_picture'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

  /**
   * A user has many Lauds
   * 
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function lauds()
  {
    return $this->hasMany('App\Laud');
  }
  /**
   * A user is followed by many users
   * 
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function followers(){
    return $this->belongsToMany('App\User', 'follows', 'user_id', 'follower_id')->withTimestamps();
  }
  /**
   * A user follows many users
   * 
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function follows(){
    return $this->belongsToMany('App\User', 'follows', 'follower_id', 'user_id')->withTimestamps();
  }

  public function getProfilePictureAttribute($value){
    return url(profile_picture($value));
  }


}
