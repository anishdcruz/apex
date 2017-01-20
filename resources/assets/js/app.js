import Vue from 'vue'

Vue.component('typeahead', require('./components/Typeahead.vue'))

const app = new Vue({
    el: '#root',
    data: {
        name: '',
        ok: '',
        items: [
            {text: 'Apple', id: 1},
            {text: 'Mango', id: 2},
            {text: 'Pineapple', id: 3}
        ]
    },
    methods: {
        alert(item) {
            this.ok = item
            console.log('okss')
        }
    }
})