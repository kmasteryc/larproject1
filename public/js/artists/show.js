/**
 * Created by kmasteryc on 7/4/16.
 */
$(document).ready(function () {

    // Call lightSlider to show Playlist
    $('#artist-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    var api_1 = base_url + 'api/get-songs-by-artist/' + artist;
    var api_2 = base_url + 'api/get-albums-by-artist/' + artist;

    var json_data = '';

    var song_box = $("#list-song");
    var song_paginate = $("#song-paginate");

    var album_box = $("#list-album");
    var album_paginate = $("#album-pageinate");

    loadSongData(api_1);
    // loadAlbumData(api_2);

    showSongLinks();
    // showAlbumLinks();

    function loadSongData(url) {
        song_box.html(showAjaxIcon());

        $.get(url).success(function (response) {
            console.log(response);
            json_data = response;
            var html = '';

            songs = response.data;
            for (var x in songs) {
                html += '<li class="list-group-item"> ' +
                    '<span class="pull-left"><a href="">' + songs[x].song_title + '</a> - ' + songs[x].song_artists_title_text +
                    '</span> <span class="pull-right">Some action here!</span> ' +
                    '<div class="clearfix"></div> ' +
                    '</li>';
            }

            song_box.html(html);
            song_paginate.html(showSongLinks());
        });
    }

    function showSongLinks() {
        var html = '<nav><ul class="pagination">';

        html += json_data.prev_page_url ? '<li> <a href="#" data-type="song" class="ajax-load" data-api="' + json_data.prev_page_url + '"> Trước </a> </li> ' : '';

        for (var i = 1; i <= json_data.last_page; i++) {
            if (i == json_data.current_page) {
                html += '<li class="active"><a href="#">' + i + '</a></li>';
            } else {
                html += '<li><a href="#" class="ajax-load" data-type="song" data-api="' + api_1 + '?page=' + i + '">' + i + '</a></li>';
            }
        }
        html += json_data.next_page_url ? '<li> <a href="#" class="ajax-load" data-type="song" data-api="' + json_data.next_page_url + '"> Sau </a> </li> ' : '';
        html += '</ul></nav>';

        return html;
    }

    function loadAlbumData(url) {
        song_box.html(showAjaxIcon());

        $.get(url).success(function (response) {
            console.log(response);
            json_data = response;
            var html = '';

            songs = response.data;
            for (var x in songs) {
                html += '<li class="list-group-item"> ' +
                    '<span class="pull-left"><a href="">' + songs[x].song_title + '</a> - ' + songs[x].song_artists_title_text +
                    '</span> <span class="pull-right">Some action here!</span> ' +
                    '<div class="clearfix"></div> ' +
                    '</li>';
            }

            song_box.html(html);
            song_paginate.html(showLinks());
        });
    }



    $(document).on('click', '.ajax-load', function (event) {
        event.preventDefault();

        if ($(this).data('type') == 'song'){
            loadSongData($(this).data('api'));
        }
        if ($(this).data('type') == 'album'){
            loadAlbumData($(this).data('api'));
        }

    });
});
