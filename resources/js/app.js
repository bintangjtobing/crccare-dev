/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'metismenu';

window.Vue = require('vue');
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Axios from 'axios';
import PerfectScrollbar from 'perfect-scrollbar';
import VueSweetalert2 from 'vue-sweetalert2';
import titleMixin from './mixins/titleMixins.js';
import vuetify from './plugins/vuetify.js';

Vue.mixin(titleMixin);

Vue.use(VueRouter, VueAxios, Axios, VueSweetalert2);
import Home from './components/Home.vue';
import User from './components/user.vue';
import File from './components/NewFile.vue';
import Data from './components/DataResult.vue';
import Guide from './components/UserGuide.vue';
import ChemicalList from './components/ChemicalList.vue';
import SummaryPage from './components/summary-page.vue';
import ScoresPage from './components/scoresPage.vue';
import UserForm from './components/UserForm.vue';
import ChemicalForm from './components/ChemicalForm.vue';
import ViewFile from './components/newFile/ViewFile.vue';
import NormalDistribution from './components/normalDistribution/NormalDistribution.vue';
import viewRadarChart from './components/viewRadarChart.vue';
import viewRankingScatter from './components/viewRankingScatter.vue';
import viewPieChart from './components/viewPieChart.vue';

const routes = [{
  name: 'home',
  path: '/',
  component: Home,
  meta: {
    title: 'Home | Dashboard mineCare'
  }
},
  {
    path: '/user-managements',
    component: User,
    meta: {
      title: 'User Managements | Dashboard mineCare'
    }
  },
  {
    path: '/new-file',
    component: File,
    meta: {
      title: 'New File | Dashboard mineCare'
    }
  },
  {
    path: '/data-results',
    component: Data,
    meta: {
      title: 'Data Results | Dashboard mineCare'
    }
  },
  {
    path: '/files/:id',
    component: File,
    meta: {
      title: 'Edit File | Dashboard mineCare'
    }
  },
  {
    path: '/user-guides',
    component: Guide,
    meta: {
      title: 'User Guide | Dashboard mineCare'
    }
  },
  {
    path: '/chemicals',
    component: ChemicalList,
    meta: {
      title: 'Chemical data list | Dashboard mineCare'
    }
  },
  {
    path: '/new/chemical-data-lists',
    component: ChemicalForm,
    meta: {
      title: 'New Chemical data list | Dashboard mineCare'
    }
  },
  {
    path: '/summary-result',
    component: SummaryPage,
  },
  {
    path: '/scores-page',
    component: ScoresPage,
  },
  {
    path: '/view-data-results/:id',
    component: ViewFile,
  },
  {
    name: 'adduser',
    path: '/new/user',
    component: UserForm,
    meta: {
      title: 'New User Data | Dashboard mineCare'
    }
  },
  {
    name: 'view-normal-distribution',
    path: '/overview/stat/normal-distribution',
    component: NormalDistribution,
  },
  {
    name: 'view-radar-chart',
    path: '/overview/stat/radar-chart',
    component: viewRadarChart,
  },
  {
    name: 'view-ranking-scatter',
    path: '/overview/stat/ranking-scatter',
    component: viewRankingScatter,
  },
  {
    name: 'view-pie-chart',
    path: '/overview/stat/pie-chart',
    component: viewPieChart,
  },
  {
    name: 'edit-user',
    path: '/update/user/:id',
    component: UserForm,
  },
  {
    name: 'edit-chemical',
    path: '/update/chemical/:id',
    component: ChemicalForm,
  },
];

const router = new VueRouter({
  mode: 'history',
  routes: routes,
  linkActiveClass: 'mm-active'
});
new Vue(Vue.util.extend({
  router,
  vuetify,
}, App)).$mount('#App');

// META TITLE
export default {
  router,
  watch: {
    $route: function (to) {
      document.title = to.meta.title;
    }
  },
}

$('.vertical-nav-menu').metisMenu();

$('.close-sidebar-btn').on('click', (event) => {
  const className = $(event.currentTarget).data('class');
  $('.app-container').toggleClass(className);
  $(event.currentTarget).toggleClass('is-active');
});

$('.mobile-toggle-nav').click(function () {
  $(this).toggleClass('is-active');
  $('.app-container').toggleClass('sidebar-mobile-open');
});

// Stop Bootstrap 4 Dropdown for closing on click inside
$('.dropdown-menu').on('click', function (event) {
  var events = $._data(document, 'events') || {};
  events = events.click || [];
  for (var i = 0; i < events.length; i++) {
    if (events[i].selector) {

      if ($(event.target).is(events[i].selector)) {
        events[i].handler.call(event.target, event);
      }

      $(event.target).parents(events[i].selector).each(function () {
        events[i].handler.call(this, event);
      });
    }
  }
  event.stopPropagation(); // Always stop propagation
});

// Responsive
const resizeClass = () => {
  const win = document.body.clientWidth;
  if (win < 1250) {
    $('.app-container').addClass('closed-sidebar-mobile closed-sidebar');
    $('.footer-nav').addClass('d-none');
  } else {
    $('.app-container').removeClass('closed-sidebar-mobile closed-sidebar');
    $('.footer-nav').removeClass('d-none');
  }
};

$(window).on('resize', () => {
  resizeClass();
});

resizeClass();

// handle menu scroll
const ps = new PerfectScrollbar('.scrollbar-sidebar', {
  wheelSpeed: 2,
  wheelPropagation: false,
  minScrollbarLength: 20
});

// hide/show logo when collapsing/expanding menu
$('.closed-sidebar-mobile, .closed-sidebar').on('mouseenter','.scrollbar-sidebar', () => {
  $('.footer-nav').removeClass('d-none');
});

$('.closed-sidebar-mobile, .closed-sidebar').on('mouseleave','.scrollbar-sidebar', () => {
  $('.footer-nav').addClass('d-none');
});
