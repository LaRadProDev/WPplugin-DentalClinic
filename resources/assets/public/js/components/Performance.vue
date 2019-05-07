<template>
    <div class="performance">
        <h3 class="heading">Questions Answered</h3>

        <div class="bar with-bg with-bg--gray">
            <span class="with-bg--gradient small" :style="{ width: stats.answered_questions_num / questions_num * 100 + '%' }">{{ stats.answered_questions_num }} of {{ questions_num }}</span>
        </div>

        <div class="score with-bg with-bg--gray">
            <div class="text big">
                <span>Your Average Score</span>
            </div>
            <div class="sector bigger">
                <span>{{ stats.avg_score }}%</span>
            </div>
        </div>

        <div class="rank with-bg with-bg--gray">
            <div class="img"><img :src="$plugin_url + '/static/public/img/bage.svg'" alt="label"></div>
            <span class="text big">You rank in the top {{ stats.rank }}% of students</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['stats', 'questions_num']
    }
</script>
