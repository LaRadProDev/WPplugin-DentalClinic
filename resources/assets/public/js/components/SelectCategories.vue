<template>
    <div class="select-categories">
        <h4 class="bar with-bg with-bg--gradient middle"><span v-if="!name">Select {{ taxonomy ? taxonomy : 'Categories' }}</span><span v-if="name">{{ name }}</span></h4>
        <span v-if="showQuestionsNum" class="small">Questions Answered</span>
        <div class="select-categories__content with-bg with-bg--gray">
            <div v-show="loading" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
            <ul v-if="!loading">
                <template v-if="!reviewPage">
                    <li class="small">
                        <input ref="allCategories" type="checkbox" id="select-categories-all" name="category" checked="checked">
                        <div class="flex align-center">
                            <label for="select-categories-all" @click="toggleAll"></label>
                            <span>All {{ taxonomy ? taxonomy : 'Categories' }}</span>
                        </div>
                    </li>
                </template>
                <li class="small" v-for="category in categories">
                    <input type="checkbox" :id="category.slug" :value="category.slug" name="category" v-model="checkedCategories">
                    <div class="flex align-center">
                        <label v-bind:for="category.slug" @click="toggleCat"></label>
                        <span>{{ category.name }}</span>
                    </div>
                    <span class="select-categories__help-text" v-if="showQuestionsNum">({{ correctAnsweredNum(category.questions) }} <span>correct</span>, {{ incorrectAnsweredNum(category.questions) }} <span>incorrect of</span> {{ category.questions.length }})</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            showQuestionsNum: {
                type: Boolean,
                default: false
            },
            tax: {
                type: String
            },
            name: {
                type: String
            },
            reviewPage: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                taxonomy: '',
                checkedCategories: [],
                categories: [],
                loading: false,
                toggled: true
            }
        },
        methods: {
            toggleAll() {
                if (this.toggled) {
                    this.toggled = false;
                    return this.checkedCategories = this.categories.map((cat) => {
                        return cat.slug;
                    })
                }
                this.toggled = true;
                return this.checkedCategories = [];
            },
            toggleCat() {
                this.$refs.allCategories.checked = false;
                this.toggled = true;
                this.$store.commit('setTerms', this.checkedCategories);
                this.$root.$emit('category-selected', this.checkedCategories, this.tax);
            },
            retrieveTerms(taxonomy, name) {
                this.loading = true;

                axios.get(this.$base_rest_url + 'custom-taxonomies', {
                    params: {
                        tax_slug: taxonomy
                    }
                }).then((response) => {
                    this.toggled = true;
                    this.taxonomy = name;
                    this.categories = Object.values(response.data);
                    this.$store.commit('setCategories', Object.values(response.data));
                    this.loading = false;

                    if (!this.reviewPage) {
                        this.toggleAll();
                    }
                    
                }).catch(function (error) {
                    console.log(error);
                    this.loading = false;
                })
            },
            refreshCheckedTerms() {
                this.checkedCategories = [];
            },
            correctAnsweredNum(questions) {
                return questions.filter((question) => {
                    if (question.histories.length > 0) {
                        return !question.histories[0].incorrect ? true : false;
                    }
                    return false
                }).length;
            },
            incorrectAnsweredNum(questions) {
                return questions.filter((question) => {
                    if (question.histories.length > 0) {
                        return question.histories[0].incorrect ? true : false;
                    }
                    return false
                }).length;
            }
        },
        watch: {
            checkedCategories() {
                this.$store.commit('setTerms', this.checkedCategories);
                this.$root.$emit('category-selected', this.checkedCategories, this.tax);
            }
        },
        mounted() {
            this.$root.$on('filter-changed', this.retrieveTerms);
            this.$root.$on('filter-changed', this.refreshCheckedTerms);
            this.retrieveTerms(this.tax);
        }
    }
</script>

<style lang="scss">
    .select-categories__content {
        display: flex;
        justify-content: center;
    }
    .lds-ellipsis {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
        margin: 20px;
    }
    .lds-ellipsis div {
        position: absolute;
        top: 27px;
        width: 11px;
        height: 11px;
        border-radius: 50%;
        background: #fff;
        animation-timing-function: cubic-bezier(0, 1, 1, 0);
    }
    .lds-ellipsis div:nth-child(1) {
        left: 6px;
        animation: lds-ellipsis1 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(2) {
        left: 6px;
        animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(3) {
        left: 26px;
        animation: lds-ellipsis2 0.6s infinite;
    }
    .lds-ellipsis div:nth-child(4) {
        left: 45px;
        animation: lds-ellipsis3 0.6s infinite;
    }
    @keyframes lds-ellipsis1 {
        0% {
            transform: scale(0);
        }
        100% {
            transform: scale(1);
        }
    }
    @keyframes lds-ellipsis3 {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(0);
        }
    }
    @keyframes lds-ellipsis2 {
        0% {
            transform: translate(0, 0);
        }
        100% {
            transform: translate(19px, 0);
        }
    }
</style>
