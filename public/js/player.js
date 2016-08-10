/**
 * Created by kmasteryc on 6/30/16.
 */
$(document).ready(function () {
    // Get JSON from server!
    var json_data = '';
    var totalIndex = 0;
    var current_index = 0;
    var current_song = 0;
    var player = $('#player');
    var lyric = '';
    var s_duration = '';
    var has_time_lyric = false;
    var volume = 0.9;
    var player_type = 1;
    var empty_playlist = false;
    var play_pause = $(".play-pause");
    var active = 1;
    var deactive = 2;
    var myInterval = '';
    var old_lyr = '';
    var cur_lyr = '';

    var mode = player_config.mode;
    var temp_playlist = player_config.temp_playlist ? true : false;

    switch (mode) {
        case 1: // Single song player
            $(".fa-step-backward").hide();
            $(".fa-step-forward").hide();
            break;
        case 2: // Playlist
            setPlayType(player_type);
            // showList();
            break;
        case 3: // Radio
            break;
    }

    getJson();

    function setSong(json_data) {
        reset();
        var song = json_data[current_index];
        $("#song_source").attr('src', song.song_mp3);
        $.get(base_url + 'api/increase_view_song/'+current_song.song_id);

        $(".lyric-1").html(song.song_title);
        $(".lyric-2").html(song.song_artist);

        if (song.song_lyric != null) {
            lyric = processLyric(song.song_lyric);
            has_time_lyric = true;
        } else {
            has_time_lyric = false;
        }

        $(".player-background").css('background-image', "url('" + song.song_img + "')");
        // $(".player-background").css('background-size', "contain");

        player.trigger('stop');
        player.trigger('load');
        player.prop('volume', volume);
        player.trigger('play');

        // var play_pause = $(".fa-play");
        // play_pause.removeClass("fa-play");
        // play_pause.addClass("fa-pause");

        if (typeof myInterval != 'undefined') {
            clearInterval(myInterval);
        }

        showNontimeLyrics(song.song_id);
        proccessSong(json_data);

    }

    function getJson() {

        var json_data;
        $.ajax({
            url: player_config.api_url_1,
            method: 'GET',
            // async: false,
            success: function (response) {
                json_data = response;
                current_index = 0;
                current_song = json_data[current_index];
                totalIndex = json_data.length;
                setSong(json_data);
                showList(json_data);
                // Both User playlist and temp playlist are empty!
                if (json_data == '') {
                    empty_playlist = true;
                    $(".control-bar").hide();
                    $(".seek-bar").hide();
                    $("#buildin-player").html('Danh sách trống - Vui lòng thêm bài hát');
                    $(".lyric-1").html('Danh sách trống');
                    $(".lyric-2").html('Vui lòng thêm bài hát');
                }

                $(document).on('click', ".changesong", function (event) {
                    event.preventDefault();
                    current_index = $(this).data('index');
                    setSong(json_data);
                    showList(json_data);
                });

                // Process seeking
                $('#seek').click(function (e) {
                    reset();
                    // Set cursor
                    player.trigger('seek');
                    var player_width = $("#my-player").innerWidth();
                    var click_X = e.pageX - $("#my-player").offset().left;
                    var click_percent = click_X * 100 / player_width;
                    $('#seek #seek-cursor').css('left', click_percent + '%');

                    // Set player time
                    player.prop('currentTime', click_percent * s_duration / 100);
                });

                // Process play-pause
                $(document).on('click', ".fa-play", function () {
                    player.trigger('play');
                });

                $(document).on('click', ".fa-pause", function () {
                    player.trigger('pause');
                });

                // Process playtype click
                $(document).on('click', ".fa-thumb-tack", function () {
                    setPlayType(3, json_data);
                });
                $(document).on('click', ".fa-refresh", function () {
                    setPlayType(2, json_data);
                });
                $(document).on('click', ".fa-random", function () {
                    setPlayType(1, json_data);
                });

                // Process next click
                $(document).on('click', ".fa-step-forward", function (event) {
                    event.preventDefault();
                    current_index = nextIndex();
                    setSong(json_data);
                    showList(json_data);
                });
                // Process prev click
                $(document).on('click', ".fa-step-backward", function (event) {
                    event.preventDefault();
                    current_index = prevIndex();
                    setSong(json_data);
                    showList(json_data);
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

            }
        });
        return json_data;
    }

    function reset() {
        $(".lyric-1").html('');
        $(".lyric-2").html('');
        old_lyr = '';
        cur_lyr = '';
        active = 1;
        deactive = 2;
    }

    // Handle after loading fully audio
    function proccessSong(json_data) {
        player.bind('loadedmetadata', function () {

            s_duration = player.prop('duration');
            // Show duration
            // Call toMinutes function for converting second to minutes
            var duration = toMinutes(s_duration);
            $(".duration").html(duration);

            // Update current time
            myInterval = setInterval(function () {
                if (player.prop('paused') === false) {
                    var s_currentTime = player.prop('currentTime');
                    // Call toMinutes function for converting second to minutes
                    currentTime = toMinutes(s_currentTime);
                    // Show current time
                    $(".current-time").html(currentTime);
                    // Set seek-point
                    var percent_done = player.prop('currentTime') * 100 / player.prop('duration');
                    $('#seek #seek-cursor').css('left', percent_done - 1 + '%');

                    // Start update lyric to player
                    var width = 0;
                    if (has_time_lyric == true) {

                        cur_lyr = getLyric(s_currentTime, lyric);

                        if (cur_lyr != undefined) {

                            if (JSON.stringify(old_lyr) != JSON.stringify(cur_lyr)) {

                                $('.lyric-' + active).html(cur_lyr.next_lyr + '<span class="kara" style="width: 0%">' + cur_lyr.next_lyr + '</span>');
                                var temp = active;
                                active = deactive;
                                deactive = temp;
                                old_lyr = cur_lyr;

                            }
                            else {

                                width = (s_currentTime - cur_lyr.start) * 100 / cur_lyr.dur;
                                $('.lyric-' + active).html(cur_lyr.lyr + '<span class="kara" style="width: ' + width + '%">' + cur_lyr.lyr + '</span>');

                            }
                        }
                    }
                } else {

                    // Finish playing -> next song
                    if (player.prop('ended') === true) {
                        current_index = nextIndex();
                        setSong(json_data);
                        if (mode == 2) showList(json_data);
                    }
                }
            }, 50);
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

                // Remove after show it
                timeArr = timeArr.slice(key);
                return false;
            } else {
                return true;
            }
        });
        return result;
    }

    function showList(json_data) {
        if (mode != 2) {
            return;
        }
        $("#player-playlist").html('');
        var html = '';
        for (x = 0; x < json_data.length; x++) {
            var active = current_index == x ? 'list-group-item-info' : '';
            html += '<li class="list-group-item ' + active + '">';
            html += '<div class="clearfix"><span class="pull-left">';
            html += (x + 1) + '. ';
            html += '<a href="#" class="changesong" data-index="' + x + '">' + json_data[x].song_title + '</a> - ';

            html += renderArtists(json_data[x].artists);
            html += '</span>';
            html += '<span class="pull-right">';
            html += '<a href="' + json_data[x].song_mp3 + '"><i class="fa fa-download"></i></a>';

            if (temp_playlist === false) {
                html += ' <a href="#"><i class="fa fa-plus" data-songid="' + json_data[x].song_id + '" data-songtitle="' + json_data[x].song_title + '" data-songartist="' + json_data[x].song_artist + '"></i></a>';
                html += ' <a href="' + base_url + 'bai-hat/' + json_data[x].song_title_slug + '.html"><i class="fa fa-share"></i></a>';
            }
            html += '</span>';
            html += '</div>';
            html += '</li>';
        }
        // console.log(html);
        $("#player-playlist").html(html);
        $("#player-playlist").show();
    }

    function showNontimeLyrics(song_id) {
        $("#lyric-area").html(showAjaxIcon());
        $.ajax({
            url: player_config.api_url_2 + "/" + song_id,
            method: 'GET',
            async: true,
            success: function (response) {
                var lyrics_data = response;

                if (lyrics_data != '') {
                    if (typeof lyrics_data != undefined) {
                        var html = `
                            <div id="lyric-btn"><h4><i class="fa fa-sticky-note"></i> Lời bài hát </h4> <button class="btn btn-primary btn-sm" id="hide-show-lyric-btn">Ẩn</button></div>
                            <div id="lyric-content">
                                ${lyrics_data.lyric_content}
                            </div>
                    `;

                        $("#lyric-area").html(html);
                    }
                }
                else {
                    $("#lyric-area").html('');
                }
            },
        });
        return json_data;
    }

    function setPlayType(type, json_data) {
        player_type = type;
        var class_icon, play_type_text;
        switch (type) {
            case 1: // Repeat all
                class_icon = 'fa fa-refresh';
                play_type_text = ' Lặp toàn bộ';
                player.prop('loop', false);
                break;
            case 2: // Repeat one
                class_icon = 'fa fa-thumb-tack';
                play_type_text = ' Lặp bài này';
                player.prop('loop', true);
                break;
            case 3: // Shuffle mode
                class_icon = 'fa fa-random';
                play_type_text = ' Ngẫu nhiên';
                json_data = shuffleArr(json_data);
                showList(json_data);
                player.prop('loop', false);
                break;
        }
        $(".player-mode").removeClass("fa fa-thumb-tack");
        $(".player-mode").removeClass("fa fa-refresh");
        $(".player-mode").removeClass("fa fa-random");
        $(".player-mode").addClass(class_icon);
        $(".player-mode").html(play_type_text);
    }

    function nextIndex() {
        if (current_index == (totalIndex - 1)) {
            current_index = 0;
        } else {
            current_index++;
        }
        return current_index
    }

    function prevIndex() {
        if (current_index == 0) {
            current_index = 0;
        } else {
            current_index--;
        }
        return current_index
    }

    function shuffleArr(array) {
        var currentIndex = array.length, temporaryValue, randomIndex;

        // While there remain elements to shuffle...
        while (0 !== currentIndex) {

            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex -= 1;

            // And swap it with the current element.
            temporaryValue = array[currentIndex];
            array[currentIndex] = array[randomIndex];
            array[randomIndex] = temporaryValue;
        }

        return array;
    }

    player.on('stop', function () {
        // var play_pause = $(".fa-play");
        play_pause.removeClass("fa-pause");
        play_pause.addClass("fa-play");
    });

    player.on('pause', function () {
        // console.log("Pause event!");
        play_pause.removeClass('fa-pause');
        play_pause.addClass('fa-play');
    });

    player.on('play', function () {
        // console.log("Pause event!");
        alert("Trigger play!");
        play_pause.removeClass('fa-play');
        play_pause.addClass('fa-pause');
    });
    $(document).on('click', "#hide-show-lyric-btn", function (event) {
        event.preventDefault();
        var html = $(this).html() == 'Hiện' ? 'Ẩn' : 'Hiện';
        $(this).html(html);
        $("#lyric-content").toggle();
    })
});


