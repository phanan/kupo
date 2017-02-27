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

window.SnippetPreview = require( "yoastseo" ).SnippetPreview;
var Yoast = require( "yoastseo" ).App;

window.doYoast = function() {
    var focusKeywordField = document.getElementById( "focusKeyword" );
    var contentField = document.getElementById( "content" );
    var titleField = document.getElementById( "title" );
    var metaDescField = document.getElementById( "metaDesc" );
    var urlPathField = document.getElementById( "urlPath" );
    var baseUrlField = document.getElementById( "baseUrl" );

    var snippetPreview = new SnippetPreview({
        targetElement: document.getElementById( "snippet" ),
        data: {
            title: titleField.value,
            metaDesc: metaDescField.value,
            urlPath: urlPathField.value
        },
        baseURL: baseUrlField.value
    });

    var yoast = new Yoast({
        snippetPreview: snippetPreview,
        targets: {
            output: "output"
        },
        callbacks: {
            getData: function() {
                return {
                    keyword: focusKeywordField.value,
                    text: contentField.value,

                };
            }
        }
    });

    yoast.refresh();

};
