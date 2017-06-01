<script src="<?= URL; ?>public/js/jquery-2.1.3.min.js" type="text/javascript"></script>
<script src="<?= URL; ?>public/js/jquery-ui.min.js" type="text/javascript"></script>




<script src="<?=URL;?>public/js/h5utils.js" type="text/javascript"></script>




<link rel="stylesheet" href="<?= URL; ?>public/css/prettyPhoto.css" type="text/css" media="" title="prettyPhoto main stylesheet" charset="utf-8" />

<link rel="stylesheet" href="<?= URL; ?>public/css/jquery-ui.min.css" type="text/css" media="" title="prettyPhoto main stylesheet" charset="utf-8" />

<script src="<?= URL; ?>public/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">

    
     
     $(document).ready(function(){
     $("area[rel^='prettyPhoto']").prettyPhoto();
     
     $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({
     animation_speed:'normal',
     theme:'light_square',
     slideshow:3000, 
     autoplay_slideshow: false,
     horizontal_padding: 20, 
     allow_resize: false,
     default_width: 500, 
     default_height: 344,
     show_title: false 
     
     });
     $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});
     
     $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
     custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
     changepicturecallback: function(){ initialize(); }
     });
     
     
     });
</script>
<style>
    .pp_pic_holder{ /*Valami hiba miatt be kellett rakni, hogy ne írja át magát a prettyPhoto top paramétere. De így, ezért  működik */ 
        top:0px !important;
        position:fixed !important;
    }
    </style>