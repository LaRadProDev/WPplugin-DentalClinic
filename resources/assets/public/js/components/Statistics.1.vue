<template>
    <div class="statistics" v-if="stats && questions_num">
        <div class="statistics__score">
            <div>
                <span class="statistics__score-number">{{ stats.avg_score }}%</span>
                <span class="statistics__score-text">Your score</span>
            </div>
        </div>
        <div class="statistics__questions">
            <ul>
                <li class="statistics__questions-item">
                    <span class="statistics__questions-item-number">{{ stats.answered_questions_num }}</span>
                    <span class="statistics__questions-item-text">Correct</span>
                </li>
                <li class="statistics__questions-item">
                    <span class="statistics__questions-item-number">{{ this.questions.length - stats.answered_questions_num }}</span>
                    <span class="statistics__questions-item-text">Incorrect</span>
                </li>
                <li class="statistics__questions-item">
                    <span class="statistics__questions-item-number">{{ this.questions_num - this.questions.length }}</span>
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
        data() {
            return {
                stats: null,
                questions_num: 0
            }
        },
        beforeMount() {
            axios.get(this.$base_url + '/wp-json/wp/v2/users/me').then((response) => {
                this.$store.commit('setUserId', response.data.id);

                let payload = {
                    action: 'get_stats',
                    user_id: this.$store.state.userId
                }
                axios.post(this.$ajaxurl, Qs.stringify(payload)).then((response) => {
                    this.stats = response.data;
                    console.log(this.stats);
                }).catch(function (error) {
                    console.log(error);
                })
            }).catch(function (error) {
                console.log(error);
            });

            axios.get(this.$base_url + '/wp-json/wp/v2/question').then((response) => {
                this.questions_num = response.data.length;
                this.$emit('questions-num', this.questions_num);
            }).catch(function (error) {
                console.log(error);
            });
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
