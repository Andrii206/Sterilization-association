<?php
get_header();

$page_id = get_the_ID();


$main_title    = get_field('join_main_title', $page_id) ?: 'Вступити до УАСД';
$main_subtitle = get_field('join_main_subtitle', $page_id);


$c1_title    = get_field('j_card_1_title', $page_id);
$c1_content  = get_field('j_card_1_content', $page_id);
$c1_btn_p_t  = get_field('j_card_1_btn_p_text', $page_id);
$c1_btn_p_u  = get_field('j_card_1_btn_p_url', $page_id) ?: '#';
$c1_btn_o_t  = get_field('j_card_1_btn_o_text', $page_id);
$c1_btn_o_u  = get_field('j_card_1_btn_o_url', $page_id) ?: '#';


$c2_title    = get_field('j_card_2_title', $page_id);
$c2_content  = get_field('j_card_2_content', $page_id);
$c2_btn_p_t  = get_field('j_card_2_btn_p_text', $page_id);
$c2_btn_p_u  = get_field('j_card_2_btn_p_url', $page_id) ?: '#';
$c2_btn_o_t  = get_field('j_card_2_btn_o_text', $page_id);
$c2_btn_o_u  = get_field('j_card_2_btn_o_url', $page_id) ?: '#';


$c3_title    = get_field('j_card_3_title', $page_id);
$c3_content  = get_field('j_card_3_content', $page_id);
$c3_btn_p_t  = get_field('j_card_3_btn_p_text', $page_id);
$c3_btn_p_u  = get_field('j_card_3_btn_p_url', $page_id) ?: '#';
$c3_btn_o_t  = get_field('j_card_3_btn_o_text', $page_id);
$c3_btn_o_u  = get_field('j_card_3_btn_o_url', $page_id) ?: '#';
?>

<main>
    <?php get_template_part(
        'templates/hero-section',
        null,
        ['id_page' => $page_id,]
    ) ?>
    <section class="join-section">
        <div class="container">

            <div class="join-header">
                <h2 class="join-title"><?php echo esc_html($main_title); ?></h2>
                <?php if ($main_subtitle) : ?>
                    <p class="join-subtitle"><?php echo esc_html($main_subtitle); ?></p>
                <?php endif; ?>
            </div>

            <div class="join-grid">

                <div class="join-card">
                    <div class="card-content">
                        <div class="card-label">ФІЗИЧНІ ОСОБИ</div>
                        <h3 class="card-title"><?php echo esc_html($c1_title ?: 'Для фізичних осіб'); ?></h3>

                        <?php if ($c1_content) echo wp_kses_post($c1_content); ?>
                    </div>
                    <div class="card-actions">
                        <?php if ($c1_btn_p_t) : ?>
                            <a href="<?php echo esc_url($c1_btn_p_u); ?>" class="btn btn-primary"><?php echo esc_html($c1_btn_p_t); ?></a>
                        <?php endif; ?>
                        <?php if ($c1_btn_o_t) : ?>
                            <a href="<?php echo esc_url($c1_btn_o_u); ?>" class="btn btn-outline"><?php echo esc_html($c1_btn_o_t); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="join-card">
                    <div class="card-content">
                        <div class="card-label">ЮРИДИЧНІ ОСОБИ</div>
                        <h3 class="card-title"><?php echo esc_html($c2_title ?: 'Для юридичних осіб'); ?></h3>

                        <?php if ($c2_content) echo wp_kses_post($c2_content); ?>
                    </div>
                    <div class="card-actions">
                        <?php if ($c2_btn_p_t) : ?>
                            <a href="<?php echo esc_url($c2_btn_p_u); ?>" class="btn btn-primary"><?php echo esc_html($c2_btn_p_t); ?></a>
                        <?php endif; ?>
                        <?php if ($c2_btn_o_t) : ?>
                            <a href="<?php echo esc_url($c2_btn_o_u); ?>" class="btn btn-outline"><?php echo esc_html($c2_btn_o_t); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="join-card">
                    <div class="card-content">
                        <div class="card-label">СПОНСОРИ</div>
                        <h3 class="card-title"><?php echo esc_html($c3_title ?: 'Для спонсорів'); ?></h3>

                        <?php if ($c3_content) echo wp_kses_post($c3_content); ?>
                    </div>
                    <div class="card-actions">
                        <?php if ($c3_btn_p_t) : ?>
                            <a href="<?php echo esc_url($c3_btn_p_u); ?>" class="btn btn-primary"><?php echo esc_html($c3_btn_p_t); ?></a>
                        <?php endif; ?>
                        <?php if ($c3_btn_o_t) : ?>
                            <a href="<?php echo esc_url($c3_btn_o_u); ?>" class="btn btn-outline"><?php echo esc_html($c3_btn_o_t); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php get_footer() ?>