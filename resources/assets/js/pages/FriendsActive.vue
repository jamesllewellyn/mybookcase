<template>
    <div class="content">
        <div class="columns is-multiline">
            <friend
                    v-for="(friend, index) in active" :key="index"
                    :id="friend.id"
                    :name="friend.name"
                    :handle="friend.handle"
                    :avatar_url="friend.avatar_url"
                    :type="'active'"

            >
            </friend>
            <friend :placeholder="true" v-if="active && active.length == 0">
            </friend>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{

            }
        },
        computed: {
            active(){
                return this.$store.state.friends.active;
            }
        },
        methods: {

        },
        watch: {
        },
        created() {
        }
    }
</script>
