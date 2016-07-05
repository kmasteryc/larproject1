/**
 * Created by kmasteryc on 5/26/16.
 */
$(document).ready(function(){
    if ($(".datatable").length) {
        $(".datatable").dynatable();
    }

});

function showAjaxIcon(){
    return '<img class="reload" src="' + base_url + 'img/reload.gif"/>';
}