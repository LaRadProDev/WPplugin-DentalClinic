<template>
    <div class="filter">
        <h3 class="heading">Filter Questions <span v-if="showQuestionsNum" class="small">{{ questionsNum }} questions selected</span></h3>
        <div class="bar with-bg with-bg--secondary">
            <span v-bind:class="{'with-bg--gray': by_category_active}" class="small" data-slug="medical_categories" data-name="Categories" v-on:click="changeFilter">BY CATEGORY</span>
            <span v-bind:class="{'with-bg--gray': by_year_active}" class="small" data-slug="years" data-name="Year(s)" v-on:click="changeFilter">BY YEAR</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            showQuestionsNum: {
                type: Boolean,
                default: false
            }
        },
        data() {
            return {
                by_category_active: true,
                by_year_active: false
            }
        },
        methods: {
            changeFilter(e) {
                if (e.target.dataset.slug == 'medical_categories') {
                    this.by_category_active = true;
                    this.by_year_active = false;
                } else {
                    this.by_year_active = true;
                    this.by_category_active = false;
                }
                this.$store.commit('refreshTerms');
                this.$root.$emit('filter-changed', e.target.dataset.slug, e.target.dataset.name);
            },
            filterCategories() {
                if (this.$store.state.quiz_data.terms.includes('all')) {
                    return this.$store.state.categories;
                }
                return this.$store.state.categories.filter((category) => {
                    return this.$store.state.quiz_data.terms.includes(category.slug) ? true : false;
                });
            },
            countAllQuestions() {
                let total = this.filterCategories().reduce((prev, category) => {
                    return prev + category.questions.length;
                }, 0);

                return total;
            },
            countIncorrectQuestions() {
                let total = this.filterCategories().reduce((prev, category) => {
                    return prev + category.questions.reduce((prev, question) => {
                        if (question.histories.length > 0) {
                            let number = !! question.histories[0].incorrect ? 1 : 0;
                            return prev + number;
                        }
                        return prev + 0;
                    }, 0);
                }, 0);

                return total;
            },
            countNewQuestions() {
                let total = this.filterCategories().reduce((prev, category) => {
                    return prev + category.questions.reduce((prev, question) => {
                        if (question.histories.length == 0) {
                            return prev + 1;
                        }
                        return prev + 0;
                    }, 0);
                }, 0);

                return total;
            },
            updateQuestionsNumber() {

                if (!this.$store.state.categories) {
                    return;
                }

                var total = 0;

                switch (this.$store.state.quiz_data.questions_type) {
                    case 'incorrect':
                        total = this.countIncorrectQuestions();
                        break;
                    case 'new':
                        total = this.countNewQuestions();
                        break;
                    case 'all':
                        total = this.countAllQuestions();
                        break;
                }
                
                this.$store.commit('setSelectedQuestionsNum', total)
            }
        },
        computed: {
            questionsNum() {
                return this.$store.state.selectedQuestionsNum;
            }
        },
        mounted() {
            this.$root.$on('category-selected', this.updateQuestionsNumber);
        }
    }
</script>