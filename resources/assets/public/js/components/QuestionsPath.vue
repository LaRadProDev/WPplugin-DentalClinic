<template>
    <div class="questions-path with-bg--gray">
        <span class="middle">QUESTIONS</span>
        <ul>
            <li v-for="(question, key) in visibleQuestions" 
                class="middle" 
                v-bind:class="{ active: activeQuestion == key }"
                @click="activeQuestion = key"
            >
                <div class="flex align-center"><span class="switch"></span>{{ key + 1 }}</div>
                <span  @click="toggleMarked(question.ID, $event)" data-marked="0" class="flag--gray">&#x2691;</span>
            </li>
        </ul>
    </div>
</template>

<script>
    import Qs from 'qs';

    export default {
        data() {
            return {
                visibleQuestions: [],
                passedQuestions: 0
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
            }
        },
        methods: {
            toggleMarked(id, e) {
                let marked = e.target.dataset.marked == '0' ? '1' : '0';
                e.target.dataset.marked = marked;
                e.target.className = e.target.className == 'flag--gray' ? 'flag--red' : 'flag--gray';
 
                // let payload = {
                //     action: 'toggle_marked',
                //     question_id: id,
                //     user_id: this.$store.state.userId,
                //     marked: marked
                // };
                // axios.post(this.$ajaxurl, Qs.stringify(payload)).then((response) => {
                    
                // }).catch(function (error) {
                //     e.target.dataset.marked = marked == '0' ? '1' : '0';
                // })

                this.questions.map((question) => {
                    if (id == question.ID) {
                        question.marked = marked;
                        return question;
                    }
                    return question;
                })
            }
        },
        watch: {
            questions() {
                this.visibleQuestions = this.questions.filter((item, index) => {
                    return index <= this.passedQuestions ? true : false;
                });
            },
            activeQuestion(val) {
                this.passedQuestions = this.passedQuestions <= val ? val : this.passedQuestions;
            },
            passedQuestions(val) {
                this.visibleQuestions = this.questions.filter((item, index) => {
                    return index <= val ? item : false;
                });
            }
        }
    }
</script>

