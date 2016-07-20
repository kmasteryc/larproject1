/**
 * Created by kmasteryc on 7/4/16.
 */
$(document).ready(function () {

    // Call lightSlider to show Playlist
    $(".lightSlider").lightSlider({
        item:5,
        responsive : [
            {
                breakpoint:1200,
                settings: {
                    item:6,
                    slideMove:1,
                    slideMargin:6,
                }
            },
            {
                breakpoint:992,
                settings: {
                    item:5,
                    slideMove:1,
                    slideMargin:6,
                }
            },
            {
                breakpoint:768,
                settings: {
                    item:3,
                    slideMove:1,
                    slideMargin:6,
                }
            },
            {
                breakpoint:480,
                settings: {
                    item:1,
                    slideMove:1
                }
            }
        ]
    });

    var api_1 = base_url + 'api/get-ajax-hot-song/' + cate;
    var json_data = '';
    var hot_song_box = $("#hot-song");
    var hot_song_paginate = $("#hot-song-pageinate");

    loadData(api_1);

    showLinks();

    function loadData(url) {
        hot_song_box.html(showAjaxIcon());

        $.get(url).success(function (response) {
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

            hot_song_box.html(html);
            hot_song_paginate.html(showLinks());
        });
    }

    function showLinks() {
        var html = '<nav><ul class="pagination">';

        html += json_data.prev_page_url ? '<li> <a href="#" class="ajax-load" data-api="' + json_data.prev_page_url + '"> Trước </a> </li> ' : '';

        for (var i = 1; i <= json_data.last_page; i++) {
            if (i == json_data.current_page) {
                html += '<li class="active"><a href="#">' + i + '</a></li>';
            } else {
                html += '<li><a href="#" class="ajax-load" data-api="' + api_1 + '?page=' + i + '">' + i + '</a></li>';
            }
        }
        html += json_data.next_page_url ? '<li> <a href="#" class="ajax-load" data-api="' + json_data.next_page_url + '"> Sau </a> </li> ' : '';
        html += '</ul></nav>';

        return html;
    }

    $(document).on('click', '.ajax-load', function (event) {
        event.preventDefault();

        loadData($(this).data('api'));

    });
});
