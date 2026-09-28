<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head() ?>
    <title>Асоціація</title>
</head>

<body <?php body_class(); ?>>

    <?php
    $menu_name = 'header-menu';
    $menu_object = wp_get_nav_menu_object($menu_name);

    $acf_menu = '';
    $menu_id = 0;


    if ($menu_object) {
        $menu_id = $menu_object->term_id;
        $acf_menu = 'nav_menu_' . $menu_id;
    }
    ?>

    <header class="site-header">
        <div class="header-container">

            <div class="header-top">

                <div class="logo">
                    <?php
                    $logo_url = get_field('logo', $acf_menu);
                    if ($logo_url) : ?>
                        <a href="/">
                            <img src="<?php echo esc_url($logo_url); ?>" alt="Логотип">
                        </a>
                    <?php else : ?>
                        <a href="/">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/0a5c9b78-0b71-4590-a228-9c79803ce4db_1.svg" alt="Логотип">
                        </a>
                    <?php endif; ?>
                </div>

                <div class="lang-switcher custom-dropdown notranslate" translate="no">
                    <div class="dropdown-trigger" id="custom-lang-trigger">
                        UK <svg viewBox="0 0 24 24">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </div>
                    <div class="dropdown-menu">
                        <a href="#" onclick="changeCustomLanguage('uk', 'UK'); return false;">UK</a>
                        <a href="#" onclick="changeCustomLanguage('en', 'EN'); return false;">EN</a>
                    </div>
                </div>

                <button class="burger-btn" id="burgerBtn">
                    <span></span><span></span><span></span>
                </button>

                <form role="search" method="get" class="search-container" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="text" name="s" placeholder="Пошук" value="<?php echo get_search_query(); ?>" required>

                    <button type="submit" class="search-btn" aria-label="Шукати">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </form>

                <div class="contacts-wrapper">

                    <div class="phone-block">
                        <div class="phone-icon-wrap">
                            <svg viewBox="0 0 24 24">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div class="contact-text-group">
                            <span class="small-label"><?php the_field('by_the_phone', $acf_menu); ?></span>
                            <?php
                            $phone = get_field('phone_number', $acf_menu);
                            if ($phone) :
                                $clean_phone = str_replace(array(' ', '(', ')', '-'), '', $phone);
                            ?>
                                <a href="tel:<?php echo esc_attr($clean_phone); ?>" class="contact-link"><?php echo esc_html($phone); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="contact-text-group">
                        <span class="small-label right-align"><?php the_field('working_hours', $acf_menu); ?></span>
                        <?php $email = get_field('email', $acf_menu); ?>
                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo antispambot($email); ?>" class="contact-link"><?php echo antispambot($email); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="social-icons">
                    <?php $facebook = get_field('facebook', $acf_menu); ?>
                    <?php if ($facebook) : ?>
                        <a href="<?php echo esc_url($facebook); ?>" class="social-icon" aria-label="Facebook" target="_blank">
                            <svg viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3.81l.19-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </a>
                    <?php endif; ?>

                    <?php $instagram = get_field('instagram', $acf_menu); ?>
                    <?php if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" class="social-icon" aria-label="Instagram" target="_blank">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.00297 4.71488C6.12008 4.71488 4.60132 6.23363 4.60132 8.11653C4.60132 9.9994 6.12008 11.5181 8.00297 11.5181C9.88589 11.5181 11.4046 9.9994 11.4046 8.11653C11.4046 6.23363 9.88589 4.71488 8.00297 4.71488ZM8.00297 10.3281C6.7862 10.3281 5.79146 9.33625 5.79146 8.11653C5.79146 6.89679 6.78323 5.90501 8.00297 5.90501C9.22271 5.90501 10.2145 6.89679 10.2145 8.11653C10.2145 9.33625 9.21975 10.3281 8.00297 10.3281ZM12.3372 4.57573C12.3372 5.01685 11.9819 5.36916 11.5437 5.36916C11.1027 5.36916 10.7503 5.01389 10.7503 4.57573C10.7503 4.13758 11.1056 3.78231 11.5437 3.78231C11.9819 3.78231 12.3372 4.13758 12.3372 4.57573ZM14.5901 5.381C14.5398 4.31817 14.297 3.37672 13.5184 2.60106C12.7427 1.82541 11.8013 1.58264 10.7385 1.52935C9.64312 1.46719 6.35988 1.46719 5.26448 1.52935C4.20461 1.57968 3.26317 1.82244 2.48455 2.5981C1.70593 3.37376 1.46613 4.31521 1.41284 5.37804C1.35067 6.47343 1.35067 9.75663 1.41284 10.852C1.46317 11.9149 1.70593 12.8563 2.48455 13.632C3.26317 14.4077 4.20166 14.6504 5.26448 14.7037C6.35988 14.7659 9.64312 14.7659 10.7385 14.7037C11.8013 14.6534 12.7427 14.4106 13.5184 13.632C14.2941 12.8563 14.5368 11.9149 14.5901 10.852C14.6523 9.75663 14.6523 6.47639 14.5901 5.381ZM13.175 12.0274C12.9441 12.6077 12.497 13.0546 11.9139 13.2886C11.0405 13.6349 8.9681 13.555 8.00297 13.555C7.03784 13.555 4.96251 13.632 4.09212 13.2886C3.51185 13.0577 3.06482 12.6106 2.83093 12.0274C2.48455 11.154 2.56448 9.08168 2.56448 8.11653C2.56448 7.1514 2.48751 5.07606 2.83093 4.20567C3.06185 3.62541 3.50889 3.17837 4.09212 2.94448C4.96547 2.5981 7.03784 2.67804 8.00297 2.67804C8.9681 2.67804 11.0435 2.60106 11.9139 2.94448C12.4941 3.1754 12.9411 3.62244 13.175 4.20567C13.5214 5.07903 13.4414 7.1514 13.4414 8.11653C13.4414 9.08168 13.5214 11.157 13.175 12.0274Z" fill="white" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>

            </div>

            <div class="header-bottom">
                <nav class="main-nav">
                    <?php
                    render_custom_wp_menu($menu_id);
                    ?>
                </nav>

                <div class="header-address">
                    03056, Україна, м. Київ, вул. Борщагівська, буд. 117 кв. 162
                </div>
            </div>

        </div>
    </header>