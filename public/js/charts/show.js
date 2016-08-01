/**
 * Created by kmasteryc on 27/07/2016.
 */
$(document).ready(()=> {

    $('#myTabs a').click((e) => {
        e.preventDefault()
        $(this).tab('show')
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', (e)=> {
        $("#playall-link").toggle();
    });

    $("#index_choose").change(()=> {
        var index = document.getElementById('index_choose').value;
        var unit = document.getElementById('index_choose').getAttribute('data-unit-slug');
        var cate = document.getElementById('index_choose').getAttribute('data-cate-title-slug');
        window.location.href = base_url + 'bang-xep-hang/' + cate + '/' + unit + '-' + index+'.html';
    });

});