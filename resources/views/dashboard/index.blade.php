@extends('layout')

@section('feed')

  <article class="new-laud">
    {!! Html::image($user->profile_picture, $user->username."'s profile picture", array('class' => 'fake-img')) !!}

    <button class="rec-btn icon-mic"></button>

    {!! Form::open(array('action' => 'LaudController@store', 'method' => 'POST', 'class' => 'new-audio')) !!}
      {!! Form::text('title', null, array('class' => 'form-item validate', 'placeholder' => 'Title', 'id' => 'title')) !!}
      <audio class="form-item"></audio>
      {!! Form::button('Post', array('class' => 'submit-btn')) !!}
      {!! Form::button('Do Over', array('class' => 'redo-btn')) !!}

    {!! Form::close() !!}
  </article>

  {{$user->username}}'s followers:
  @foreach($user->followers as $follower)
    {{ $follower->username }},
  @endforeach
  <br/>
  {{$user->username}} follows:
  @foreach($user->follows as $follows)
    {{ $follows->username }},
  @endforeach

  @foreach($lauds as $laud)
    <article class="laud">
    {!! Html::image($laud->user->profile_picture, $laud->user->username."'s profile picture", array('class' => 'fake-img')) !!}
      
      <div class="player-wrap">
        <header>
          <h1>{{ $laud->user->username }}</h1>
          <h2>{{ $laud->title }}</h2>
        </header>

        <audio controls class="player">
          <source src="{{ $laud->sound }}">
        </audio>

        <nav>
          {!! Form::open(array('action' => array('LaudController@destroy', $laud->id), 'method' => 'DELETE')) !!}
            {!! Form::submit('delete') !!}
          {!! Form::close() !!}
          <a href="#">reply</a>
          <a href="#">spread</a>
          <a href="#">share</a>
        </nav>

      </div>
    </article>
  @endforeach

@stop