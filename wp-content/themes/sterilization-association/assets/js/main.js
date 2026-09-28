document.addEventListener("DOMContentLoaded", function () {
    const burgerBtn = document.getElementById("burgerBtn");
    const siteHeader = document.querySelector(".site-header");

    if (burgerBtn) {
        burgerBtn.addEventListener("click", function () {
            this.classList.toggle("active");
            siteHeader.classList.toggle("menu-open");
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {

    const dropdowns = document.querySelectorAll('.custom-dropdown');

    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-trigger');

        if (trigger) {
            trigger.addEventListener('click', function (e) {

                if (!dropdown.classList.contains('is-open')) {
                    e.preventDefault();


                    document.querySelectorAll('.custom-dropdown').forEach(d => {
                        if (d !== dropdown) d.classList.remove('is-open');
                    });


                    dropdown.classList.add('is-open');
                }

            });
        }
    });


    document.addEventListener('click', function (e) {
        if (!e.target.closest('.custom-dropdown')) {
            document.querySelectorAll('.custom-dropdown').forEach(d => {
                d.classList.remove('is-open');
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('authModal');
    const closeBtn = document.getElementById('closeAuthModal');
    const responseBlock = document.getElementById('authFormResponse');
    const ajaxUrl = (typeof wpStaticData !== 'undefined') ? wpStaticData.ajax_url : '/wp-admin/admin-ajax.php';


    const isGuest = !document.body.classList.contains('logged-in');
    const isHome = document.body.classList.contains('home') || document.body.classList.contains('front-page');

    if (isGuest && !isHome) {
        const main = document.querySelector('main');
        if (main) {
            main.style.height = (main.offsetHeight * 0.3) + 'px';
            main.style.overflow = 'hidden';
            main.style.position = 'relative';


            const paywallHTML = `                
                <div class="paywall-global-box">
                    <div class="paywall-global-overlay"></div>
                    <h3>🔑 Продовження перегляду заблоковано</h3>
                    <p>Будь ласка, увійдіть або зареєструйтеся, щоб переглянути матеріал повністю.</p>
                    <div class="paywall-global-buttons">
                        <button class="p-btn p-btn-primary open-auth-popup" data-tab="login">Увійти</button>
                        <button class="p-btn p-btn-outline open-auth-popup" data-tab="register">Реєстрація</button>
                    </div>
                </div>`;
            main.insertAdjacentHTML('afterend', paywallHTML);
        }
    }


    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('open-auth-popup')) {
            modal.style.display = 'flex';
            const tab = e.target.getAttribute('data-tab');
            switchTab(tab);
        }
    });


    if (closeBtn) closeBtn.onclick = () => modal.style.display = 'none';
    window.onclick = (e) => { if (e.target == modal) modal.style.display = 'none'; };


    const tabs = document.querySelectorAll('.auth-tab-btn');
    function switchTab(target) {
        tabs.forEach(t => t.classList.toggle('active', t.dataset.target === target));
        const loginForm = document.getElementById('customLoginForm');
        const regForm = document.getElementById('customRegisterForm');

        if (loginForm) loginForm.style.display = (target === 'login') ? 'block' : 'none';
        if (regForm) regForm.style.display = (target === 'register') ? 'block' : 'none';
        if (responseBlock) responseBlock.style.display = 'none';
    }
    tabs.forEach(t => t.onclick = () => switchTab(t.dataset.target));


    function initAjaxForm(formId, action) {
        const form = document.getElementById(formId);
        if (!form) return;
        form.onsubmit = function (e) {
            e.preventDefault();

            const submitBtn = form.querySelector('[type="submit"]');
            const formData = new FormData(form);

            
            formData.append('action', action);

            
            if (!formData.has('security') && typeof salee_auth_data !== 'undefined') {
                formData.append('security', auth_data.nonce);
            }

            
            if (submitBtn) {
                submitBtn.disabled = true;
            }

            
            responseBlock.style.display = 'block';
            responseBlock.innerHTML = '<div class="form-alert alert-loading"><span class="alert-spinner"></span> Обробка...</div>';

            
            const requestUrl = (typeof salee_auth_data !== 'undefined' && salee_auth_data.ajax_url)
                ? salee_auth_data.ajax_url
                : ajaxUrl;

            fetch(requestUrl, {
                method: 'POST',
                body: formData
            })
                .then(async (response) => {
                    
                    if (response.status === 403) {
                        throw new Error('Сесія застаріла. Оновіть сторінку та спробуйте знову.');
                    }

                    const data = await response.json();

                    if (data.success) {
                        responseBlock.innerHTML = `<div class="form-alert alert-success"><div class="alert-text">${data.data}</div></div>`;

                        if (action === 'custom_login') {
                            
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            form.reset();
                        }
                    } else {
                        responseBlock.innerHTML = `<div class="form-alert alert-error"><div class="alert-text">${data.data}</div></div>`;
                    }
                })
                .catch((err) => {
                    const errorText = err.message || 'Помилка мережі. Спробуйте пізніше.';
                    responseBlock.innerHTML = `<div class="form-alert alert-error"><div class="alert-text">${errorText}</div></div>`;
                })
                .finally(() => {
                    
                    if (submitBtn) {
                        submitBtn.disabled = false;
                    }
                });
        };
    }

    initAjaxForm('customLoginForm', 'custom_login');
    initAjaxForm('customRegisterForm', 'custom_register');




    if (window.location.search.includes('verified=success')) {
        if (modal && responseBlock) {

            modal.style.display = 'flex';


            switchTab('login');


            responseBlock.style.display = 'block';
            responseBlock.innerHTML = `
                <div class="form-alert alert-success" style="display: flex; align-items: center; gap: 10px;">
                    <svg viewBox="0 0 24 24" style="width: 24px; height: 24px; fill: none; stroke: #15803d; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <div class="alert-text" style="color: #15803d; font-weight: 600;">🎉 Ваш Email успішно підтверджено! Тепер ви можете увійти.</div>
                </div>
            `;


            const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({ path: cleanUrl }, '', cleanUrl);
        }
    }
});