<template>
  <div class="inner" ref="inside">
    <slot></slot>
  </div>
</template>
<script>
  export default {
    mounted() {
      this.$nextTick(function () {
        this.$parent.$refs.needFocus.focus()
      })

      document.addEventListener('click', this.onClick, true)
      document.addEventListener("keydown", this.onKey, true)
      // console.log('on')
    },
    beforeDestroy() {
      document.removeEventListener('click', this.onClick, true)
      document.removeEventListener("keydown", this.onKey, true)
      // console.log('off')
    },
    methods: {
      onClick(e) {
        const el = this.$refs.inside
        if (!el.contains(e.target)) {
          this.$emit('close', e)
        }
      },
      onKey(e) {
        if (e.keyCode == 27) {
          this.$emit('close', e)
        }
      }
    }
  }
</script></script>