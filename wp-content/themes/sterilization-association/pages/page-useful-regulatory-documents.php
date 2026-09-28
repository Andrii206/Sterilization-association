<?php get_header();
$page_id = get_the_ID();
?>

<main>
   <?php get_template_part(
        'templates/hero-section',
        null,
        ['id_page' => $page_id,]
    ) ?>
    <section class="standards-section">
        <div class="container">

            <div class="page-header">
                <div class="category-tag">
                    <span class="dot"></span> <?= get_field('taxonomy', $page_id) ?>
                </div>
                <h2 class="page-title"><?= get_field('secondary_title', $page_id) ?></h2>
                <p class="page-subtitle"><?= get_field('subtitle', $page_id) ?></p>
            </div>

            <div class="standards-card">
                <div class="table-responsive">

                    <div class="table-row table-header">
                        <div class="col-title">№</div>
                        <div class="col-title">СТАНДАРТ</div>
                        <div class="col-title">НАЗВА</div>
                    </div>

                    <div class="table-body">
                    <?php
                    $args = array(
                        'post_type'      => 'regulatory-document',
                        'posts_per_page' => -1,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'ASC'
                    );

                    $links_query = new WP_Query($args);


                    if ($links_query->have_posts()) :                    
                        while ($links_query->have_posts()) : $links_query->the_post();
                        $post_id = get_the_ID()
                        ?>
                        <div class="table-row">
                            <div class="col-num"><?= get_field('number', $post_id) ?></div>
                            <div class="col-std"><span class="std-badge"><?= get_field('standard', $post_id) ?></span></div>
                            <div class="col-name"><?php the_title() ?></div>
                        </div>    
                            <?php
                        endwhile;


                        wp_reset_postdata();

                    else : ?>
                        <p>Наразі корисних посилань не додано.</p>
                    <?php endif; ?>                       
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<?php get_footer() ?>