<?php
$hero_group_left = get_field('col_left', $args['id_page']);
$hero_group_right = get_field('col_right', $args['id_page']);
?>

<section class="hero-banner">
    <div class="container hero-grid">

        <div class="hero-col">
            <h1 class="hero-title">
                <?= $hero_group_left['hero_title'] ?>
            </h1>
            <?php if ( !empty($hero_group_left['hero_description']) ) : ?>
                <p class="hero-description">
                    <?= $hero_group_left['hero_description'] ?>
                </p>
            <?php endif ?>
        </div>
        <?php if ($hero_group_right && !empty($hero_group_right)): ?>
            <div class="hero-col">
                <div>
                    <h3 class="hero-consult-title">
                        <?= $hero_group_right['hero_consult_title'] ?>
                    </h3>
                    <p class="hero-consult-text">
                        <?= $hero_group_right['hero-consult-text'] ?>
                    </p>
                </div>

                <div class="hero-actions">
                    <a href="tel:<?= esc_attr(str_replace(array(' ', '(', ')', '-'), '', $hero_group_right['phone_number'])) ?>" class="btn btn-dark-square" aria-label="Зателефонувати">
                        <svg class="hero-icon" viewBox="0 0 24 24">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                    </a>

                    <a href="/#contactForm" class="btn btn-dark-rect">
                        <span class="btn-text-lines">
                            <span><?= $hero_group_right['button_text'] ?></span>
                        </span>
                        <svg class="hero-icon" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>