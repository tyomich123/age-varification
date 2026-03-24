(function () {
    const config = window.LyuboshchiAgeGate || {};
    const modal = document.getElementById('lyuboshchi-age-gate');

    if (!modal || !config.cookieName) {
        return;
    }

    const body = document.body;

    const hasCookie = (name) => {
        const search = `${name}=`;
        return document.cookie.split(';').some((item) => item.trim().startsWith(search));
    };

    const setCookie = (name, value, days) => {
        const maxAge = Number(days) * 24 * 60 * 60;
        document.cookie = `${name}=${value}; max-age=${maxAge}; path=/; SameSite=Lax`;
    };

    const showModal = () => {
        modal.classList.add('is-active');
        modal.setAttribute('aria-hidden', 'false');
        body.style.overflow = 'hidden';
    };

    const hideModal = () => {
        modal.classList.remove('is-active');
        modal.setAttribute('aria-hidden', 'true');
        body.style.overflow = '';
    };

    if (!hasCookie(config.cookieName)) {
        showModal();
    }

    modal.addEventListener('click', (event) => {
        const button = event.target.closest('[data-age-action]');

        if (!button) {
            return;
        }

        const action = button.getAttribute('data-age-action');

        if (action === 'yes') {
            setCookie(config.cookieName, '1', config.cookieDays || 30);
            hideModal();
            return;
        }

        if (action === 'no') {
            window.location.href = config.redirectUrl || 'https://www.google.com/';
        }
    });
})();
