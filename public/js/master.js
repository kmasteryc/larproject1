/**
 * Created by kmasteryc on 5/26/16.
 */
$(document).ready(function () {
    if ($(".datatable").length) {
        $(".datatable").dynatable();
    }

    var api = base_url + 'api/search';
    var input = $("#top-search-text");
    var result_box = $("#top-search-result");

    $("#top-search-form").hover(function () {
        if (input.val()!='') {
            result_box.show();
        }
    }, function(){
        result_box.hide();
    });

    // $("#top-search-btn").click(function () {
    input.keyup(function () {

        if (input.val()!='') {
            result_box.show();
            result_box.html(showAjaxIcon());

            var request = $.ajax({
                url: api,
                method: 'POST',
                async: true,
                data: 'search=' + input.val()
            });

            request.success(function (res) {
                console.log(res);
                var html = '';

                if (res.artists.length == 0 && res.playlists.length == 0 && res.songs.length == 0) {

                    html = "<i class='fa'>Không tìm thấy kết quả. Bạn tìm từ khóa khác nhé!</i>";

                } else {

                    if (res.artists.length > 0) {
                        html += "<i class='fa fa-user'> Nghệ sĩ</i><ol>";
                        for (var index in res.artists) {
                            html += "<a href='" + base_url + "artist/" + res.artists[index].id + "'><li>" + res.artists[index].artist_title + "</li></a>";
                        }
                        html += "</ol>";
                    }

                    if (res.playlists.length > 0) {
                        html += "<i class='fa fa-list'> Danh sách</i><ol>";
                        for (var index in res.playlists) {
                            html += "<a href='" + base_url + "playlist/" + res.playlists[index].id + "'><li>" + res.playlists[index].playlist_title + "</li></a>";
                        }
                        html += "</ol>";
                    }

                    if (res.songs.length > 0) {
                        html += "<i class='fa fa-music'> Bài hát</i><ol>";
                        for (var index in res.songs) {
                            html += "<a href='" + base_url + "song/" + res.songs[index].id + "'><li>" + res.songs[index].song_title + " <br /> <span class='search-artist'>"+res.songs[index].artists[0].artist_title+"</span></li></a>";
                        }
                        html += "</ol>";
                    }
                }

                result_box.html(html);
            });
        }
    });
});

function showAjaxIcon() {
    return '<img class="reload" src="' + base_url + 'img/reload.gif"/>';
}