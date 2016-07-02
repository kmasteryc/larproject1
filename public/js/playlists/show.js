/**
 * Created by kmasteryc on 6/28/16.
 */
$(document).ready(function () {
    var api_1 = base_url + 'api/get-user-playlists/';
    var api_2 = base_url + 'api/add-song-to-playlist/';

    $("#show-playlist-info").click(function (e) {
        e.preventDefault();
        $('.playlist-info-hidden').show();
        $('.playlist-info').hide();
        $(this).hide();
    });

    var list_box = $("#playlist-popup").find(".modal-body .list-group");
    var save_me_to_memory = {};
    var save_me_too;

    $(".fa-plus").click(function () {
        save_me_to_memory['song_id'] = $(this).data('songid');
        save_me_to_memory['song_title'] = $(this).data('songtitle');
        save_me_to_memory['song_artist'] = $(this).data('songartist');

        $("#playlist-popup").modal();
        loadPlaylist();
    })

    $(document).on('click', '.add-this-song-to-me', function () {

        var playlistid = $(this).data('playlistid');
        var playlistindex = $(this).data('playlistindex');
        var arr_songs_in = save_me_too[playlistindex].playlist_songs_id.split(',');

        if (arr_songs_in.indexOf(save_me_to_memory['song_id'].toString()) != -1) {
            $('#add-song-alert').removeClass('text-success');
            $('#add-song-alert').addClass('text-danger');
            $('#add-song-alert').html("Bài hát đã tồn tại trong danh sách!");
        }
        else {
            save_me_too[playlistindex].playlist_songs_id += ',' + save_me_to_memory['song_id'];

            $.ajax({
                url: api_2,
                method: 'POST',
                data: 'data=' + JSON.stringify({
                    song_id: save_me_to_memory['song_id'],
                    playlist_id: save_me_too[playlistindex].id
                }),
                success: function (response) {
                    console.log(response);
                }
            });

            $('#add-song-alert').removeClass('text-danger');
            $('#add-song-alert').addClass('text-success');
            $('#add-song-alert').html("Thêm bài hát thành công!");

            loadPlaylist();
        }

    })
    function loadPlaylist() {
        list_box.html('<img class="reload" src="' + base_url + 'img/reload.gif"/>');
        $('#add-song-alert').html('');
        $.ajax({
            url: api_1,
            method: 'GET',
            async: true,
            success: function (response) {
                var html = '';
                playlists = response;
                save_me_too = playlists;
                for (var index in playlists) {
                    html += "<li class='list-group-item add-this-song-to-me' data-playlistindex='" + index + "' data-playlistid='" + playlists[index].id + "'>";
                    html += playlists[index].playlist_title;
                    html += " (" + playlists[index].total_songs + " bài)";
                    html += "<span class='pull-right'>" +
                        "<a href='" + base_url + "playlist/" + playlists[index].id + "'><i class='fa fa-play'></i></a>" +
                        "<a href='" + base_url + "playlist/" + playlists[index].id + "/edit'><i class='fa fa-gear'></i></a>" +
                        "</span>";
                    html += "</li>";
                }
                list_box.html(html);
            }
        });
    }

});
