'use strict';

// import './config.js';
// import 'alpinejs';
// import SimpleBar from 'simplebar';
// import GLightbox from 'glightbox';
// import Rellax from 'rellax';
// import MicroModal from 'micromodal';
// import LazyLoad from "vanilla-lazyload";
// import { tns } from 'tiny-slider/src/tiny-slider';
// import './modules/bootstrap-modules.js';
// import './modules/markjs.js';
// import './modules/smooth-scroll.js';
// import './modules/scroll-to-top.js';
// import './modules/timezone-offset.js';
import { $on, qs } from './modules/utils';
import '../scss/styles.scss';

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

