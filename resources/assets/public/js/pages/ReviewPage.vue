<template>
    <div class="container">
        <div class="header container--flex justify-between align-center">
            <p class="big heading">Review</p>
            <div class="controls">
                <router-link to="/" class="small link">
                    Return to dashboard <span> &gt; </span>
                </router-link>
            </div>
        </div>
        <div class="container--flex justify-between">
            <div class="column">
                <statistics v-if="questions" v-on:questions-num="setQuestionsNumber" :questions="questions"></statistics>
                <div class="review-filter">
                    <h3>Filter Questions</h3>
                    <span>{{ filtered_question.length }} questions found</span>
                </div>
                <button-group v-on:button-group-clicked="setFilterType" :buttons="['All questions', 'Incorrect questions']" type="correctness"></button-group>
                <button-group v-on:button-group-clicked="setFilterType" :buttons="['All questions', 'Flagged questions']" type="flagged"></button-group>
                <select-categories tax="medical_categories" name="Filter by Category" :reviewPage="true"></select-categories>
                <select-categories tax="years" name="Filter by Year" :reviewPage="true"></select-categories>
            </div>
            <div class="column">
                <question-list v-if="filtered_question" :questions="filtered_question"></question-list>
            </div>
        </div>
    </div>
</template>

<script>
    import Filter from '../components/Filter.vue';
    import SelectCategories from '../components/SelectCategories.vue';
    import ButtonGroup from '../components/ButtonGroup.vue';
    import QuestionList from '../components/QuestionList.vue';
    import Statistics from '../components/Statistics.vue';
    import Qs from 'qs';
    
    export default {
        data() {
            return {
                questions: [],
                filtered_question: [],
                marked: false,
                incorrect: false,
                filterTermsByCat: [],
                filterTermsByYear: []
            }
        },
        components: {
            'filter-component': Filter,
            'select-categories': SelectCategories,
            'button-group': ButtonGroup,
            'statistics': Statistics,
            'question-list': QuestionList
        },
        methods: {
            setQuestionsNumber(val) {
                this.total_questions = val;
            },
            filterQuestions(text, type) {

                let filtered_question = this.questions;

                filtered_question = filtered_question.filter((question) => {
                    if (!this.marked) {
                        return true;
                    }
                    return (question.marked === '1') ? true : false;
                });

                filtered_question = filtered_question.filter((question) => {
                    if (this.incorrect === false) {
                        return true;
                    } else if (this.incorrect === true) {
                        return (question.incorrect !== false) ? true : false;
                    }

                    return (question.incorrect === this.incorrect) ? true : false;
                });

                filtered_question = filtered_question.filter((question) => {
                    var includes = false;

                    if (!this.filterTermsByCat.length && !this.filterTermsByYear.length) {
                        return true;
                    }

                    question.terms.forEach((term) => {
                        if (this.filterTermsByCat.includes(term.slug) || this.filterTermsByYear.includes(term.slug)) {
                            includes = true;
                        }
                    });

                    return includes ? true : false;
                });

                this.filtered_question = filtered_question;
            },
            setFilterTerms(terms, tax) {
                if (tax == 'years') {
                    this.filterTermsByYear = terms;
                } else if (tax == 'medical_categories') {
                    this.filterTermsByCat = terms;
                }

                this.filterQuestions();
            },
            setFilterType(text, type) {
                text = text.toLowerCase();

                if (type == 'flagged') {
                    this.marked = '1';

                    if (text == 'all questions') {
                        this.marked = false;
                    }
                } else if (type == 'correctness') {
                    if (text == 'incorrect questions') {
                        this.incorrect = true;
                    } else if (text == 'all questions') {
                        this.incorrect = false;
                    }
                }

                this.filterQuestions();
            }
        },
        created() {
            this.$root.$on('category-selected', this.setFilterTerms);
            
            let attempted = this.$store.state.questions.filter((q) => {
                if (typeof q.incorrect == 'undefined') {
                    return false;
                }
                return true;
            });
            this.questions = this.filtered_question = attempted;
        }
    }
</script>
