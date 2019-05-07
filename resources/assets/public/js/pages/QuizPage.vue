<template>
    <div class="container">
        <div class="header container--flex justify-between align-center">
            <p class="big heading">Question {{ activeQuestion + 1 }} of {{ questionsNum }}</p>
            <div class="controls">
                <navigation></navigation>
                <router-link to="/review" class="small with-bg--secondary">
                    END QUIZ
                </router-link>
            </div>
        </div>
        <div class="main container--flex justify-between">

            <div class="col-8">
                <question 
                    v-if="questionsNum && activeQuestion == key" 
                    v-for="(question, key) in questions" 
                    :key="question.ID" 
                    :question="question" 
                    :question_key="key"
                    :answered_question="answered_question[key] ? answered_question[key] : false"
                    :timed="time ? true : false"
                ></question>
            </div>

            <div class="col-4">
                <time-remainder v-if="time" :time="time"></time-remainder>
                <questions-path></questions-path>
            </div>
        </div>
    </div>
</template>

<script>
    import TimeRemainder from '../components/TimeRemainder.vue';
    import QuestionsPath from '../components/QuestionsPath.vue';
    import Question from '../components/Question.vue';
    import Navigation from '../components/Navigation.vue';
    import Qs from 'qs';


    export default {
        data() {
            return {
                time: 0
            }
        },
        components: {
            'time-remainder': TimeRemainder,
            'questions-path': QuestionsPath,
            'question': Question,
            'navigation': Navigation
        },
        methods: {
            setAnswerQuestionsData(answerIndex, questionIndex) {
                this.answered_question = {questionId: this.activeQuestion, answerId: answerIndex, questionIndex: questionIndex};
            },
            fetchQuestions() {
                let payload = {
                    action: 'fetch_questions',
                    ...this.$store.state.quiz_data
                }
                axios.post(this.$ajaxurl, Qs.stringify(payload)).then((response) => {
                    this.$store.commit('setQuestions', response.data);
                    this.$store.commit('setQuestionsNum', response.data.length);
                    this.$store.commit('setQuestion', response.data[this.activeQuestion]);
                }).catch(function (error) {
                    console.log(error);
                })
            }
        },
        computed: {
            activeQuestion: {
                get () {
                    return this.$store.state.activeQuestion;
                },
                set (value) {
                    this.$store.commit('setActiveQuestion', value)
                }
            },
            questions() {
                return this.$store.state.questions;
            },
            questionsNum() {
                return this.$store.state.questionsNum;
            },
            answered_question: {
                get () {
                    return this.$store.state.answered_question;
                },
                set (value) {
                    this.$store.commit('setAnsweredQuestionsData', value)
                }
            }
        },
        beforeMount() {
            this.time = this.$store.state.quiz_data.time;
            this.fetchQuestions();
            this.$root.$on('question-answered', this.setAnswerQuestionsData);
        }
    }
</script>
