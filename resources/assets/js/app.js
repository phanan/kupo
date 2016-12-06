import Vue from 'vue'
import axios from 'axios'
import event from './services/event'

// Set up some defaults for our favorite HTTP lib
axios.defaults.baseURL = '/api/'
axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken

// Prepare an event bus
event.init()

new Vue({
  el: '#app',
  render: h => h(require('./app.vue'))
})
