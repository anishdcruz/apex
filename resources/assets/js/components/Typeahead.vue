<template>
    <div class="typeahead">
        <span class="typeahead-input form-control" @click="open" v-text="selectedValue"></span>
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
                search: '',
                selectedValue: 'Select'
            }
        },
        methods: {
            updateValue(item) {
                this.selectedValue = item.text
                this.$emit('input', this.selectedValue)
                this.$emit('changed', item)
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