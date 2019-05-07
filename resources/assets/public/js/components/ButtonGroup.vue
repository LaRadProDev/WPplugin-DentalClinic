<template>
    <div class="button-group">
        <button :class="{active: activeButton == key}" v-for="(button, key) in buttons" :key="button" @click="setActiveButton(key, $event)">{{ button }}</button>
    </div>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                required: true
            },
            buttons: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                activeButton: 0
            }
        },
        methods: {
            setActiveButton(key, e) {
                this.activeButton = key;
                this.$emit('button-group-clicked', e.target.innerText, this.type);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .button-group {
        display: flex;
        align-items: center;
        padding: 10px;
        margin-left: -5px;
        margin-right: -5px;
        background-color: #133658;
        border-radius: 20px;
        margin-top: 30px;

        button {
            font-size: 16px;
            padding: 5px 15px;
            text-align: center;
            border-radius: 10px;
            color: white;
            text-transform: uppercase;
            font-weight: 500;
            flex-basis: 100%;
            background-color: transparent;
            border: none;

            &.active {
                background-color: #ECE9E7;
                color: #133658;
            }
        }
    }
</style>

