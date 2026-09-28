<?php
get_header();
$page_id = get_the_ID();
?>

<main>
    <?php get_template_part(
        'templates/hero-section',
        null,
        ['id_page' => $page_id,]
    ) ?>
    <section class="comparison-header">
        <div class="container">
            <h2 class="comparison-title"><?= the_field('comparison-title', $page_id) ?></h2>
            <p class="comparison-subtitle"><?= the_field('comparison-subtitle', $page_id) ?></p>
        </div>
    </section>

    <section class="comparison-table-wrapper">
        <div class="container">
            <div class="comparison-table">

                <div class="t-row t-head">
                    <div class="t-col">Метод</div>
                    <div class="t-col">Переваги</div>
                    <div class="t-col">Недоліки</div>
                </div>

                <?php

                $args = array(
                    'post_type'      => 'sterilization-method',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'ASC'
                );

                $links_query = new WP_Query($args);


                if ($links_query->have_posts()) :

                    $counter = 1;


                    while ($links_query->have_posts()) : $links_query->the_post();
                    $post_id = get_the_ID()
                ?>
                        <div class="t-row">
                            <div class="t-col col-method"><?php the_title() ?></div>
                            <div class="t-col col-adv">
                                <?= get_field('advantages', $post_id) ?>
                            </div>
                            <div class="t-col col-disadv">
                                <?= get_field('disadvantages', $post_id) ?>
                            </div>
                        </div>
                    <?php
                    endwhile;


                    wp_reset_postdata();

                else : ?>
                    <p>Наразі корисних посилань не додано.</p>
                <?php endif; ?>                
            </div>
        </div>
    </section>
</main>

<?php get_footer() ?>