<template>
    <div>
        <h2 class="big">Welcome, {{ user_name }}</h2>
        <div class="container container--flex justify-between">
            <div class="column">
                <div class="welcome with-underline">
                    <router-link to="/start" class="btn big bar justify-center with-bg with-bg--primary heading">
                        <span>QUICK START</span>
                    </router-link>
                </div>
                <filter-component :showQuestionsNum="true"></filter-component>
                <select-categories :showQuestionsNum="true" tax="medical_categories"></select-categories>
                <x-selection
                    type="type"
                    title="Question Selection" 
                    placeholder="Select a question type"
                    :select="[
                        {title: 'Show new questions only', value: 'new'}, 
                        {title: 'Show incorrect questions only', value: 'incorrect'}, 
                        {title: 'Show all questions', value: 'all'}
                    ]"
                >
                </x-selection>
                <x-selection 
                    type="num"
                    title="Number of Questions" 
                    placeholder="Select the number of question"
                    :select="[
                        {title: '10 Questions', value: 10}, 
                        {title: '20 Questions', value: 20}, 
                        {title: '30 Questions', value: 30}, 
                        {title: '60 Questions', value: 60}
                    ]"
                >
                </x-selection>
                <select-time></select-time>
                <router-link to="/start" class="btn">
                    <span>QUICK START</span>
                </router-link>
            </div>
            <div class="column">
                <div class="with-underline">
                    <h3 class="heading heading--margin-bottom">Your Performance</h3>
                </div>
                <performance v-if="stats && questions_num" :stats="stats" :questions_num="questions_num"></performance>
                <p class="text-center" v-else>We’re still collecting more data of your performance. Please Complete a more quizzes to see your performance</p>
            </div>
        </div>
    </div>
</template>

<script>
    import Filter from '../components/Filter.vue';
    import SelectCategories from '../components/SelectCategories.vue';
    import XSelection from '../components/XSelection.vue';
    import SelectTime from '../components/SelectTime.vue';
    import Performance from '../components/Performance.vue';
    import Qs from 'qs';

    export default {
        data() {
            return {
                user_name: '',
                stats: null,
                questions_num: 0
            }
        },
        components: {
            'filter-component': Filter,
            'select-categories': SelectCategories,
            'x-selection': XSelection,
            'select-time': SelectTime,
            'performance': Performance
        },
        beforeMount() {
            axios.get(this.$base_url + '/wp-json/wp/v2/users/me').then((response) => {
                this.user_name = response.data.name;
                this.$store.commit('setUserId', response.data.id);

                let payload = {
                    action: 'get_stats',
                    user_id: this.$store.state.userId
                }
                axios.post(this.$ajaxurl, Qs.stringify(payload)).then((response) => {
                    this.stats = response.data;
                }).catch(function (error) {
                    console.log(error);
                })
            }).catch(function (error) {
                console.log(error);
            });

            let payload = {
                action: 'get_questions_num',
            }

            axios.post(this.$ajaxurl, Qs.stringify(payload)).then((response) => {
                this.questions_num = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
</script>

<style lang="scss" scoped>
    .welcome {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;

        h2 {
            padding: 0;
            margin: 0;
        }
    }
</style>
