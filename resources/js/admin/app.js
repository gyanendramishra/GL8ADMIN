import Vue from 'vue';
import VueMeta from 'vue-meta';
import PortalVue from 'portal-vue';
import { App, plugin } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress/src';

import store from './Store';

Vue.config.productionTip = false;
Vue.mixin({ methods: { route: window.route } });
Vue.use(plugin);
Vue.use(PortalVue);
Vue.use(VueMeta);

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  color: '#29d',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: true,
});

const el = document.getElementById('app')

new Vue({
  metaInfo: {
    titleTemplate: title => (title ? `${title} - GL8ADMIN` : 'GL8ADMIN'),
  },
  render: h =>
    h(App, {
      props: {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: name => import(`@admin/Pages/${name}`).then(module => module.default),
      },
    }),
  store
}).$mount(el)
