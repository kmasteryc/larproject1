/**
 * Created by kmasteryc on 6/29/16.
 */
$(document).ready(function(){
    $("#show-playlist-info").click(function (e) {
        e.preventDefault();
        $('.playlist-info-hidden').show();
        $('.playlist-info').hide();
    });

    $("#hide-playlist-info").click(function (e) {
        e.preventDefault();
        $('.playlist-info-hidden').hide();
        $('.playlist-info').show();
    });
});