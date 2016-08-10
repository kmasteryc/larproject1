<div id="buildin-player">
    <audio controls="controls" id="player" autoplay>
        <source id="song_source" src="">
    </audio>
</div>
<div id="my-player">
    <div class="player-background"></div>
    <div class="player-mask"></div>
    <div class="lyric-bar">
        <div class="lyric-content">
            <div class="lyric">
                <p class="lyric-1"></p>
            </div>
            <br/>
            <div class="lyric">
                <p class="lyric-2"></p>
            </div>
        </div>
    </div>
    <div class="seek-bar">
        <div id="seek">
            <span id="seek-cursor" class="fa fa-circle"></span>
        </div>
        {{--<input class="bar" id="seek" type="range" value="0"/>--}}
    </div>
    <div class="control-bar">
        <div class="player-button">
            <a href="">
                <i class="fa fa-2x fa-step-backward"></i>
            </a>
            <i class="fa fa-2x fa-play play-pause"></i>
            <a href="">
                <i class="fa fa-2x fa-step-forward"></i>
            </a>
            <i class="fa fa-2x fa-volume-up volume"></i>
            <span class="volume-bar">
                <input class="bar" id="volume" type="range" value="90"/>
            </span>
            <span class="process-bar">
                <span class="current-time">00</span>/
                <span class="duration"></span>
            </span>
            <i class="player-mode"></i>
        </div>
    </div>
</div>
