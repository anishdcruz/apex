<template>
    <div class="typeahead">
        <div @click="open" class="typeahead-input">
            <span class="form-control" v-if="value" v-text="showValue"></span>
            <span class="form-control" v-else>Select</span>
            <i class="fa fa-angle-down"></i>
        </div>
        <inner v-if="show" @close="close">
            <div class="typeahead-down">
                <div class="typeahead-wrap">
                    <input type="text" class="typeahead-control" v-model="search" ref="needFocus">
                </div>
                <div class="typeahead-list">
                    <div v-for="item in filtered" class="typeahead-item" @click="updateValue(item)">
                        <span v-text="item.text"></span>
                    </div>
                </div>
            </div>
        </inner>
    </div>
</template>
<script type="text/javascript">
    import Inner from './Inner.vue'
    export default {
        props: ['value', 'items'],
        data() {
            return {
                show: false,
                search: ''
            }
        },
        methods: {
            updateValue(item) {
                this.$emit('input', (item.id))
                this.$emit('changed', {target: {value: item}})
                this.close()
            },
            open() {
                this.show = true
            },
            close() {
                this.show = false
            }
        },
        computed: {
            showValue() {
                var vm = this
                var found = this.items.find(function(item) {
                  return item.id === vm.value
                })

                return found.text
            },
            filtered() {
              var self = this
              return this.items.filter(function (result) {
                var searchRegex = new RegExp(self.search, 'i')
                return (
                  searchRegex.test(result.id) ||
                  searchRegex.test(result.text)
                )
              })
            },
        },
        components: {
            Inner
        }
    }
</script>