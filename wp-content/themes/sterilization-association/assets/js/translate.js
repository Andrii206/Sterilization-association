function changeCustomLanguage(langCode, langText) {    
    const trigger = document.getElementById('custom-lang-trigger');
    if (trigger) {
        trigger.innerHTML = langText + ' <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>';
    }
    
    const dropdownMenu = document.querySelector('.lang-switcher .dropdown-menu');
    if (dropdownMenu) {
        dropdownMenu.classList.remove('show');
    }
    
    var teCombo = document.querySelector('.goog-te-combo');
            
    if (langCode === 'en') {
        if (teCombo) {            
            teCombo.value = 'en';
            var event = document.createEvent('HTMLEvents');
            event.initEvent('change', true, true);
            teCombo.dispatchEvent(event);
        } else {            
            document.cookie = "googtrans=/uk/en; path=/;";
            window.location.reload();
        }
    }             
    else if (langCode === 'uk') {                
    const rootDomain = location.hostname.split('.').slice(-2).join('.'); 
        const domainsToClear = [
            location.hostname, 
            '.' + location.hostname, 
            rootDomain, 
            '.' + rootDomain
        ];
        
        document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        domainsToClear.forEach(domain => {
            document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=" + domain + "; path=/;";
        });
        
        try {
            window.localStorage.removeItem('googtrans');
            window.sessionStorage.removeItem('googtrans');
        } catch (e) {}
        
        if (teCombo) {
            teCombo.value = '';
            var resetEvent = document.createEvent('HTMLEvents');
            resetEvent.initEvent('change', true, true);
            teCombo.dispatchEvent(resetEvent);
        }
        
        setTimeout(() => {
            window.location.reload();
        }, 100);
    }
}





function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}


let googtransCookie = getCookie('googtrans');
let activeLang = 'uk';

if (googtransCookie) {
    let parts = googtransCookie.split('/');
    if (parts.length > 2) {
        activeLang = parts[2];
    }
}


const langTrigger = document.getElementById('custom-lang-trigger');
if (langTrigger) {
    if (activeLang === 'en') {
        langTrigger.innerHTML = 'EN <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>';
    } else if (activeLang === 'uk') {
        langTrigger.innerHTML = 'UK <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>';
    }

}