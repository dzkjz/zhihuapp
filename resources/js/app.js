/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../../vendor/select2/select2/dist/js/select2.js');
// 将views/vendor/ueditor/assets.blade.php中的引用换到本处
require('../../public/vendor/ueditor/ueditor.config.js');
require('../../public/vendor/ueditor/ueditor.all.js');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('question-follow-button', require('./components/QuestionFollowButton').default);
Vue.component('user-follow-button', require('./components/UserFollowButton').default);
Vue.component('user-vote-button', require('./components/UserVoteButton').default);
Vue.component('send-message', require('./components/SendMessage').default);
Vue.component('comments', require('./components/Comments').default);
Vue.component('avatar', require('./components/Avatar').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
