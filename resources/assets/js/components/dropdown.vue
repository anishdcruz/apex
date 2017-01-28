<template>
    <div class="dropdown">
        <button :class="['btn', show ? 'dropdown-active' : '']" @click="toggle">
            <span class="dropdown-btn">
                <span>{{title}}</span>
                <i class="fa fa-caret-down"></i>
            </span>
        </button>
        <inner v-if="show" @close="close">
            <ul class="dropdown-list">
                <slot></slot>
            </ul>
        </inner>
    </div>
</template>
<script type="text/javascript">
    import Inner from './Inner.vue'
    export default {
        props: ['title'],
        mounted() {
            this.$on('close', function(e) {
                alert('ok')
            })
        },
        components: {
            Inner
        },
        data() {
            return {
                show: false
            }
        },
        methods: {
            toggle() {
                this.show = !this.show
            },
            close() {
                this.show = false
            }
        }
    }
</script>