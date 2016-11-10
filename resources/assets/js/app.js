import Vue from 'vue'
import axios from 'axios'
import event from './services/event'

// Set up some defaults for our favorite HTTP lib
axios.defaults.baseURL = '/api/'
axios.defaults.headers.common['X-CSRF-TOKEN'] = Laravel.csrfToken

// Prepare an event bus
event.init()

const app = new Vue({
  el: '#app',
  render: h => h(require('./app.vue'))
});
