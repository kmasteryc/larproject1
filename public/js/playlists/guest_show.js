/**
 * Created by kmasteryc on 6/28/16.
 */
$(document).ready(function () {
    var api_1 = base_url + 'api/get-user-playlists/false';
    var api_2 = base_url + 'api/import-playlist-to-playlist';
    var api_3 = base_url + 'api/reset-temp-playlist';

    var list_box = $("#playlist-popup").find(".modal-body .list-group");

    // TOOL PLAYLIST
    $(document).on('click', '#import-temp-playlist', function () {

        $("#playlist-popup").modal();
        loadPlaylist();

    });

    $(document).on('click', '#delete-temp-playlist', function () {

        $.get(api_3);
        alert('Danh sách tạm đã được xóa! Bạn đang trở về trang chủ...');
        window.location.href = base_url;

    });

    $(document).on('click', '.add-this-playlist-to-me', function () {

        list_box.html('<img class="reload" src="' + base_url + 'img/reload.gif"/>');
        
        var playlistid = $(this).data('playlistid');

        $.ajax({
            url: api_2,
            method: 'POST',
            data: 'data=' + JSON.stringify({
                playlist_id: playlistid
            }),
            success: function (response) {
                loadPlaylist();
                $('#add-song-alert').removeClass('text-danger');
                $('#add-song-alert').addClass('text-success');
                $('#add-song-alert').html("Nhập bài hát thành công!");
            }
        });
        
    });

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
                    if (playlists[index].id != 0) {
                        html += "<li class='list-group-item clearfix'>";
                        html += "<span class='pull-left add-this-playlist-to-me' data-playlistindex='" + index + "' data-playlistid='" + playlists[index].id + "'>";
                        html += playlists[index].playlist_title;
                        html += "</span>";
                        html += "<span class='pull-right'>";
                        html += "<a href='" + base_url + "playlist/" + playlists[index].id + "'><i class='fa fa-play-circle'></i></a>";
                        html += "</span>";
                        html += "</li>";
                    }
                }
                list_box.html(html);
            }
        });
    }

});
