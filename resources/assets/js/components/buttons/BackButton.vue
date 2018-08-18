<template>
    <a class="button back-button" @click="$router.go(-1)">
        <span class="icon is-medium">
          <i class="fas fa-long-arrow-alt-left"></i>
        </span>
        <!--<span>Back</span>-->
    </a>
</template>

<script>
    export default {
        data() {
            return {}
        },
    }
</script>

<style lang="scss" scoped>
    .back-button {
        position: absolute;
        top: 5px;
        left: 5px;
        width:55px;
        height:40px;
    }
</style>



