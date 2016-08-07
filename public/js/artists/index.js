/**
 * Created by kmasteryc on 07/08/2016.
 */
$(document).ready(function () {
    var options = {
        url: base_url + 'json/search_artist_data.json',
        getValue: "title",
        list: {
            match: {
                enabled: true
            },
            showAnimation: {
                type: "fade", //normal|slide|fade
                time: 300,
                callback: function () {
                }
            },
            hideAnimation: {
                type: "slide", //normal|slide|fade
                time: 300,
                callback: function () {
                }
            }
        },
        adjustWidth: false,
        template: {
            type: "links",
            fields: {
                link: "link_edit"
            }
        },
        theme: "blue-light"
    };
    $("#autocomplete").easyAutocomplete(options);
});