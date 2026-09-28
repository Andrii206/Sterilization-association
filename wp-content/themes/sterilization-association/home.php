<?php get_header();
$page_id = get_the_ID();
?>


<main>
    <section class="news-section">
        <div class="container">
            <div class="news-header">
                <h2 class="news-section-title"><?= get_field('news-section-title', $page_id) ?></h2>
                <p class="news-subtitle">Наша місія - забезпечити успішний розвиток наших партнерів шляхом впровадження ефективних ІТ-рішень в їх бізнесі.</p>
            </div>

            <div class="news-grid">

                <?php
                
                $args = array(
                    'post_type'      => 'post',       
                    'posts_per_page' => -1,           
                    'post_status'    => 'publish',    
                    'orderby'        => 'date',       
                    'order'          => 'DESC'        
                );

                $news_query = new WP_Query($args);

                
                if ($news_query->have_posts()) :

                    
                    while ($news_query->have_posts()) : $news_query->the_post();
                ?>

                        <a href="<?php the_permalink(); ?>" class="news-card">

                            <div class="news-card-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium_large'); ?>
                                <?php else : ?>
                                    <div style="color: white; font-weight: bold; font-size: 24px; text-align: center; line-height: 1.2;">
                                        ВСЕУКРАЇНСЬКА АСОЦІАЦІЯ<br>
                                        <span style="font-size: 16px;">СТЕРИЛІЗАЦІЇ ТА ДЕЗІНФЕКЦІЇ</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="news-card-content">
                                <time class="news-card-date"><?php echo get_the_date('d/m/Y'); ?></time>

                                <h3 class="news-card-title"><?php the_title(); ?></h3>
                            </div>

                        </a>

                    <?php
                    endwhile;

                    
                    wp_reset_postdata();

                else : ?>
                    <p>Наразі новин немає.</p>
                <?php endif; ?>

            </div>
        </div>
    </section>
</main>

<?php get_footer() ?>