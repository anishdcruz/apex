<template>
    <div id="root" class="root">
        <div class="sidebar">
            <h1>ok!</h1>
        </div>
        <div class="content">
            <div class="navbar">
                ok!
            </div>
            <router-view v-show="notLoading"></router-view>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        computed: {
            notLoading() {
                return !this.$store.state.loading
            }
        }
    }
</script>