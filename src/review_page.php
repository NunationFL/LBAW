<?php
include_once "main_templates.php";
draw_head();
draw_navbar_normal_user();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="col-11 col-lg-10 my-auto mx-auto">
    <?php
    draw_review_1();
    ?>
</div>
<?php
draw_footer();