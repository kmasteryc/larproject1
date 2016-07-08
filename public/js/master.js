/**
 * Created by kmasteryc on 5/26/16.
 */
$(document).ready(function(){
    if ($(".datatable").length) {
        $(".datatable").dynatable();
    }

    $("#top-search-text").change(function(){

    });

    $("#top-search-btn").click(function(){
        var input = $("#top-search-text");
       event.preventDefault();
        console.log(input.val());
    });
});

function showAjaxIcon(){
    return '<img class="reload" src="' + base_url + 'img/reload.gif"/>';
}