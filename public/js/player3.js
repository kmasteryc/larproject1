/**
 * Created by kmasteryc on 6/20/16.
 */
$(document).ready(function () {
    var player = $('#player');
    var lyric;
    var config_player = pre_config_player;
    if (pre_lyric != 0) {
        lyric = processLyric(pre_lyric);
    }
    var arrTime = getTimeArr(lyric);

    // Handle after loading fully audio
    player.bind('loadedmetadata', function () {
        // Increase view
        $.get(base_url+'song/'+config_player['cur_song_id']+'/increase_view');
        var s_duration = player.prop('duration');
        // Show duration
        $(".current-time").html('0');
        // Call toMinutes function for converting second to minutes
        duration = toMinutes(s_duration);
        $(".duration").html(duration);
        // Update current time
        var old_lyr = 0;
        var cur_lyr;
        var active = 1;
        var deactive = 2;
        player.bind('timeupdate', function () {
            var s_currentTime = player.prop('currentTime');
            // Call toMinutes function for converting second to minutes
            currentTime = toMinutes(s_currentTime);
            // Show current time
            $(".current-time").html(currentTime);
            // Set seek-point
            $('#seek').val(player.prop('currentTime') * 100 / player.prop('duration'));
            // Finish playing -> set play icon
            if (s_currentTime == s_duration) {
                $('.fa-pause').trigger('click');

                if (config_player) {
                    switch (parseInt(config_player['mode'])) {
                        case 0: // no loop
                            if (config_player['next_index'] != 0) {
                                window.location.href = config_player['next_url'];
                            }
                            break;
                        case 1: // loop 1 song
                            window.location.href = window.location.href;
                            break;
                        case 2: // loop all
                            window.location.href = config_player['next_url'];
                            break;
                        case 3: // shuffle
                            window.location.href = config_player['next_url'];
                            break;
                    }
                }
            }
            // Start update lyric to player
            if (pre_lyric != 0) {
                // Call getLyric
                cur_lyr = getLyric(s_currentTime, lyric, arrTime);
                var width = (s_currentTime - cur_lyr.start) * 100 / cur_lyr.dur;
                // Modify width a bit
                // width = width > 93 ? width += 15 : width;
                // Compare old lyc and new lrc. If have update -> replace html
                if (JSON.stringify(old_lyr) != JSON.stringify(cur_lyr)) {
                    deactive = active == 1 ? 2 : 1;
                    // Show lyric when it is not empty
                    if (cur_lyr.lyr != '') {
                        $('.lyric-' + active).html(cur_lyr.lyr);
                        $('.lyric-' + active).append('<span class="kara" style="width: ' + width + '%">' + cur_lyr.lyr + '</span>');
                    }
                    // Check nextlyric if it is not empty
                    if (cur_lyr.next_lyr != '') {
                        $('.lyric-' + deactive).html(cur_lyr.next_lyr);
                    }
                    // Swap active and deactive
                    var temp = active;
                    active = deactive;
                    deactive = temp;
                    old_lyr = cur_lyr;
                } else {
                    // Else change kara width
                    $('.lyric-' + deactive + ' > .kara').css('width', width + '%');
                }
            }
        });
        //Process seeking
        $('#seek').change(function () {
            var seekTime = $(this).val() * s_duration / 100;
            player.prop('currentTime', seekTime);
        });
        // Process play-pause
        $(document).on('click', ".fa-play", function () {
            player.trigger('play');
            var play_pause_icon = $(this);
            $(this).removeClass('fa-play');
            $(this).addClass('fa-pause');
            // $(this).parent().prepend('<i class="fa fa-2x fa-pause"></i>');
            // $(this).remove();
        });
        $(document).on('click', ".fa-pause", function () {
            player.trigger('pause');
            var play_pause_icon = $(this);
            $(this).removeClass('fa-pause');
            $(this).addClass('fa-play');
            // $(this).parent().prepend('<i class="fa fa-2x fa-play"></i>');
            // $(this).remove();
        });
        // Process volume
        $("#volume").bind('change', function () {
            var volume = $(this).val() / 100;
            setConfig('volume',volume);
            player.prop('volume', volume);
            var volume_icon = $('.volume');
            if (volume < 0.5) {
                volume_icon.removeClass('fa-volume-up');
                volume_icon.removeClass('fa-volume-off');
                volume_icon.addClass('fa-volume-down');
            }
            if (volume > 0.5) {
                volume_icon.removeClass('fa-volume-down');
                volume_icon.removeClass('fa-volume-off');
                volume_icon.addClass('fa-volume-up');
            }
            if (volume == 0) {
                volume_icon.removeClass('fa-volume-up');
                volume_icon.removeClass('fa-volume-down');
                volume_icon.addClass('fa-volume-off');
            }
        });

        // Process repeat, shuffle
        $(document).on('click', ".fa-thumb-tack", function () {
            var temp = $(this);
            temp.removeClass('fa-thumb-tack');
            temp.addClass('fa-refresh');
            temp.html(' Lặp toàn bộ');
            player.removeAttr('loop');
            config_player['mode'] = 2;
            setConfig('mode',2);
        });
        $(document).on('click', ".fa-refresh", function () {
            var temp = $(this);
            temp.removeClass('fa-refresh');
            temp.addClass('fa-random');
            temp.html(' Ngẫu nhiên');
            player.removeAttr('loop');
            config_player['mode'] = 3;
            setConfig('mode',3);
        });
        $(document).on('click', ".fa-random", function () {
            var temp = $(this);
            temp.removeClass('fa-random');
            temp.addClass('fa-thumb-tack');
            temp.html(' Lặp bài này');
            player.attr('loop','true');
            config_player['mode'] = 1;
            setConfig('mode',1);
        });
    });
});
// Convert seconds to mm:ss
function toMinutes(second) {
    var minutes, min, sec;
    // Calculate (float) minutes
    minutes = second / 60;
    // Calculate (int) minutes
    min = Math.floor(minutes);
    // Second = float - int
    sec = Math.abs(60 * (minutes - min)).toFixed(0);
    // Format seccond as 00-format
    sec = sec < 10 ? ('0' + sec) : sec;
    return (min + ':' + sec);
};

