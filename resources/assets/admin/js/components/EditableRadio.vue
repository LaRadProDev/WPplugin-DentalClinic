<template>
    <ul>
        <li v-for="(answer, key) in answers">
            <input class="vue-editable-radio__input" type="radio" name="correct_answer" :checked="answer.correct_answer == '1'" :data-id="key" @click="setCorrectAnswer">
            <input class="vue-editable-radio__input" type="text" name="answer" v-model="answer.name">
        </li>
    </ul>
</template>

<script>
    import Qs from 'qs';

    export default {
        props: ['value'],
        data() {
            return {
                answers: [
                    {name: '', correct_answer: 0},
                    {name: '', correct_answer: 0},
                    {name: '', correct_answer: 0},
                    {name: '', correct_answer: 0},
                    {name: '', correct_answer: 0}
                ]
            }
        },
        methods: {
            setCorrectAnswer(e) {
                let correct_answer_id = e.target.dataset.id;

                let new_answers = this.answers.map((el, index) => {
                    if (correct_answer_id == index) {
                        el.correct_answer = 1
                    } else {
                        el.correct_answer = 0;
                    }
                    return el;
                })
                this.answers = new_answers;
            },
            saveData() {
                setTimeout(() => {
                    let payload = {
                        action: 'save_answers',
                        answers: this.answers,
                        url: window.location.href
                    }
                    axios.post(this.$ajaxurl, Qs.stringify(payload)).then((response) => {
                        console.log(response);
                    });
                    let btn = jQuery(".editor-post-publish-button");
                    btn.click(this.saveData);
                }, 200);
            }
        },
        mounted() {
            
            if (this.value) {
                this.answers = this.value;
            }

            jQuery( window ).on( "load", () => {
                let btn = jQuery(".editor-post-publish-button");
                btn.click(this.saveData);

                jQuery('.editor-post-publish-panel__toggle').click(() => {
                    setTimeout(() => {
                        let btn = jQuery(".editor-post-publish-button");
                        btn.click(this.saveData);
                    }, 300)
                })
            });
        }
    }
</script>

<style>
    .vue-editable-radio__input {
        width: 60%;
    }
</style>
