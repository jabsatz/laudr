$(function(){

  var localStreamMedia = false, audioBlob = null;

  function recordPostSwitch(){
    if($('.rec-btn').css('opacity') != 0){
      $('.rec-btn').animate({opacity: 0, width: 0}, 800);
      $('.new-audio').animate({opacity: 1, width: '70%'}, 1500);
    } else {
      $('.rec-btn').show();
      $('.rec-btn').animate({opacity: 1, width: '150px'}, 1500);
      $('.new-audio').animate({opacity: 0, width: '50%'}, 800);
    }
  }

  function startUserMedia(stream) {
    localStreamMedia = stream;
    audio_context    = new AudioContext;
    var input        = audio_context.createMediaStreamSource(stream);
    recorder         = new Recorder(input);
    audioEnabled     = true;
    startRecording();
  }

  function startRecording() {
    $('.rec-btn').removeClass('icon-mic');
    $('.rec-btn').addClass('icon-stop');

    recorder && recorder.record();
  }

  function stopRecording() {
    $('.rec-btn').removeClass('icon-stop');
    $('.rec-btn').addClass('icon-mic');
    recordPostSwitch();

    recorder && recorder.stop();
    
    createAudioItem();
    
    recorder.clear();
  }

  function createAudioItem() {
    recorder && recorder.exportWAV(function(blob) {
      audioBlob = blob;
      var url = URL.createObjectURL(blob);
      $('.new-audio audio').attr('src', url).attr('controls', true);
    });
  }
  
  //Onclick rec button...
  $('.rec-btn').on('click', function(){

    //If there isn't a stream of media playing...
    if(!localStreamMedia){
      
      //Normalize getUserMedia for different browsers
      navigator.getUserMedia  = navigator.getUserMedia ||
                                navigator.webkitGetUserMedia ||
                                navigator.mozGetUserMedia ||
                                navigator.msGetUserMedia;


      navigator.getUserMedia({audio: true}, startUserMedia, function(e){
        console.log('No audio livestream');
      });

    } else {

      stopRecording();

      //This is important: it stops the media stream, so
      //the user knows we can no longer hear what he says
      localStreamMedia.stop();
      localStreamMedia = false;

    }

  });

  $('.redo-btn').on('click', function(){
    recordPostSwitch();
  });

  $('.submit-btn').on('click', function(){
    var errors = 0;
    $(this).siblings('.validate').each(function(){
      if($(this).val() === ''){
        console.log($(this));
        errors++;
        $(this).addClass('error');
      } else if ($(this).hasClass('error')){
        $(this).removeClass('error');
      }
    });
    if(errors>0){
      alert('There are mistakes in the form')
      errors = 0;
    } else {
      //Good to go
      var formData = new FormData();
      formData.append('title', $('#title').val());
      formData.append('sound', audioBlob);
      
      $.ajax({
        headers: {
          'X-CSRF-Token': $('.new-audio > input[name="_token"]').val()
        },
        type: $('.new-audio').attr('method'),
        url: $('.new-audio').attr('action'),
        data: formData,
        processData: false,
        contentType: false,
        success: function(message){
          console.log(message);
        }
      });
    }
  });

});