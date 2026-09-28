<?php

get_header();

$page_id = get_the_ID();


$card_1_text = get_field('card_1_text', $page_id);
$card_1_url  = get_field('card_1_url', $page_id) ?: '/#contactForm';

$card_2_text = get_field('card_2_text', $page_id);
$card_2_url  = get_field('card_2_url', $page_id) ?: '/#contactForm';

$card_3_text = get_field('card_3_text', $page_id);
$card_3_url  = get_field('card_3_url', $page_id) ?: '/#contactForm';

$card_4_text = get_field('card_4_text', $page_id);
$card_4_url  = get_field('card_4_url', $page_id) ?: '/#contactForm';

// Отримуємо картинки та текст
$main_text = get_field('p_main_text', $page_id);
$image_1   = get_field('p_image_1', $page_id);
$image_2   = get_field('p_image_2', $page_id);
?>

<main>
    <?php get_template_part(
        'templates/hero-section',
        null,
        ['id_page' => $page_id,]
    ) ?>

    <section class="project-info-section">
        <div class="container">

            <div class="nav-cards-grid">

                <?php if (!empty($card_1_text)) : ?>
                    <a href="<?php echo esc_url($card_1_url); ?>" class="nav-card">
                        <span><?php echo wp_kses_post($card_1_text); ?></span>
                        <svg class="nav-card-arrow" viewBox="0 0 24 24">
                            <path d="M7 17L17 7M17 7H7M17 7V17" />
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (!empty($card_2_text)) : ?>
                    <a href="<?php echo esc_url($card_2_url); ?>" class="nav-card">
                        <span><?php echo wp_kses_post($card_2_text); ?></span>
                        <svg class="nav-card-arrow" viewBox="0 0 24 24">
                            <path d="M7 17L17 7M17 7H7M17 7V17" />
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (!empty($card_3_text)) : ?>
                    <a href="<?php echo esc_url($card_3_url); ?>" class="nav-card">
                        <span><?php echo wp_kses_post($card_3_text); ?></span>
                        <svg class="nav-card-arrow" viewBox="0 0 24 24">
                            <path d="M7 17L17 7M17 7H7M17 7V17" />
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (!empty($card_4_text)) : ?>
                    <a href="<?php echo esc_url($card_4_url); ?>" class="nav-card">
                        <span><?php echo wp_kses_post($card_4_text); ?></span>
                        <svg class="nav-card-arrow" viewBox="0 0 24 24">
                            <path d="M7 17L17 7M17 7H7M17 7V17" />
                        </svg>
                    </a>
                <?php else : ?>
                    <a href="#" class="nav-card">
                        <span></span>
                        <svg class="nav-card-arrow" viewBox="0 0 24 24">
                            <path d="M7 17L17 7M17 7H7M17 7V17" />
                        </svg>
                    </a>
                <?php endif; ?>

            </div>

            <div class="content-grid">

                <div class="text-column">
                    <?php if ($main_text) : ?>
                        <?php echo wp_kses_post($main_text); ?>
                    <?php endif; ?>
                </div>

                <div class="image-column">
                    <img src="<?php echo $image_1 ? esc_url($image_1) : get_template_directory_uri() . '/assets/images/dc74ad89d94faa37a133d3bae5f0fd39e8260c92.png'; ?>" alt="Схема процесів ЦСВ">

                    <img src="<?php echo $image_2 ? esc_url($image_2) : get_template_directory_uri() . '/assets/images/4c8e7bffff6bdf1ff184e8e3d9cd62ecfad41b08.png'; ?>" alt="Схема руху (Work Flow)">
                </div>

            </div>

        </div>
    </section>
</main>

<?php get_footer() ?>