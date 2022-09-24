import './bootstrap';

import jQuery from '$';
import 'flowbite';

import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

import '@fortawesome/fontawesome-free/scss/fontawesome.scss';
import '@fortawesome/fontawesome-free/scss/brands.scss';
import '@fortawesome/fontawesome-free/scss/regular.scss';
import '@fortawesome/fontawesome-free/scss/solid.scss';
import '@fortawesome/fontawesome-free/scss/v4-shims.scss';

import 'magnific-popup/dist/magnific-popup.css';
import 'magnific-popup/dist/jquery.magnific-popup.min';

import Alpine from 'alpinejs'
import FormsAlpinePlugin from './../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from './../../vendor/filament/notifications/dist/module.esm'

window.$ = jQuery;

Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(NotificationsAlpinePlugin)

window.Alpine = Alpine

Alpine.start()

// Open image as magnific popup (Ticket comments)
window.initMagnificPopupOnTicketComments = function () {
    if ($('.magnificpopup-container').length) {
        $('.magnificpopup-container').magnificPopup({
            type: 'image',
            delegate: 'img',
            gallery: {
                enabled: true
            },
            callbacks: {
                elementParse: function (qw) {
                    qw.src = qw.el.attr('src');
                }
            },
            image: {
                titleSrc: function (item) {
                    let title = '';
                    if (item.el.closest('figure').children('figcaption'))
                        title = item.el.closest('figure').children('figcaption').text();
                    return title;
                }
            }
        });
    }
};

(() => window.initMagnificPopupOnTicketComments())();

// Copy text to clipboard
window.unsecuredCopyToClipboard = function (text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
    } catch (err) {
        console.error('Unable to copy to clipboard', err);
    }
    document.body.removeChild(textArea);
}

// Tippy helper
window.makeTippy = function (selector, title) {
    tippy(selector, {
        content: title,
    });
}
