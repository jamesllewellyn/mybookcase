<template>
    <div class="content user-page">
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return{

            }
        },
        components:{},
        computed: {
        },
        methods: {
        },
        watch: {
        },
        created() {
        }
    }
</script>
