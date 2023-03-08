import { $on, $delegate, qs, qsa } from './utils';

$on(document, 'DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const open = urlParams.get('open');

    /**
     * accordion
     */
    const target = '.accordion > article > h2';

    /**
     * toggle classes on click
     */
    $delegate(document, target, 'click', ev => {
        /**
         * close all except clicked one
         */
        qsa(target).forEach(elm => {
            if (elm != ev.target) {
                elm.classList.remove('active');
            }
        });

        /**
         * toggle clicked one
         */
        ev.target.classList.toggle('active');

        /**
         * scroll clicked element in center of viewport
         */
        ev.target.scrollIntoView({
            behavior: 'smooth',
            block: 'center',
            inline: 'center',
        });
    });

    /**
     * expand accordion if needed
     *
     * looks for url-paramter 'open=1,,3,,5,6'. comma separated with accordion-length
     * int -> open
     * null (empty) -> leave closed
     */
    if (open !== null) {
        open.split(',').forEach(item => {
            if (item != '') {
                item = Number(item);
                qs('.accordion > article:nth-of-type(' + (item + 1) + ') > h2').classList.add(
                    'active'
                );
            }
        });
    }
});

import '../scss/styles.scss';
