<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Laudr</title>
  {!! Html::style('/css/style.css') !!}
  {!! Html::script('http://code.jquery.com/jquery-2.1.3.min.js') !!}
  {!! Html::script('/js/recorderjs/recorder.js') !!}
  {!! Html::script('/js/record-btn.js') !!}
</head>
<body>
  <header id="top-header">
    <div class="wrapper">
      <h1 id="top-logo">
        <a href="/">Laudr</a>
      </h1>

      <nav id="main-menu">
        <a href="/profile">
          <span class="icon-user"></span>
          {{ $user->username }}
        </a>  
      <nav>
    </div>
  </header>
  
  <div id="main-wrapper">
    <div id="feed">
      @yield('feed')
    </div>

    <footer id="the-footer">

    </footer>
  </div>
</body>
</html>
