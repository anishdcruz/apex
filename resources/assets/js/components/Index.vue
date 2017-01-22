<template>
    <div class="panel">
        <div class="panel-heading">
            <p class="panel-title">
                <span>{{title}}</span>
            </p>
            <div class="panel-controls">
                <button class="btn btn-primary">Create Client</button>
                <button class="btn" @click="toggleFilter">
                    <i class="fa fa-filter"></i>
                </button>
            </div>
        </div>
        <div class="panel-body">
            <form @submit.prevent="submit" class="filter" v-if="showFilter">
                <div class="row">
                    <div class="col-sm-3">
                        <select class="form-control" v-model="query.search_column">
                            <option v-for="column in filter" :value="column">{{column}}</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control" v-model="query.search_operator">
                            <option v-for="(value, key) in operators" :value="key">{{value}}</option>
                        </select>
                    </div>
                    <div :class="[query.search_operator === 'between' ? 'col-sm-3' : 'col-sm-6']">
                        <input type="text" class="form-control" v-model="query.search_query_1">
                    </div>
                    <div class="col-sm-3" v-if="query.search_operator === 'between'">
                        <input type="text" class="form-control" v-model="query.search_query_2">
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-secondary">Filter</button>
                    </div>
                </div>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th v-for="column in thead">
                            <div class="sortable" @click="sort(column)">
                                <span v-text="column.title"></span>
                                <div class="sortable-direction" v-if="query.column === column.key">
                                    <span class="fa fa-sort-amount-desc" v-if="query.direction === 'desc'"></span>
                                    <span class="fa fa-sort-amount-asc" v-else></span>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <slot v-for="item in model.data" :item="item"></slot>
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <div class="pagination">
                <span class="pagination-status">Showing {{model.from}} - {{model.to}} of {{model.total}}</span>
                <div class="pagination-controls">
                    <button class="btn" @click="prevPage" :disabled="!model.prev_page_url">&laquo; Prev</button>
                    <button class="btn" @click="nextPage" :disabled="!model.next_page_url">Next &raquo;</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        props: ['thead', 'resource', 'title', 'filter'],
        data() {
            return {
                showFilter: false,
                operators: {
                    equal_to: '=',
                    not_equal: '<>',
                    less_than: '<',
                    greater_than: '>',
                    less_than_or_equal_to: '<=',
                    greater_than_or_equal_to: '>=',
                    in: 'IN',
                    not_in: 'NOT IN',
                    like: 'LIKE',
                    between: 'BETWEEN'
                },
                query: {
                    page: this.$route.query.page || 1,
                    per_page: this.$route.query.per_page || 13,
                    column: this.$route.query.column || 'id',
                    direction: this.$route.query.direction || 'desc',
                    search_column: this.$route.query.search_column || 'id',
                    search_operator: this.$route.query.search_operator || 'equal_to',
                    search_query_1: this.$route.query.search_query_1 || '',
                    search_query_2: this.$route.query.search_query_2 || ''
                }
            }
        },
        computed: {
            model() {
                return this.$store.getters.model
            }
        },
        methods: {
            toggleFilter() {
                this.showFilter = !this.showFilter
            },
            submit() {
                this.$router.push(this.link())
            },
            sort(column) {
                if(this.query.column === column.key) {
                    if(this.query.direction === 'desc') {
                        this.query.direction = 'asc'
                    } else {
                        this.query.direction = 'desc'
                    }
                } else {
                    this.query.column = column.key
                    this.query.direction = 'desc'
                }
                this.$router.push(this.link())
            },
            nextPage(){
                if(this.model.next_page_url) {
                    this.query.page++;
                    this.$router.push(this.link())
                }
            },
            prevPage() {
                if(this.model.prev_page_url) {
                    this.query.page--;
                    this.$router.push(this.link())
                }
            },
            toQuery (obj) {
              return Object.keys(obj).reduce(function (str, key, i) {
                var delimiter, val;
                delimiter = (i === 0) ? '?' : '&';
                key = encodeURIComponent(key);
                val = encodeURIComponent(obj[key]);
                return [str, delimiter, key, '=', val].join('');
              }, '');
            },
            link() {
                return `/${this.resource}${this.toQuery(this.query)}`
            }
        }
    }
</script>