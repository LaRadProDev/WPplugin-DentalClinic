<template>
    <div>
        <ul class="question-list">
            <li class="question-list-item" v-for="(question, key) in questions" :key="question.ID" @click="showModal(key)">
                <span class="question-list-item__line"></span>
                <span v-if="question.incorrect === false" class="check check--true"></span>
                <span v-else class="check check--false"></span>
                <div class="question-list-item__container">
                    <h4 class="question-list-item__title">{{ question.post_title }}</h4>
                    <!-- <span class="question-list-item__date">{{ question.date | moment("D MMM YYYY") }}</span> -->
                    <p class="question-list-item__content">
                        {{ question.post_content | striphtml | truncate(70, '...') }}
                    </p>
                </div>
                <span :class="marked(question.marked)">&#x2691;</span>
            </li>
        </ul>
        <question-modal :questions="questions"></question-modal>
    </div>
</template>

<script>
    import QuestionModal from './QuestionModal.vue';

    export default {
        props: {
            questions: {
                type: Array
            }
        },
        methods: {
            showModal(key) {
                this.$root.$emit('show-modal', key);
            },
            marked(marked) {
                return parseInt(marked) ? 'flag--red' : 'flag--gray';
            }
        },
        components: {
            'question-modal': QuestionModal
        }
    }
</script>

<style lang="scss">

    .question-list {
        margin: 0;
    }

    .question-list-item {
        position: relative;
        display: flex;
        padding: 20px 0;
        cursor: pointer;
        list-style: none;

        &:last-child {
            .question-list-item__line {
                display: none;
            }
        }

        h4 {
            font-size: 32px;
            margin: 0;
            font-weight: 400;
            color: #133658;
        }

        p {
            margin: 0;
        }

        .check {
            width: 34px;
            flex-shrink: 0;
            margin-right: 20px;
            position: static;
        }

        .flag--gray, .flag--red {
            font-size: 30px;
            align-self: center;
        }
    }

    .question-list-item__line {
        position: relative;

        &:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 13px;
            width: 8px;
            height: calc(100% + 40px);
            background-color: #8a8a8a;
            z-index: -1;
        }
    }

    .question-list-item__container {
        width: 100%;
    }
    
    .question-list-item__content {
        font-size: 18px;
        color: #1E646E;
    }

    .question-list-item__date {
        margin-right: 30px;
        width: 90px;
        display: block;
        flex-shrink: 0;
        text-align: center;
    }
</style>
