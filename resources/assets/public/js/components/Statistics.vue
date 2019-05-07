<template>
    <div class="statistics">
        <div class="statistics__score">
            <div>
                <span class="statistics__score-number">{{ Math.round(avgScore) }}%</span>
                <span class="statistics__score-text">Your score</span>
            </div>
        </div>
        <div class="statistics__questions">
            <ul>
                <li class="statistics__questions-item">
                    <span class="statistics__questions-item-number">{{ answered }}</span>
                    <span class="statistics__questions-item-text">Correct</span>
                </li>
                <li class="statistics__questions-item">
                    <span class="statistics__questions-item-number">{{ incorrect }}</span>
                    <span class="statistics__questions-item-text">Incorrect</span>
                </li>
                <li class="statistics__questions-item">
                    <span class="statistics__questions-item-number">{{ unanswered }}</span>
                    <span class="statistics__questions-item-text">Unanswered</span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import Qs from 'qs';

    export default {
        props: ['questions'],
        computed: {
            answered() {
                return this.questions.filter((q) => {
                    return q.incorrect === false;
                }).length;
            },
            avgScore() {
                return this.answered / this.questions.length * 100;
            },
            incorrect() {
                return this.questions.filter((q) => {
                    return q.incorrect !== false;
                }).length;
            },
            unanswered() {
                return this.$store.state.questions.length - this.answered - this.incorrect;
            }
        }
    }
</script>

<style lang="scss">
    .statistics {
        background-color: #ECE9E7;
        border-radius: 20px;
        display: flex;
        padding: 20px;
        margin-top: 25px;
    }

    .statistics__score {
        flex-basis: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-right: 1px solid #8a8a8a;
        margin-right: 20px;
    }

    .statistics__questions {
        flex-basis: 100%;

        ul {
            list-style: none;
        }
    }

    .statistics__score-number {
        display: block;
        line-height: 1;
        font-size: 64px;
        font-weight: 600;
        color: #133658;
    }

    .statistics__score-text {
        display: block;
        line-height: 1;
        text-transform: uppercase;
        font-size: 16px;
        font-weight: 600;
        color: #1E646E;
    }

    .statistics__questions-item {
        border-bottom: 1px solid #8a8a8a;
        font-size: 18px;

        &:last-child {
            border-bottom: none;
        }
    }

    .statistics__questions-item-number {
        font-weight: 900;
        width: 30%;
        display: inline-block;
        color: #133658;
    }

    .statistics__questions-item-text {
        color: #1E646E;
    }
</style>
