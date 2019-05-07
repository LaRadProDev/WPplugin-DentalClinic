import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        quiz_data: {
            time: 0,
            questions_num: 30,
            questions_type: 'new',
            terms: []
        },
        userId: null,
        questions: [],
        categories: null,
        question: null,
        answered_question: [],
        activeQuestion: 0,
        questionsNum: 0,
        selectedQuestionsNum: 0
    },
    mutations: {
        setTime(state, time) {
            state.quiz_data.time = time;
        },
        setUserId(state, userId) {
            state.userId = userId;
        },
        setNumber(state, number) {
            state.quiz_data.questions_num = number;
        },
        setType(state, type) {
            state.quiz_data.questions_type = type;
        },
        setTerms(state, terms) {
            state.quiz_data.terms = terms;
        },
        setQuestions(state, questions) {
            state.questions = questions;
        },
        setQuestion(state, question) {
            state.question = question;
        },
        setCategories(state, categories) {
            state.categories = categories;
        },
        setQuestionsNum(state, questionsNum) {
            state.questionsNum = questionsNum;
        },
        setActiveQuestion(state, activeQuestion) {
            state.activeQuestion = activeQuestion;
        },
        setSelectedQuestionsNum(state, total) {
            state.selectedQuestionsNum = total;
        },
        setAnsQuestionInArray(state, val) {
            Vue.set(state.questions[val.question_key], 'incorrect', val.incorrect)
        },
        setAnsweredQuestionsData(state, answQuestionsData) {
            state.answered_question[answQuestionsData.questionIndex] = answQuestionsData;
        },
        refreshQuizData(state) {
            state.quiz_data.time = 0;
            state.quiz_data.questions_num = 30;
            state.quiz_data.questions_type = 'new';
            state.quiz_data.terms = [];
        },
        refreshQuestions(state) {
            state.questions = []
            state.categories = null
            state.question = null
            state.answered_question = []
            state.activeQuestion = 0
            state.questionsNum = 0
            state.selectedQuestionsNum = 0
        },
        refreshTerms(state) {
            state.quiz_data.terms = [];
        }
    }
});