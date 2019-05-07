<template>
    <div class="x-selection">
        <h3 class="heading">{{ title }}</h3>
        <div v-click-outside="hide">
            <p class="bar with-bg with-bg--gradient middle justify-between" @click="active = !active">
                <span ref="placeholder">{{ placeholder }}</span>
                <span class="arrow" :class="active ? 'arrow--up' : 'arrow--down'"></span>
            </p>
            <ul v-show="active" class="with-bg with-bg--gray middle">
                <li v-for="(item, key) in select" @click="setSelectItem(key)">{{ item.title }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    import ClickOutside from 'vue-click-outside'

    export default {
        props: [
            'title',
            'placeholder',
            'select',
            'type'
        ],
        data() {
            return {
                active: false
            }
        },
        methods: {
            hide() {
                this.active = false
            },
            setSelectItem(key) {
                this.$refs.placeholder.innerText = this.select[key].title
                this.active = false;
                if (this.type == 'num') {
                    this.$store.commit('setNumber', this.select[key].value);
                } else {
                    this.$store.commit('setType', this.select[key].value);
                    this.$root.$emit('category-selected');
                }
            }
        },
        directives: {
            ClickOutside
        },
        mounted() {
            if (this.type == 'num') {
                return this.setSelectItem(2);
            }
            return this.setSelectItem(0);
        }
    }
</script>
