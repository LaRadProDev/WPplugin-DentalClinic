<template>
    <div v-if="active" class="question-modal" v-click-outside="deactivateModal">
        <div class="question-modal__cross" @click="deactivateModal"></div>
        <h2>{{ question.post_title }}</h2>
        <div class="question-modal__content" v-html="question.post_content">
        </div>
        <h3>Explanation</h3>
        <div class="question-modal__exp-content" v-html="question.exp_content">
        </div>
        <ul class="select-answer select-answer--disabled">
            <li v-for="(answer, key) in question.answers" :key="answer.name">
                <div class="answer middle container--flex align-center">
                    {{ answer.name }}
                </div>
                <span v-if="answer.correct_answer ==='1'" class="check check--true"></span>
                <span v-if="answer.correct_answer === '0' && question.incorrect === key" class="check check--false"></span>
            </li>
        </ul>
    </div>
</template>

<script>
    import ClickOutside from 'vue-click-outside'

    export default {
        props: {
            questions: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                questionIndex: 0,
                active: false,
                question: null
            }
        },
        methods: {
            activateModal(key) {
                setTimeout(() => {
                    this.question = this.questions[key];
                    this.active = true;
                }, 200);
            },
            deactivateModal() {
                this.active = false;
            }
        },
        directives: {
            ClickOutside
        },
        beforeMount() {
            this.question = this.questions[this.questionIndex];
            this.$root.$on('show-modal', this.activateModal);
        }
    }
</script>

<style lang="scss" scoped>
    .question-modal {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        max-width: 700px;
        height: 600px;
        background-color: white;
        border-radius: 20px;
        padding: 30px;
        overflow-x: scroll;
        box-shadow: 0 0 40px 10px #C4D3D5;

        .select-answer .answer {
            margin-right: 0;
        }
    }

    .question-modal__cross {
        position: absolute;
        right: 10px;
        top: 10px;
        width: 32px;
        height: 32px;
        cursor: pointer;

        &:after, &:before {
            content: '';
            display: block;
            width: 32px;
            height: 4px;
            background-color: #000;
            position: relative;
            top: 10px;
        }

        &:after {
            transform: rotate(45deg);
        }

        &:before {
            transform: rotate(-45deg);
            top: 14px;
        }

    }
</style>
