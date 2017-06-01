<footer class="blog-footer">
    <p>&copy; <?php echo date("Y");?> <a href="<?php echo URL;?>"><?php echo SITENAME;?></a></p>
    <p>
        Programmed by Feree
    </p>
</footer>




<script>
//$(document).ready(function () {
        $(function () {
        $("input[type=submit], button")
                .button()
                .click(function (event) {
                    //event.preventDefault();//ez nem kell, a lényeg a színezésen van ^^
                });
    });
    
    $('.linkToContainer').on('click', function (event) {
        event.preventDefault();
        // alert('asdsa');
        var link = $(this).attr("href");
        $.ajax({
            //  type: "POST",
            url: link + "_ajax",
            crossDomain: true,
            //  data: "fullname=" + fullName + "&email=" + email,
            success: function (data) {
                $(".mainContainer").html(data);
            },
            error: function (err) {
                $(".mainContainer").text("Valami hiba történt!");
            }
        });
    });
  
    /*URL sávot írja át, úgy, hogy nem töltődik újra az oldal. A h5utils.js-t használja.
     * id="urlLinks" */
    addEvent(urlLinks, 'click', function (event) {
        event.preventDefault();
        if (event.target.nodeName == 'A') {
            history.pushState("", "", event.target.href);
        }
    });
 // });
</script>