<template>
    <div class="timer">
        <h3 class="heading">Timed Questions?</h3>
        <vue-slider v-model="time" :max="90" :dotSize="20"></vue-slider>
        <div class="limits flex justify-between middle">
            <span>NOT<br />TIMED</span><span>90<br />MINS</span>
        </div>
        <p v-bind:class="{active: avgWithText}" class="info middle">{{ avgWithText }}<br />(national average 3 minutes per
            question)</p>
    </div>
</template>

<script>
    import VueSlider from 'vue-slider-component'
    import 'vue-slider-component/theme/default.css'

    export default {
        data() {
            return {
                time: 0
            }
        },
        components: {
            VueSlider
        },
        computed: {
            numberOfQuestions: {
                get () {
                    return this.$store.state.quiz_data.questions_num;
                }
            },
            avgPerQuestion() {
                return Math.round((this.numberOfQuestions / this.time) * 10) / 10;
            },
            avgWithText() {
                let output = !this.time || !this.numberOfQuestions
                    ? '' 
                    : `an average ${this.avgPerQuestion} minutes per question`;

                return output;
            }
        },
        watch: {
            time(val) {
                this.$store.commit('setTime', val);
            }
        }
    }
</script>

<style lang="scss">
    .vue-slider-rail {
        background-color: #133658;
        height: 3px;
    }

    .vue-slider {
        height: 45px !important;
        display: flex;
        align-items: center;
        background: #ece9e7;
        border-radius: 20px;
        padding: 10px 40px !important;
        margin-bottom: 25px;
    }

    .vue-slider-dot-handle {
        background-color: #1e646e;
        box-shadow: none;
    }
    .timer {
        .info {
            opacity: 0;
        }
        .info.active {
            opacity: 1;
        }
    }

    .vue-slider-dot-tooltip {
        visibility: visible;
    }

    .vue-slider-dot-tooltip-inner {
        border-color: #133658;
        background-color: #133658;
    }

    .vue-slider-process {
        background-color: white;
    }
</style>
