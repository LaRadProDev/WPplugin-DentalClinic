<template>
    <div class="navigation container--flex align-center">
        <a href="#" class="small" v-if="activeQuestion != 0" @click.prevent="activeQuestion--; changeQuestion"><span> &lt; </span> PREVIOUS QUESTION </a>
        <a href="#" class="small" v-if="activeQuestion + 1 != questionsNum" @click.prevent="activeQuestion++; changeQuestion">NEXT QUESTION <span> &gt; </span></a>
    </div>
</template>

<script>
    export default {
        computed: {
            activeQuestion: {
                get () {
                    return this.$store.state.activeQuestion;
                },
                set (value) {
                    this.$store.commit('setActiveQuestion', value)
                }
            },
            questionsNum() {
                return this.$store.state.questionsNum;
            }
        },
        methods: {
            changeQuestion() {
                this.$root.$emit('change-question', this.activeQuestion);
            }
        }
    }
</script>
