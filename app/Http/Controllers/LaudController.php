<?php namespace App\Http\Controllers;

use App\Laud;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Storage;

class LaudController extends Controller {

  protected $url;

  public function __construct()
  {
    //Only authentified users can see this
    $this->middleware('auth');

    //Check if laud is private for a show request
    $this->middleware('privatelaud', ['only' => 'show']);
  }

  /**
   * Display all lauds available.
   *
   * @return Response
   */
  public function index()
  {
    $lauds = Laud::getIndex();

    return $lauds;
  }

  /**
   * Display the specified laud.
   *
   * @param  Laud $laud
   * @return Response
   */
  public function show(Laud $laud)
  {
    return $laud;
  }

  /**
   * Store a newly created laud in storage.
   *
   * @return Response
   */
  public function store()
  {
    $sound = Request::file('sound');
    $title = Request::get('title');
    $file_name = make_file_name('.mp3');

    if(!$sound->isValid()){
      return $sound->getError();
    }

    $sound->move(public_path(audio()), $file_name);

    $laud = new Laud;
    $laud->title   = $title;
    $laud->sound   = $file_name;
    $laud->user_id = \Auth::user()->id;
    $laud->save;

    return response($laud, 201);
  }

  /**
   * Update the specified laud in storage.
   *
   * @param  Laud $laud
   * @return Response
   */
  public function update(Laud $laud)
  {
    $laud->update(Request::all());

    return $laud;
  }

  /**
   * Remove the specified laud from storage.
   *
   * @param  Laud $laud
   * @return Response
   */
  public function destroy(Laud $laud)
  {
    Storage::delete(audio($laud->sound));

    $laud->delete();

    return response('',204);
  }

}
