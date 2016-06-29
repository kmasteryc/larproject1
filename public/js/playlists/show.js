/**
 * Created by kmasteryc on 6/28/16.
 */
$(document).ready(function(){
   $("#show-playlist-info").click(function(e){
       e.preventDefault();
       $('.playlist-info-hidden').show();
       $('.playlist-info').hide();
       $(this).hide();
   });
});