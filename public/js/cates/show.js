/**
 * Created by kmasteryc on 7/4/16.
 */
$(document).ready(function () {

    // Call lightSlider to show Playlist

    var api_1 = base_url + 'api/get-ajax-hot-song/' + cate;
    var api_2 = base_url + 'api/get-ajax-hot-playlist/' + cate;

    var json_data_song = '';
    var json_data_playlist = '';
    var hot_song_box = $("#hot-song");
    var hot_song_paginate = $("#hot-song-pageinate");

    var hot_album_box = $("#hot-album");
    var hot_album_paginate = $("#hot-album-pageinate");


    loadDataPlaylist(api_2);
    showLinkPlaylist('playlist');

    loadDataSong(api_1);
    showLinkSong('song');

    function loadDataSong(url) {
        hot_song_box.html(showAjaxIcon());

        $.get(url).success(function (response) {
            json_data_song = response;
            var html = '';

            songs = response.data;

            for (var x in songs) {
                html += `
                <li class="list-group-item">
                <div class="clearfix">
                    <span class="pull-left">
                        <a href="${base_url+'bai-hat/'+songs[x].song_title_slug+'.html'}"> 
                            ${songs[x].song_title} 
                        </a> - ${renderArtists(songs[x].artists)}
                        </a>
                     </span>
                    <span class="pull-right">
                        <a href="#">
                        <i class="fa fa-plus" 
                            data-songid="${songs[x].id}" 
                            data-songtitle="${songs[x].song_title}" 
                            data-songartist="${songs[x].song_artist_id}"></i>
                        </a>
                        <a href="${songs[x].song_mp3}"><i class="fa fa-download"></i></a>
                    </span> 
                </div>
                </li>
                `;
            }

            hot_song_box.html(html);
            hot_song_paginate.html(showLinkSong('song'));
        });
    }

    function loadDataPlaylist(url) {
        hot_album_box.html(showAjaxIcon());

        $.get(url).success(function (response) {
            json_data_playlist = response;
            var html = '';

            var playlists = response.data;

            for (var x in playlists) {

                html += `
                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="thumbnail">
                            <img src="${playlists[x].playlist_img}" alt="${playlists[x].playlist_title}">
                            <div class="caption">
                                <h5>
                                    <a href="${base_url + 'playlist/' + playlists[x].playlist_title_slug + '.html'}">
                                        ${playlists[x].playlist_title}
                                    </a>
                                </h5>
                                <a href="${base_url + 'nghe-si/' + playlists[x].artist.artist_title_slug + '.html'}">
                                    ${playlists[x].artist.artist_title}
                                </a>
                            </div>
                        </div>
                    </div>
                `;

            }

            hot_album_box.html(html);
            hot_album_paginate.html(showLinkPlaylist('playlist'));
        });
    }

    function showLinkSong() {
        if (json_data_song.next_page_url == null && json_data_song.prev_page_url == null) {
            return;
        }
        console.log(json_data_song);
        var html = '<nav><ul class="pagination">';

        html += json_data_song.prev_page_url ? '<li> <a href="#" class="ajax-load" data-type="song" data-api="' + json_data_song.prev_page_url + '"> Trước </a> </li> ' : '';

        var start = 1;
        var end = json_data_song.last_page;

        if(json_data_song.last_page >10){
            start = json_data_song.current_page - 5;
            for (let i = start; i <= json_data_song.current_page; i++)
            {
                if (i>0){
                    start = i;
                    break;
                }
            }
            end = start + 10;

            if (end > json_data_song.last_page) end = json_data_song.last_page;

            if (json_data_song.current_page > (json_data_song.last_page/2)) {
                html += '<li><a href="#" class="ajax-load" data-type="song" data-api="' + api_2 + '?page=' + start + '">' + 1 + '</a></li>';
                html += '<li class="disabled"><span>...</span></li>';
                // start++;
            }
        }

        for (let i = start; i <= end; i++) {
            if (i == json_data_song.current_page) {
                html += '<li class="active"><a href="#">' + i + '</a></li>';
            } else {
                html += '<li><a href="#" class="ajax-load" data-type="song" data-api="' + api_1 + '?page=' + i + '">' + i + '</a></li>';
            }
        }

        if (json_data_song.current_page <= (json_data_song.last_page/2) ) {
            html += '<li class="disabled"><span>...</span></li>';
            html += '<li><a href="#" class="ajax-load" data-type="song" data-api="' + api_2 + '?page=' + json_data_song.last_page + '">' + json_data_song.last_page + '</a></li>';
        }

        html += json_data_song.next_page_url ? '<li> <a href="#" class="ajax-load" data-type="song" data-api="' + json_data_song.next_page_url + '"> Sau </a> </li> ' : '';
        html += '</ul></nav>';

        return html;
    }

    function showLinkPlaylist() {
        if (json_data_playlist.next_page_url == null && json_data_playlist.prev_page_url == null) {
            return;
        }
        console.log(json_data_playlist);
        var html = '<nav><ul class="pagination">';

        html += json_data_playlist.prev_page_url ? '<li> <a href="#" class="ajax-load" data-type="playlist" data-api="' + json_data_playlist.prev_page_url + '"> Trước </a> </li> ' : '';

        var start = 1;
        var end = json_data_playlist.last_page;

        if(json_data_playlist.last_page >10){
            start = json_data_playlist.current_page - 5;
            for (let i = start; i <= json_data_playlist.current_page; i++)
            {
                if (i>0){
                    start = i;
                    break;
                }
            }
            end = start + 10;

            if (end > json_data_playlist.last_page) end = json_data_playlist.last_page;

            if (json_data_playlist.current_page > (json_data_playlist.last_page/2)) {
                html += '<li><a href="#" class="ajax-load" data-type="playlist" data-api="' + api_2 + '?page=' + start + '">' + 1 + '</a></li>';
                html += '<li class="disabled"><span>...</span></li>';
                // start++;
            }
        }

        for (var i = start; i <= end; i++) {
            if (i == json_data_playlist.current_page) {
                html += '<li class="active"><a href="#">' + i + '</a></li>';
            } else {
                html += '<li><a href="#" class="ajax-load" data-type="playlist" data-api="' + api_2 + '?page=' + i + '">' + i + '</a></li>';
            }
        }

        if (json_data_playlist.current_page <= (json_data_playlist.last_page/2) ) {
            html += '<li class="disabled"><span>...</span></li>';
            html += '<li><a href="#" class="ajax-load" data-type="playlist" data-api="' + api_2 + '?page=' + json_data_playlist.last_page + '">' + json_data_playlist.last_page + '</a></li>';
        }

        html += json_data_playlist.next_page_url ? '<li> <a href="#" class="ajax-load" data-type="playlist" data-api="' + json_data_playlist.next_page_url + '"> Sau </a> </li> ' : '';
        html += '</ul></nav>';

        return html;
    }

    $(document).on('click', '.ajax-load', function (event) {
        event.preventDefault();

        if ($(this).data('type') == 'song') {
            loadDataSong($(this).data('api'));
        } else {
            loadDataPlaylist($(this).data('api'));
        }

    });
});
