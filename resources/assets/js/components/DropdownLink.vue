<template>
    <li>
        <a @click.stop="go">
            <slot></slot>
        </a>
    </li>
</template>
<script type="text/javascript">
    export default {
        props: ['to'],
        methods: {
            go() {
                this.$router.push(this.to)
                this.$parent.$parent.close()
            }
        }
    }
</script>