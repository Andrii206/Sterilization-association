<?php
get_header();
$current_id = get_queried_object_id();
?>

<main>
    <section class="useful-links-section">
        <div class="container">

            <div class="section-header">
                <h2 class="section-title"><?= get_field('title') ?></h2>
                <p class="section-subtitle"><?= get_field('description') ?></p>
            </div>

            <div class="links-table">

                <div class="table-row table-head">
                    <div class="col-id">#</div>
                    <div class="col-resource">Організація / Ресурс</div>
                    <div class="col-action" style="text-align: center;">Перейти</div>
                </div>

                <?php
               
                $args = array(
                    'post_type'      => 'useful-links',
                    'posts_per_page' => -1,            
                    'post_status'    => 'publish',     
                    'orderby'        => 'date',        
                    'order'          => 'ASC'          
                );

                $links_query = new WP_Query($args);

               
                if ($links_query->have_posts()) :

                    $counter = 1;

                   
                    while ($links_query->have_posts()) : $links_query->the_post();

                       
                        $link = get_field('link');
                ?>

                        <div class="table-row">
                            <div class="col-id"><?php echo $counter; ?></div>

                            <div class="col-resource">
                                <span class="resource-name"><?php the_title(); ?></span>

                                <?php if ($link) : ?>
                                    <a href="<?php echo esc_url($link); ?>" class="resource-url" target="_blank">
                                        <?php echo esc_html($link); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="col-action">
                                <?php if ($link) : ?>
                                    <a href="<?php echo esc_url($link); ?>" class="btn-go" target="_blank">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                            <polyline points="15 3 21 3 21 9"></polyline>
                                            <line x1="10" y1="14" x2="21" y2="3"></line>
                                        </svg>
                                        Перейти
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php
                        $counter++;
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