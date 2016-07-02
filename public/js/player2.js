/**
 * Created by kmasteryc on 6/30/16.
 */
$(document).ready(function () {
    // Get JSON from server! or from old cookie
    var json_data = getJson();
    var totalIndex = json_data.length;
    var current_index = 0;
    var current_song = json_data[current_index];
    var player = $('#player');
    var lyric = '';
    var s_duration = '';
    var has_time_lyric = false;
    var volume = 0.9;
    // 1- Song; 2- Playlist; 3-Radio
    // var mode = 1;
    var mode = player_config.mode;

    // Set song for first time
    setSong(current_song);
    if (mode == 2) {
        showList();
    }
    console.log('Why it is not effect?');
    // test THIS BRAND :D
    // console.log(json_data);
    function setSong(song){
        $("#song_source").attr('src',song.song_mp3);

        $(".lyric-1").html(song.song_title);
        $(".lyric-2").html(song.song_artist);

        if (song.song_lyric != null) {
            lyric = processLyric(song.song_lyric);
            has_time_lyric = true;
        }else{
            has_time_lyric = false;
        }

        $(".player-background").css('background-image',"url('"+song.song_img+"')");

        player.trigger('stop');
        player.trigger('load');
        player.prop('volume', volume);

        proccessSong();
    }

    // Handle after loading fully audio
    function proccessSong() {
        player.bind('loadedmetadata', function () {
            s_duration = player.prop('duration');
            // Show duration
            // Call toMinutes function for converting second to minutes
            var duration = toMinutes(s_duration);
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
                // Finish playing -> next song
                if (s_currentTime == s_duration) {
                    setSong(json_data[nextIndex()]);
                }
                // Start update lyric to player
                if (has_time_lyric == true) {
                    // Call getLyric
                    cur_lyr = getLyric(s_currentTime, lyric);
                    var width = (s_currentTime - cur_lyr.start) * 100 / cur_lyr.dur;
                    // Modify width a bit
                    // width = width > 93 ? width += 15 : width;
                    // Compare old lyc and new lrc. If have update -> replace html
                    if (JSON.stringify(old_lyr) != JSON.stringify(cur_lyr)) {
                        deactive = active == 1 ? 2 : 1;
                        // Show lyric when it is not empty
                        if (cur_lyr.lyr != '') {
                            $('.lyric-' + active).html(cur_lyr.lyr+'<span class="kara" style="width: ' + width + '%">' + cur_lyr.lyr + '</span>');
                            // $('.lyric-' + active).append();
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
        });
    }

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
    }

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
        var result;

        // Get time [mm:ss] from lyric
        timeArr = getTimeArr(lyric);
        currentTime = parseFloat(currentTime);

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

    function getJson(){
        var json_data;
        $.ajax({
            url : player_config.api_url,
            method: 'GET',
            async: false,
            success: function(response){
                json_data = response;
            }
        });
        return json_data;
    }

    function showList()
    {
        $("#player-playlist").html('');
        var html = '';
        for (x=0;x<json_data.length-1;x++)
        {
            var active = current_index==x ? 'list-group-item-info' : '' ;
            html += '<li class="list-group-item '+active+'">';
                html += '<span class="pull-left">';
                html += (x+1)+'. ';
                html += '<a href="#" class="changesong" data-index="'+x+'">'+json_data[x].song_title+'</a> - '+json_data[x].song_artist;
                html += '</span>';
                html += '<span class="pull-right">';
                    html += '<a href="'+json_data[x].song_mp3+'"><i class="fa fa-download"></i></a>';
                    html += ' <i class="fa fa-plus"></i>';
                    html += ' <a href="'+base_url+'song/'+json_data[x].song_id+'"><i class="fa fa-arrow-right"></i></a>';
                html += '</span>';
                html += '<div class="clearfix"></div>';
            html += '</li>';
        }
        $("#player-playlist").html(html);
    }

    function showMode()
    {

    }

    function nextIndex(){
        if (current_index == (totalIndex-1)) {
            current_index = 0;
        }else{
            current_index++;
        }
        return current_index
    }

    function prevIndex(){
        if (current_index == 0) {
            current_index = 0;
        }else{
            current_index--;
        }
        return current_index
    }

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
    $(document).on('click', ".fa-step-forward", function () {
        event.preventDefault();
        setSong(json_data[nextIndex()]);
        showList();
    });
    $(document).on('click', ".fa-step-backward", function () {
        event.preventDefault();
        setSong(json_data[prevIndex()]);
        showList();
    });
    $(document).on('click', ".fa-pause", function () {
        player.trigger('pause');
        $(this).removeClass('fa-pause');
        $(this).addClass('fa-play');
        // $(this).parent().prepend('<i class="fa fa-2x fa-play"></i>');
        // $(this).remove();
    });
    // Process volume
    $("#volume").bind('change', function () {
        volume = $(this).val() / 100;
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

    // Change song
    $(document).on('click', ".changesong", function () {
        event.preventDefault();
        current_index = $(this).data('index');
        setSong(json_data[current_index]);
        showList();
    });
});


