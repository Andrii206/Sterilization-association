<?php 

get_header(); 

// Отримуємо ID поточної сторінки
$page_id = get_the_ID();

// Отримуємо групи полів з ACF
$contacts_header = get_field('contacts_header', $page_id);
$contacts_info   = get_field('contacts_info', $page_id);
$contacts_banner = get_field('contacts_banner', $page_id);
?>

<main>
    <section class="contacts-page">
        <div class="container">

            <div class="page-header">
                <h1 class="page-title">
                    <?= !empty($contacts_header['main_title']) ? esc_html($contacts_header['main_title']) : 'Контакти' ?>
                </h1>
                <?php if (!empty($contacts_header['main_subtitle'])): ?>
                    <p class="page-subtitle"><?= esc_html($contacts_header['main_subtitle']) ?></p>
                <?php endif; ?>
            </div>
 
            <div class="contacts-card">

                <div class="card-section">
                    <h2 class="section-title">Назва організації</h2>
                    <?php if (!empty($contacts_info['org_title_ua'])): ?>
                        <p class="org-title-ua"><?= esc_html($contacts_info['org_title_ua']) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($contacts_info['org_title_en'])): ?>
                        <p class="org-title-en"><?= esc_html($contacts_info['org_title_en']) ?></p>
                    <?php endif; ?>
                </div>

                <hr class="divider">

                <div class="card-section">
                    <h2 class="section-title">Контактна інформація</h2>

                    <div class="contact-list">
                        <?php if (!empty($contacts_info['address'])): ?>
                            <div class="contact-item">
                                <span class="contact-label">Адреса</span>
                                <span class="contact-value"><?= esc_html($contacts_info['address']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contacts_info['phone'])): ?>
                            <?php $clean_phone = str_replace(array(' ', '(', ')', '-'), '', $contacts_info['phone']); ?>
                            <div class="contact-item">
                                <span class="contact-label">Телефон</span>
                                <a href="tel:<?= esc_attr($clean_phone) ?>" class="contact-value">
                                    <?= esc_html($contacts_info['phone']) ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contacts_info['email'])): ?>
                            <div class="contact-item">
                                <span class="contact-label">Email</span>
                                <a href="mailto:<?= esc_attr($contacts_info['email']) ?>" class="contact-value">
                                    <?= esc_html($contacts_info['email']) ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contacts_info['manager'])): ?>
                            <div class="contact-item">
                                <span class="contact-label">Керівник</span>
                                <span class="contact-value"><?= esc_html($contacts_info['manager']) ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($contacts_info['website'])): ?>
                            <?php 
                            // Очищаємо хост для гарного відображення (без https://)
                            $display_url = str_replace(array('https://', 'http://', 'www.'), '', $contacts_info['website']);
                            ?>
                            <div class="contact-item">
                                <span class="contact-label">Вебсайт</span>
                                <a href="<?= esc_url($contacts_info['website']) ?>" target="_blank" class="contact-value">
                                    www.<?= esc_html($display_url) ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <?php if (!empty($contacts_banner)): ?>
                <div class="member-banner">
                    <?php if (!empty($contacts_banner['banner_title'])): ?>
                        <h3 class="banner-title"><?= esc_html($contacts_banner['banner_title']) ?></h3>
                    <?php endif; ?>
                    
                    <?php if (!empty($contacts_banner['banner_text'])): ?>
                        <p class="banner-text"><?= esc_html($contacts_banner['banner_text']) ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($contacts_banner['banner_link'])): ?>
                        <a href="<?= esc_url($contacts_banner['banner_link']['url']) ?>" 
                           target="<?= esc_attr($contacts_banner['banner_link']['target'] ?: '_self') ?>" 
                           class="btn-white">
                            <?= esc_html($contacts_banner['banner_link']['title'] ?: 'Відвідати') ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php get_footer(); ?>