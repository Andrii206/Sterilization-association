<?php
get_header();
?>


<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            <?php the_title() ?>
        </h1>
    </div>
    <?php the_content( ) ?>
</div>

<?php
get_footer();
?>