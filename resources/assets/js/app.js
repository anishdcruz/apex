import Vue from 'vue'

Vue.component('typeahead', require('./components/Typeahead.vue'))
Vue.component('product', require('./components/modals/Product.vue'))

const app = new Vue({
    el: '#root',
    data: {
        name: '',
        ok: '',
        second: '',
        items: [
            {text: 'Apple', id: 1},
            {text: 'Mango', id: 2},
            {text: 'Pineapple', id: 3}
        ],
        list: [
            {text: '1', id: 1},
            {text: '2', id: 2},
            {text: '3', id: 3}
        ]
    },
    methods: {
        alert(event) {
            this.second = event.target.value.id
            console.log('okss', event)
        }
    }
})