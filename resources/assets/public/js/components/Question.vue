<template>
    <div class="question">
        <div class="content" v-html="question.post_content">
        </div>
        <ul class="select-answer">
            <li v-for="(answer, key) in question.answers" :key="answer.name">
                <input type="radio" name="answer" :id="'answer-' + key" :disabled="showAnswer">
                <label class="answer middle flex align-center" :data-value="key" :for="'answer-' + key" @click="setAnswer">
                    <span class="switch"></span>{{ answer.name }}
                </label>
                <span v-if="showAnswer && !timed && answer.correct_answer == 1" class="check check--true"></span>
                <span v-if="showAnswer && !timed && answer.correct_answer == 0 && answerIndex == key" class="check check--false"></span>
            </li>
        </ul>
        <div class="btn-wrapper justify-end flex">
            <navigation></navigation>
            <button class="btn btn--sec" @click="submitAnswer" :disabled="showAnswer" :key="question.ID">Submit</button>
        </div>
        <div class="exp_content" v-if="showAnswer && !timed">
            <h2>Explanation</h2>
            <div v-html="question.exp_content">
            </div>
        </div>
    </div>
</template>

<script>
    import Qs from 'qs';
    import Navigation from '../components/Navigation.vue';

    export default {
        props: ['question', 'answered_question', 'question_key', 'timed'],
        data(){
            return {
                showAnswer: false,
                answerIndex: null,
                incorrect: false,
            }
        },
        components: {
            'navigation': Navigation
        },
        methods: {
            submitAnswer() {
                if (!this.answerIndex) {
                    return false;
                }
                this.showAnswer = true;

                this.question.answers.forEach((item, index) => {
                    if (index == this.answerIndex) {
                        this.incorrect = item.correct_answer == '0' ? index : false;
                    }
                });
                
                this.$store.commit('setAnsQuestionInArray', {question_key: this.question_key, incorrect: this.incorrect});

                this.$root.$emit('question-answered', this.answerIndex, this.question_key);

                let payload = {
                    action: 'save_to_history',
                    user_id: this.$store.state.userId,
                    question_id: this.question.ID,
                    incorrect: this.incorrect
                }

                axios.post(this.$ajaxurl, Qs.stringify(payload)).then((response) => {
                    // console.log(response.data);
                }).catch(function (error) {
                    console.log(error);
                });

            },
            setAnswer(e) {
                if (this.showAnswer) {
                    return
                }
                this.answerIndex = e.target.dataset.value;
            }
        },
        beforeMount() {
            if (this.answered_question) {
                this.showAnswer = true;
                this.answerIndex = this.answered_question.answerId;
            }
        }
    }
</script>
