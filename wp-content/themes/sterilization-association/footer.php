<?php
$menu_name = 'footer-menu';
$menu_object = wp_get_nav_menu_object($menu_name);

$acf_menu = '';
$menu_id = 0;


if ($menu_object) {
    $menu_id = $menu_object->term_id;
    $acf_menu = 'nav_menu_' . $menu_id;
}

$left_col = get_field('footer-block-contact', $acf_menu)
?>

<footer class="site-footer">
    <div class="container footer-grid">

        <div class="footer-col-brand">
            <div class="footer-logo">
                <a href="/">
                    <?php
                    $logo_url = $left_col['logo'];
                    if ($logo_url) : ?>
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Логотип">
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/0a5c9b78-0b71-4590-a228-9c79803ce4db_1.svg" alt="Логотип">
                    <?php endif; ?>
                </a>
            </div>

            <div class="footer-contact-block">
                <span class="footer-label"><?= $left_col['label-phone'] ?></span>
                <a href="tel:<?= str_replace(array(' ', '(', ')', '-'), '', $left_col['phone-number']) ?>" class="footer-value"><?= $left_col['phone-number'] ?></a>
            </div>

            <div class="footer-contact-block">
                <span class="footer-label"><?= $left_col['label-email'] ?></span>
                <a href="mailto:<?= $left_col['email'] ?>" class="footer-value"><?= $left_col['email'] ?></a>
            </div>

            <div class="footer-contact-block">
                <div class="footer-value schedule">
                    <?= $left_col['opening_hours_and_days'] ?>
                </div>
            </div>

            <div class="footer-contact-block">
                <div class="footer-value schedule" style="margin-top: 10px;">
                    <?= $left_col['location'] ?>
                </div>
            </div>
        </div>

        <?php
        $menu_items = wp_get_nav_menu_items($menu_id);

        if ($menu_items) :
            $total_items = count($menu_items);

            $half = ceil($total_items / 2);

            $col1 = array_slice($menu_items, 0, $half);
            $col2 = array_slice($menu_items, $half);
        ?>

            <div class="footer-col-nav">
                <ul class="footer-nav-list">
                    <?php foreach ($col1 as $item) : ?>
                        <li>
                            <a href="<?php echo esc_url($item->url); ?>">
                                <?php echo esc_html($item->title); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="footer-col-nav">
                <ul class="footer-nav-list">
                    <?php foreach ($col2 as $item) : ?>
                        <li>
                            <a href="<?php echo esc_url($item->url); ?>">
                                <?php echo esc_html($item->title); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        <?php endif; ?>

        <div class="footer-col-map">
            <?= get_field('map', $acf_menu) ?>
        </div>

    </div>
</footer>
<?php wp_footer() ?>
<div id="authModal" class="modal-overlay">
    <div class="modal-content">
        <button class="close-modal" id="closeAuthModal">&times;</button>

        <div class="auth-tabs">
            <button class="auth-tab-btn active" data-target="login">Вхід</button>
            <button class="auth-tab-btn" data-target="register">Реєстрація</button>
        </div>

        <form class="consult-form auth-form-block" id="customLoginForm">
            <input type="text" name="log_username" placeholder="Логін або Email" required>
            <input type="password" name="log_password" placeholder="Пароль" required>
            <div class="form-footer">
                <button type="submit" class="btn-submit">Увійти</button>
            </div>
        </form>

        <form class="consult-form auth-form-block" id="customRegisterForm" style="display: none;">
            <input type="text" name="full_name" placeholder="П.І.Б." required>
            <input type="email" name="email" placeholder="Email:" required>
            <input type="password" name="reg_password" placeholder="Пароль" required>
            <input type="password" name="reg_password_confirm" placeholder="Повторіть пароль" required>
            <input type="text" name="organization" placeholder="Організація:">
            <input type="text" name="position" placeholder="Посада:">

            <div class="phone-input-group">
                <div class="phone-dropdown">
                    <div class="phone-prefix dropdown-trigger" id="modal-selected-prefix">
                        🇺🇦 ▾ +380
                    </div>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-item" data-prefix="380" data-mask="(000) 000-00-00">🇺🇦 +380</div>
                        <div class="dropdown-menu-item" data-prefix="48" data-mask="000 000 000">🇵🇱 +48</div>
                        <div class="dropdown-menu-item" data-prefix="49" data-mask="000 0000000">🇩🇪 +49</div>
                        <div class="dropdown-menu-item" data-prefix="44" data-mask="0000 000000">🇬🇧 +44</div>
                        <div class="dropdown-menu-item" data-prefix="1" data-mask="(000) 000-0000">🇺🇸 +1</div>
                    </div>
                </div>
                <input type="hidden" name="phone_prefix" id="modal_phone_prefix" value="+380">
                <input type="tel" name="phone_number" id="modal-phone-input" placeholder="(000) 000-00-00" required>
            </div>


            <label class="checkbox-label">
                <input type="checkbox" name="privacy_policy" required>
                <span>Я погоджуюся з умовами обробки даних</span>
            </label>

            <div class="form-footer">
                <button type="submit" class="btn-submit">Зареєструватися</button>
            </div>
        </form>

        <div id="authFormResponse" style="margin-top: 15px; display: none;"></div>
    </div>
</div>
</body>