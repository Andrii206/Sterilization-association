<?php 
get_header();
$current_id = get_queried_object_id();
?>

<main>
     <?php get_template_part(
        'templates/hero-section',
        null,
        ['id_page' => $current_id,]
    ) ?>
    
    <div class="container">

        <div class="section-block">
            <h2 class="section-heading">
                <span class="heading-number"><?php the_field('s1_number', $current_id); ?></span> <?php the_field('s1_title', $current_id); ?>
            </h2>

            <?php if ( get_field('s1_panel', $current_id) ) : ?>
                <div class="info-panel-light">
                    <?php the_field('s1_panel', $current_id); ?>
                </div>
            <?php endif; ?>

            <?php the_field('s1_content', $current_id); ?>
        </div>

        <div class="section-block">
            <h2 class="section-heading">
                <span class="heading-number"><?php the_field('s2_number', $current_id); ?></span> <?php the_field('s2_title', $current_id); ?>
            </h2>

            <?php the_field('s2_content', $current_id); ?>

            <?php if ( get_field('s2_panel', $current_id) ) : ?>
                <div class="info-panel-dark">
                    <?php the_field('s2_panel', $current_id); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
    
    <div class="container">

        <div class="section-block">
            <h2 class="section-heading">
                <span class="heading-number"><?php the_field('s3_number', $current_id); ?></span> <?php the_field('s3_title', $current_id); ?>
            </h2>

            <?php the_field('s3_content', $current_id); ?>

            <?php if ( have_rows('s3_cards') ) : ?>
                <div class="sal-cards">
                    <?php while ( have_rows('s3_cards') ) : the_row(); ?>
                        <div class="sal-card">
                            <h3><?php the_sub_field('card_title'); ?></h3>
                            <p><?php the_sub_field('card_text'); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="section-block">
            <h2 class="section-heading">
                <span class="heading-number"><?php the_field('s4_number', $current_id); ?></span> <?php the_field('s4_title', $current_id); ?>
            </h2>

            <?php the_field('s4_content', $current_id); ?>
        </div>
        
        <div class="section-block">
            <h2 class="section-heading">
                <span class="heading-number"><?php the_field('s5_number', $current_id); ?></span> <?php the_field('s5_title', $current_id); ?>
            </h2>

            <?php the_field('s5_content_1', $current_id); ?>

            <?php if ( get_field('s5_panel', $current_id) ) : ?>
                <div class="info-panel-light">
                    <?php the_field('s5_panel', $current_id); ?>
                </div>
            <?php endif; ?>

            <?php the_field('s5_content_2', $current_id); ?>
        </div>
        
        <div class="section-block">
            <h2 class="section-heading">
                <span class="heading-number"><?php the_field('s6_number', $current_id); ?></span> <?php the_field('s6_title', $current_id); ?>
            </h2>

            <?php the_field('s6_content', $current_id); ?>

            <?php if ( get_field('s6_panel', $current_id) ) : ?>
                <div class="info-panel-dark">
                    <?php the_field('s6_panel', $current_id); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php get_footer() ?>