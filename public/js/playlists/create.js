/**
 * Created by kmasteryc on 5/26/16.
 */
$(document).ready(function () {
    $("#input_songs").keyup(function () {
        search = $(this).val();

        if (search.length=0){
            return;
        }

        var request = $.ajax({
            'url': base_url + 'api/search',
            'data' : 'type=song&search='+search,
            'method': 'POST'
        });

        request.done(function (response) {
            $(".popup").html('');
            if (response.length > 0) {
                var i = 1;
                for (var k in response) {
                    var row = response[k];
                    var content = i + '. ' + row.song_title + ' | ' + row.artists[0].artist_title;
                    $(".popup").append("" +
                        "<a href='#' class='list-group-item list-group-item-primary a_choose_song' " +
                        "data-id='" + row.id + "' "
                        + "data-song_title='" + row.song_title + "' "
                        + "data-song_artists='" + row.song_artists_title + "'>"
                        + content +
                        "</a>"
                    );
                    i++;
                }
            }
            else {
                $(".popup").html("<a class='list-group-item'>Not found!</a>");
            }
            $(".popup").append("<a href='#' class='list-group-item list-group-item-danger' id='a_close_popup'>Close</a>");
        });

        //$(".popup").width($(this).width());
        $(".popup").show();
    });
})

$(document).on('click', '.a_choose_song', function () {

    var song_choose = $(this).data('id');
    var cur_songs = $("#playlist_songs").val();
    //if (cur_songs != '') {
    var arr_cur_songs = cur_songs.split(',');

    if (arr_cur_songs.indexOf(song_choose.toString()) == -1) {
        var song_field = '<a href="#" class="list-group-item list-group-item-info a_remove_song" '
            + 'data-id="' + $(this).data('id') + '">'
            + "<span class='pull-left series'></span>"
            + $(this).data('song_title')
            + "<span class='pull-right'>" + $(this).data('song_artists') + "</span>"
            + '</a>';

        new_songs = cur_songs + song_choose + ',';
        $("#playlist_songs").val(new_songs);

        $("#div_songs").append(song_field);
        $("#div_box_song").show();
    }
    else {
        alert('You have already selected song ' + $(this).data('song_title') + ' !');
    }

    // Set auto increment
    set_autoincrement();

    $(".popup").hide(500);
});
$(document).on('click', '.a_remove_song', function () {
    var song_choose = $(this).data('id');
    var cur_songs = $("#playlist_songs").val();
    var arr_cur_songs = cur_songs.split(',');

    /*Here you have 2 opts:
     First: Using str.replace
     Second: Use array.filter. I choose this*/

    arr_new_songs = arr_cur_songs.filter(function (song) {
        return song == song_choose ? '' : song;
    });

    $("#playlist_songs").val(arr_new_songs.toString());
    $(this).remove();

    set_autoincrement();

    // If there is no left. Close song div too
    if ($("#playlist_songs").val() == '') {
        $("#div_box_song").hide(500);
    }
});
$(document).on('click', '#a_close_popup', function () {
    $(this).parent().html('');
});
function set_autoincrement()
{
    var i = 1;
    $(".a_remove_song").each(function(){
        $(this).find('.series').html(i+'.  ');
        i++;
    });
}