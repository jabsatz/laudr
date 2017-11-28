<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\UrlGenerator;

class Laud extends Model {

  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'lauds';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
	protected $fillable = ['title','sound','user_id'];

  /**
   * A Laud has one User
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public static function getIndex(){
    foreach (\Auth::user()->follows as $following) {
      $follows[] = $following->id;
    }

    $lauds = Laud::with('user')->latest()->whereIn('user_id', $follows)->get();

    return $lauds;

  }


  /**
   * Accessor for sound - Gives full URL to resource
   * 
   * @return string
   */
  
  public function getSoundAttribute($value){
    return url(audio($value));
  }

}
