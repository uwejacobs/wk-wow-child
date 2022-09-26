<?php ?>
<div class="feature video">
  <div class="video-bg">
    <?php $video_id = get_theme_mod('cover_yt_video_setting'); ?>
    <div id="video" class="animate video-wrapper">
      <div id="player"></div>
        <script type="text/javascript">
          var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
          if ( viewportWidth > 1024 || !'ontouchstart' in window || !navigator.maxTouchPoints){
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            var player;
            var playerWrapper = document.querySelector('#video');
            function onYouTubeIframeAPIReady() {
              player = new YT.Player('player', {
                videoId: '<?php echo $video_id; ?>',
                allowfullscreen: 1,
                playerVars: {
                  'enablejsapi': 1,
                  'autoplay': 1,
                  'rel': 0,
                  'iv_load_policy': 3,
                  'modestbranding': 1,
                  'playsinline': 1,
                  'controls': 0,
                  'loop': 1,
                  'disablekb': 1,
                  'color': 'white',
                  'origin': window.location.origin,
                  'mute': 1
                },
                events: {
                  'onReady': onPlayerReady,
                  'onStateChange': onPlayerStateChange
                }
                });
            }

            function onPlayerReady() {
              player.playVideo();
              player.mute();
            }
            function onPlayerStateChange(el) {
              if(el.data === 1) {
                playerWrapper.classList.add('fadein')
              } else if(el.data === 0) {
                // playerWrapper.classList.remove('fadein')
                player.playVideo();
                player.mute();
              }
            }
        }
        </script>
    </div>
  </div>
</div>

<style type="text/css">
.feature.video, .video-bg {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
.feature.video {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  height: 100vh;
  width: 100%;
  z-index: -1;
  overflow: hidden;
}
.video-wrapper {
  overflow: hidden;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  display: block;
  height: 0;
  width: 100%;
  padding: 0;
  padding-bottom: 56.25%;
  <?php $video_opacity = floatval(get_theme_mod('cover_yt_video_opacity_setting'));
        if ($video_opacity < 0.1 || $video_opacity > 1.0) $video_opacity = 0.5; ?>
  opacity: <?php echo $video_opacity; ?>;
}
.video-wrapper iframe {
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  pointer-events: none;
}

.video-bg {
  height: 100%;
}

@media (max-width: 1024px) {
  .video-bg:before {
    content: "";
    background-color: <?php echo get_theme_mod('main_color', '#000'); ?>;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
  }
}
</style>
<script type="text/javascript">
function video() {
    var video = document.querySelector('.video-wrapper');

    if (video !== null) {
      var wrapperWidth = window.outerWidth,
          videoWidth = video.offsetWidth,
          videoHeight = video.offsetHeight; 
          
      //this is to get around the elastic url bar on mobiles like ios...
      if (wrapperWidth < 1024) {
        var wrapperHeight = window.innerHeight + 200;
      } else {
        var wrapperHeight = window.innerHeight;
      }

      var scale = Math.max(wrapperWidth / videoWidth, wrapperHeight / videoHeight);
      document.querySelector('.video-wrapper').style.transform = "translate(-50%, -50%) " + "scale(" + scale + ")";
    }
}

video();

window.onresize = function (event) {
  video();
};
</script>