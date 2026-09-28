<?php
get_header();

$current_id = get_queried_object_id();
$intro_heading_block = get_field('intro-heading-block', $current_id);
$cards_grid = get_field('cards-grid', $current_id);
$left_col = get_field('left-col', $current_id);
$country_numbers = get_field('country_numbers', $current_id);

function get_flag_emoji_from_code($country_code)
{
    $country_code = strtoupper($country_code);
    $flag = '';
    for ($i = 0; $i < strlen($country_code); $i++) {        
        $flag .= mb_chr(ord($country_code[$i]) + 127397, 'UTF-8');
    }
    return $flag;
}

?>

<main>
    <?php get_template_part(
        'templates/hero-section',
        null,
        ['id_page' => $current_id,]
    ) ?>
    <section class="intro-section">
        <div class="container intro-grid">

            <div class="intro-heading-block">
                <h2 class="intro-title"><?= $intro_heading_block['intro-title']  ?></h2>
                <p class="intro-subtitle"><?= $intro_heading_block['intro-subtitle'] ?></p>
            </div>

            <div class="intro-text-block">
                <?= get_field('intro-text-block', $current_id) ?>
            </div>

        </div>
    </section>

    <section class="platform-section">
        <div class="container">
            <h2 class="platform-title"><?= get_field('platform-title') ?></h2>

            <?php
            if ($cards_grid) :


                $total_cards = count($cards_grid);
                $remainder   = $total_cards % 4;

                $main_count = ($remainder === 0) ? $total_cards : ($total_cards - $remainder);

                $main_cards     = array_slice($cards_grid, 0, $main_count);
                $centered_cards = array_slice($cards_grid, $main_count);
            ?>

                <?php if (!empty($main_cards)) : ?>
                    <div class="cards-grid">
                        <?php foreach ($main_cards as $card) : ?>
                            <a href="#" class="platform-card">
                                <div class="card-icon">
                                    <?php


                                    $icon_url = is_array($card['card-icon']) ? $card['card-icon']['url'] : $card['card-icon'];
                                    ?>
                                    <img src="<?php echo esc_url($icon_url); ?>" alt="icon">
                                </div>
                                <div class="card-content">
                                    <h4><?php echo esc_html($card['card-title']); ?></h4>
                                    <p><?php echo esc_html($card['card-content']); ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <?php if (!empty($centered_cards)) : ?>
                    <div class="cards-grid-centered">
                        <?php foreach ($centered_cards as $card) : ?>
                            <a href="#" class="platform-card">
                                <div class="card-icon">
                                    <img src="<?php echo $card['card-icon']; ?>" alt="icon">
                                </div>
                                <div class="card-content">
                                    <h4><?php echo esc_html($card['card-title']); ?></h4>
                                    <p><?php echo esc_html($card['card-content']); ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </section>
    <section class="partners-section">
        <div class="container">
            <h2 class="section-title"><?= get_field('partners-section-title', $current_id) ?></h2>
            <div class="partners-grid">
                <div class="partner-card"><img src="<?php echo get_field('partner-card1', $current_id) ?>"></div>
                <div class="partner-card"><img src="<?php echo get_field('partner-card2', $current_id) ?>"></div>
                <div class="partner-card"><img src="<?php echo get_field('partner-card3', $current_id) ?>"></div>
                <div class="partner-card"><img src="<?php echo get_field('partner-card4', $current_id) ?>"></div>
                <div class="partner-card"><img src="<?php echo get_field('partner-card5', $current_id) ?>"></div>
            </div>
        </div>
    </section>

    <section class="contact-section">
        <div class="container contact-grid">

            <div class="contact-info">
                <h2 class="contact-title"><?= $left_col['contact-title'] ?></h2>
                <?= $left_col['contact-content'] ?>
            </div>

            <div class="contact-form-wrapper">
                <p class="form-intro"><?= get_field('form-intro', $current_id) ?></p>

                <form class="consult-form" id="contactForm">
                    <input type="text" name="full_name" placeholder="П.І.Б." required>
                    <input type="email" name="email" placeholder="Email:" required>
                    <input type="text" name="organization" placeholder="Організація:">
                    <input type="text" name="position" placeholder="Посада:">
                    <input type="text" name="message" placeholder="Введіть своє повідомлення" required>

                    <div class="phone-input-group">
                        <div class="phone-dropdown">
                            <div class="phone-prefix dropdown-trigger" id="selected-prefix">
                                🇺🇦 ▾ +380
                            </div>
                            <div class="dropdown-menu">
                                <?php foreach ($country_numbers as $country_number) : ?>
                                    <?php $flag_emoji = get_flag_emoji_from_code($country_number['country_code']); ?>
                                    <div class="dropdown-menu-item" data-prefix="<?= esc_attr($country_number['country_number']) ?>" data-mask="<?= esc_attr($country_number['phone_number_mask']) ?>">
                                        <?= $flag_emoji . ' +' . $country_number['country_number'] ?>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>

                        <input type="hidden" name="phone_prefix" id="phone_prefix" value="+380">
                        <input type="tel" name="phone_number" id="phone-input" placeholder="(000) 000-00-00" required>
                    </div>

                    <label class="checkbox-label">
                        <input type="checkbox" required>
                        <span>Я погоджуюся з умовами обробки персональних даних</span>
                    </label>

                    <div class="form-footer">
                        <button type="submit" class="btn-submit">Отримати консультацію</button>
                    </div>
                </form>

                <div id="formResponse" style="margin-top: 15px; display: none;"></div>
            </div>

        </div>
    </section>
    <section class="news-section">
        <div class="container">
            <div class="news-header">
                <h2 class="news-section-title"><?= get_field('news_block_title', $current_id) ?></h2>
                <p class="news-subtitle"><?= get_field('news_block_content', $current_id) ?></p>
            </div>

            <div class="news-grid">

                <?php

                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
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