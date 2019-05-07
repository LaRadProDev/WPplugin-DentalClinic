<template>
    <div class="time-remainder with-bg--gray container--flex flex-column align-center">
        <countdown :time="time * 60 * 1000">
            <template slot-scope="props">{{ props.minutes }}:{{ props.seconds }}</template>
        </countdown>
        <p class="small">Time remaining</p>
    </div>
</template>

<script>
    export default {
        props: ['time']
    }
</script>

<style lang="scss" scoped>
    .time-remainder {
        padding: 30px 35px 20px;
        text-align: center;
        min-width: 200px;
        margin-bottom: 35px;
        

        span {
            font-size: 60px;
            line-height: 1;
            margin-bottom: 10px;
            font-family: 'Roboto Mono', monospace;
        }

        p {
            margin: 0;
        }
    }
</style>

