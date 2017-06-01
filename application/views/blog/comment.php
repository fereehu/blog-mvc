
<div class="comments">
    <?php include_once("comments.php"); ?>
</div>


<?php /*
  <form name="comment" method="post" action="">
  <input type="hidden" name="postid" value="<?= $post->id; ?>">
  <table class="comment">
  <tr>
  <td>Név:</td>
  <td><input type="text" name="username" value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?>" required="required"></td>
  </tr>

  <tr>
  <td>Email: (nem lesz publikus)</td>
  <td><input type="email" name="useremail" value="<?php if (isset($_SESSION['useremail'])) echo $_SESSION['useremail']; ?>" required="required"></td>

  </tr>
  <tr>
  <td>Weblap:</td>
  <td><input type="url" name="userurl" value="<?php if (isset($_SESSION['userurl'])) echo $_SESSION['userurl']; ?>"  ></td>

  </tr>
  </table>

  <textarea cols="50" rows="10" name="comment" " required="required"><?php if (isset($_SESSION['commentUnderPostAndWrongCaptcha'])) echo $_SESSION['commentUnderPostAndWrongCaptcha']; ?></textarea><br>
  Milyen nap van ma?

  <input name="captcha" type="text" size="20" required="required"><br><br>

  <input type="submit" value="Hozzászólás elküldése">

  </form>
 */ ?>





<input type="hidden" name="postid" value="<?= $post->id; ?>">
<table class="comment">
    <tr>
        <td>Név:</td>
        <td><input title="Neved" type="text" name="username" value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?>" required="required"></td>
    </tr> 

    <tr>
        <td>Email: (nem lesz publikus)</td>
        <td><input title="Email címed. Kötelező kitölteni." type="email" name="useremail" value="<?php if (isset($_SESSION['useremail'])) echo $_SESSION['useremail']; ?>" required="required"></td>

    </tr>
    <tr>
        <td>Weblap:</td>
        <td><input title="Ha van weblapod, ide írhatod az elérhetőségét!" type="url" name="userurl" value="<?php if (isset($_SESSION['userurl'])) echo $_SESSION['userurl']; ?>"  ></td>

    </tr>
</table>

<textarea title="Hozzászólás szövege" class="textareaComment" cols="50" rows="10" name="comment"  required="required"><?php if (isset($_SESSION['commentUnderPostAndWrongCaptcha'])) echo $_SESSION['commentUnderPostAndWrongCaptcha']; ?></textarea><br><br><p>
    Milyen nap van ma?  

    <input title="Biztonsági okok miatt add meg a mai napot!" name="captcha" type="text" size="20" required="required"></p><br><br>

<button class="commentSubmit" type
        ="submit">Hozzászólás elküldése!</button>
<div class="siker"></div>


<style>
    label {
        display: inline-block; width: 1em;
    }
    fieldset div {
        margin-bottom: 1em;
    }
    fieldset .help {
        display: inline-block;
    }
    .ui-tooltip {
        width: 250px;
    }
</style>


<script>
    //$(document).ready(function () {


    // $(document).ready(




    //Felbukkanó üzenet az inputokhoz. Kell hozzá css is!
    $(function () {
        var tooltips = $("[title]").tooltip({
            position: {
                my: "left top",
                at: "right+5 top-5"
            }
        });

    });



    $('.commentSubmit').on('click', function (event) {
        event.preventDefault();

        var postid = $("input[name='postid']").val();
        var username = $("input[name='username']").val();
        var useremail = $("input[name='useremail']").val();
        var userurl = $("input[name='userurl']").val();
        var comment = $("textarea[name='comment']").val();
        var captcha = $("input[name='captcha']").val();
        var errorInComment = 0;

        if (!validateEmail(useremail))
        {
            $("input[name='useremail']").effect('shake', 'fast');
            var errorInComment = 1;
        }
        if (username.length == 0)
        {
            $("input[name='username']").effect('shake', 'fast');
            var errorInComment = 1;

        }
        if (comment.length == 0)
        {
            $("textarea[name='comment']").effect('shake', 'fast');
            var errorInComment = 1;

        }
        if (captcha.length == 0)
        {
            $("input[name='captcha']").val('');
            $("input[name='captcha']").effect('shake', 'fast');
            var errorInComment = 1;

        }
        $.ajax({
            type: "POST",
            url: "<?= URL; ?>blog/commentSubmit/",
            crossDomain: true,
            data: "postid=" + postid + "&username=" + username + "&useremail=" + useremail + "&userurl=" + userurl + "&comment=" + comment + "&captcha=" + captcha,
            success: function (data) {
                //  alert('a');
                $(".siker").html(data);
                $(".comments").load("/blog/<?= POSTURL; ?>/comments");
                if (errorInComment == 0) { //Ha valahol 1, akkor nem törli ki a textarea-t, mivel akkor volt benne valami elírás.
                    $(".textareaComment").val('');
                }
            },
            error: function (err) {
                $(".siker").text("Valami hiba történt!");
                //  alert('hiba');
            }
        });
    });
    // });

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
</script>