function processLyric(lyric) {
    //test area
    var arr_lyr;
    var new_lyr = [];
    arr_lyr = lyric.split('\n');
    arr_lyr.forEach(function (cur, index) {
        var part, time, lyr;
        var sec, min;
        // Split [time] lyric
        part = cur.split(']');
        // Lyric is index-1 of part
        lyr = part[1];
        // Time is index-0 of part
        time = part[0].replace('[', '');
        // Convert time to seconds
        part = time.split(':');
        min = parseInt(part[0]);
        sec = parseFloat(part[1]);
        time = (min * 60 + sec).toFixed(2);
        // Assign to array for after process
        new_lyr[time] = lyr;
        // new_lyr.push({time:lyr});
    });
    return new_lyr;
}

function getTimeArr(lyric) {
    // Array format: $arr[time] = lyr
    // Create array of time lyric
    var arr_time = [];
    for (var time in lyric) {
        arr_time.push(time);
    }
    return arr_time;
}

function getLyric(currentTime, lyric, timeArr) {
    currentTime = parseFloat(currentTime);
    var result;
    timeArr.every(function (time_key, key) {
        if (currentTime >= time_key && currentTime < timeArr[key + 1] && !isNaN(timeArr[key + 1])) {
            result = {
                lyr: lyric[time_key],
                dur: timeArr[key + 1] - time_key,
                start: time_key,
                next_lyr: lyric[timeArr[key + 1]]
            };
            return false;
        } else {
            return true;
        }
    });
    return result;
}

// Send ajax request to server for saving config to session
function setConfig(k,v)
{
    var res;
    var request = $.ajax({
        url: base_url+'session/set/'+k+'/'+v,
        method: 'GET',
        async: true
    });
    request.success(function(response){
        res = response;
    });
}