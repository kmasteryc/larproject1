/**
 * Created by kmasteryc on 5/26/16.
 */
$(document).ready(function () {
    $("#input_artists").keyup(function () {
        search = $(this).val();

        var request = $.ajax({
            'url': base_url + 'api/search',
            'data' : 'type=artist&search='+search,
            'method': 'POST'
        });

        request.done(function (response) {
            $(".popup").html('');
            if (response.length > 0) {
                for (var k in response) {
                    $(".popup").prepend("<a href='#' class='list-group-item list-group-item-primary a_choose_artist' data-id='" + response[k].id + "' data-artist_title='" + response[k].artist_title + "'>" + response[k].artist_title + "</a>");
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

$(document).on('click', '.a_choose_artist', function (event) {

    event.preventDefault();
    var artist_choose = $(this).data('id');
    var cur_artists = $("#song_artists").val();
    //if (cur_artists != '') {
    var arr_cur_artists = cur_artists.split(',');

    if (arr_cur_artists.indexOf(artist_choose.toString()) == -1) {
        var artist_field = '<a href="#" class="a_remove_artist" data-id="' + $(this).data('id') + '">' + $(this).data('artist_title') + ' <span class="fa fa-close"></span></a>   ';

        new_artists = cur_artists + artist_choose + ',';
        $("#song_artists").val(new_artists);

        $("#div_artists").prepend(artist_field);
        $("#div_box_artist").show();
    }
    else {
        alert('You have already selected artist ' + $(this).data('artist_title') + ' !');
    }

    $(".popup").hide(500);
});
$(document).on('click', '.a_remove_artist', function (event) {
    event.preventDefault();
    
    var artist_choose = $(this).data('id');
    var cur_artists = $("#song_artists").val();
    var arr_cur_artists = cur_artists.split(',');

    /*Here you have 2 opts:
     First: Using str.replace
     Second: Use array.filter. I choose this*/

    arr_new_artists = arr_cur_artists.filter(function (artist) {
        return artist == artist_choose ? '' : artist;
    });

    $("#song_artists").val(arr_new_artists.toString());
    $(this).remove();

    // If there is no left. Close artist div too
    if ($("#song_artists").val() == '')
    {
        $("#div_box_artist").hide(500);
    }
});
$(document).on('click', '#a_close_popup', function () {
    $(this).parent().html('');
});
