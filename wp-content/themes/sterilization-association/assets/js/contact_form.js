document.addEventListener('DOMContentLoaded', function () {
    const dropdownTrigger = document.getElementById('selected-prefix');
    const dropdownMenu = document.querySelector('.phone-dropdown .dropdown-menu');
    const dropdownItems = document.querySelectorAll('.phone-dropdown .dropdown-menu-item');    
    const phoneInput = document.getElementById('phone-input');

    
    if (dropdownTrigger && dropdownMenu) {
        dropdownTrigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });
    }

    
    dropdownItems.forEach(function (item) {        
        item.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();  

            const prefix = this.getAttribute('data-prefix');
            const mask = this.getAttribute('data-mask');
            const itemText = this.innerText.trim();  

            
            const flag = Array.from(itemText)[0] || '🌐';
            
            if (dropdownTrigger) {
                dropdownTrigger.innerHTML = ' ▾ ' + flag + prefix;
            }

            
            const inputPrefix = document.getElementById('phone_prefix');
            if (inputPrefix) {
                inputPrefix.value = prefix;
            }

            
            if (phoneInput) {
                phoneInput.placeholder = mask; 
                phoneInput.value = '';        
                phoneInput.focus();           
            }

            
            if (dropdownMenu) {
                dropdownMenu.classList.remove('show');
            }
        });
    });

    
    document.addEventListener('click', function (e) {
        if (dropdownMenu && dropdownMenu.classList.contains('show')) {
            if (!e.target.closest('.phone-dropdown')) {
                dropdownMenu.classList.remove('show');
            }
        }
    });

    
    const form = document.getElementById('contactForm');
    const responseBlock = document.getElementById('formResponse');
    
    if (form && responseBlock) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            formData.append('action', 'send_consult_form');
            formData.append('nonce', wpStaticData.consult_form_nonce_action);
            responseBlock.style.display = 'block';
            responseBlock.innerHTML = '<div class="form-alert alert-loading"><span class="alert-spinner"></span> Обробка запиту...</div>';

            
            const ajaxUrl = (typeof wpStaticData !== 'undefined' && wpStaticData.ajax_url) ? wpStaticData.ajax_url : '/wp-admin/admin-ajax.php';

            fetch(ajaxUrl, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        responseBlock.innerHTML = `
                            <div class="form-alert alert-success">
                                <svg class="alert-icon" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                <div class="alert-text">${data.data}</div>
                            </div>
                        `;
                        
                        form.reset();
                        if (dropdownTrigger) dropdownTrigger.innerHTML = '🇺🇦 ▾ +380';
                        
                        const inputPrefix = document.getElementById('phone_prefix');
                        if (inputPrefix) inputPrefix.value = '+380';

                        setTimeout(() => {
                            responseBlock.style.opacity = '0';
                            responseBlock.style.transform = 'translateY(-10px)';
                            setTimeout(() => {
                                responseBlock.style.display = 'none';
                                responseBlock.style.opacity = '1';
                                responseBlock.style.transform = 'translateY(0)';
                            }, 400);
                        }, 5000);

                    } else {
                        responseBlock.innerHTML = `
                            <div class="form-alert alert-error">
                                <svg class="alert-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                <div class="alert-text">${data.data}</div>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    responseBlock.innerHTML = `
                        <div class="form-alert alert-error">
                            <svg class="alert-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            <div class="alert-text">Помилка відправки. Спробуйте пізніше або перевірте з'єднання.</div>
                        </div>
                    `;
                });
        });
    }
});