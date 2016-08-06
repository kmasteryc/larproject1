/**
 * Created by kmasteryc on 5/26/16.
 */
$(document).ready(function() {

    if ($(".datatable").length) {
        $(".datatable").dynatable();
    }

    // LAZY LOADING IMG
    $("img[data-src^='http']").each(function() {
        $(this).attr('src', $(this).data('src'));
    });

    // TOP NAV A HREF
    $('a[href="#navbar-more-show"], .navbar-more-overlay').on('click', function(event) {
        event.preventDefault();
        $('body').toggleClass('navbar-more-show');
        if ($('body').hasClass('navbar-more-show'))	{
            $('a[href="#navbar-more-show"]').closest('li').addClass('active');
        }else{
            $('a[href="#navbar-more-show"]').closest('li').removeClass('active');
        }
        return false;
    });

    // SEARCH INPUT
    var api = base_url + 'api/search';

    var options = {

        url: base_url + 'json/search_data.json',

        getValue: "title",

        list: {
            match: {
                enabled: true
            },

            showAnimation: {
                type: "fade", //normal|slide|fade
                time: 300,
                callback: function() {}
            },

            hideAnimation: {
                type: "slide", //normal|slide|fade
                time: 300,
                callback: function() {}
            }
        },
        adjustWidth: false,

        template: {
            type: "links",
            fields: {
                link: "link"
            }
        },

        theme: "blue-light"
    };

    $("#autocomplete").easyAutocomplete(options);

});

function showAjaxIcon() {
    return '<img class="reload" src="' + base_url + 'img/reload.gif"/>';
}

function renderArtists(artists) {
    var html = '';
    for (let x in artists) {
        html += '<a href="' + base_url + 'nghe-si/' + artists[x].artist_title_slug + '.html">' + artists[x].artist_title + '</a>';
        if (x != (artists.length - 1)) {
            html += ', ';
        }
    }
    return html;
}
