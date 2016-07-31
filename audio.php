    <audio id='myaudio' loop='loop'>
      <source src='Korobeiniki.mp3' type='audio/mp3'>
    </audio>

    <script>
   var audio=document.getElementById('myaudio');
   audio.playbackRate = 1;
   function playaudio()
      {
        audio.play()
      }
    function pauseaudio()
      {
       audio.pause()
      }
    function resetaudio() 
     {
       audio.playbackRate = 1;
     }
    function speedUp() 
      {
	var newRate = audio.playbackRate + 0.2;
	if (newRate < 3) { 
	  audio.playbackRate = newRate;
	}
      }
    function slowDown() 
      {
	var newRate = audio.playbackRate - 0.2;
	if (newRate < .5) { 
	  audio.playbackRate = newRate;
	}
      }
    </script>

