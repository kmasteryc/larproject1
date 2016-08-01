/**
 * Created by kmasteryc on 7/4/16.
 */
$(document).ready(function () {

    // Set image header

    // Call lightSlider to show Playlist
    $('#artist-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    var api_1 = base_url + 'api/get-songs-by-artist/' + artist;

    var json_data = '';

    var song_box = $("#hot-song");
    var song_paginate = $("#song-paginate");

    loadSongData(api_1);

    showSongLinks();

    function loadSongData(url) {
        song_box.html(showAjaxIcon());

        $.get(url).success(function (response) {
            console.log(response);
            json_data = response;
            var html = '';

            songs = response.data;
            for (var x in songs) {
                html += `
                <li class="list-group-item">
                    <div class="clearfix">
                        <span class="pull-left">
                            <a href="${base_url+'bai-hat/'+songs[x].song_title_slug+'.html'}">${songs[x].song_title}</a> - 
                            ${renderArtists(songs[x].artists)}
                        </span>
                        <span class="pull-right">
                            <a href="#">
                                <i class="fa fa-plus" 
                                    data-songid="${songs[x].id}" 
                                    data-songtitle="${songs[x].song_title}" 
                                    data-songartist="${songs[x].song_artist_id}">
                                </i>
                            </a>
                            <a href="${songs[x].song_mp3}">
                                <i class="fa fa-download"></i>
                            </a>
                        </span>
                    </div>
                </li>
                `;
            }

            song_box.html(html);
            song_paginate.html(showSongLinks());
        });
    }

    function showSongLinks() {
        if (json_data.prev_page_url == null && json_data.prev_page_url == null)
        {
            return;
        }
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

    $(document).on('click', '.ajax-load', function (event) {
        event.preventDefault();

        if ($(this).data('type') == 'song') {
            loadSongData($(this).data('api'));
        }
        if ($(this).data('type') == 'album') {
            loadAlbumData($(this).data('api'));
        }

    });
});
