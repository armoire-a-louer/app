import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faTags, faCopyright, faHome, faVenusMars, faPalette, faRecycle, faCircleCheck, faCircleXmark, faPlus, faChevronDown, faChevronLeft, faChevronRight, faChevronCircleUp, faStar, faCheck, faPersonDress, faHeart as faHeartSolid, faXmark, faSackDollar, faTriangleExclamation, faArrowLeft, faArrowRight, faSliders } from '@fortawesome/free-solid-svg-icons'
import { faStar as faStarRegular, faCalendar, faHeart, faUser } from '@fortawesome/free-regular-svg-icons'
import { faStripe } from '@fortawesome/free-brands-svg-icons'

/* add icons to the library */
library.add(faTags, faCopyright, faHome, faVenusMars, faPalette, faRecycle, faCircleCheck, faCircleXmark, faPlus, faChevronDown, faChevronLeft, faChevronRight, faStar, faStarRegular, faCheck, faPersonDress, faCalendar, faHeart, faHeartSolid, faXmark, faStripe, faSackDollar, faUser, faTriangleExclamation, faChevronCircleUp, faArrowLeft, faArrowRight, faSliders);

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('font-awesome-icon', FontAwesomeIcon)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
