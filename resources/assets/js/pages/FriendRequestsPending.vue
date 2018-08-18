<template>
    <div class="content">
        <div class="columns is-multiline">
            <friend
                v-for="(request, index) in pending" :key="index"
                :request_id="request.id"
                :id="request.user.id"
                :name="request.user.name"
                :handle="request.user.handle"
                :avatar_url="request.user.avatar_url"
                :type="'pending'"

            >
            </friend>
            <friend :placeholder="true" v-if="pending && pending.length === 0">
            </friend>
        </div>
    </div>
</template>

<script>
    import Friend from '../components/Friend';
    export default {
        components:{Friend},
        computed: {
            pending(){
                return this.$store.getters['friends/getPending'];
            }
        }
    }
</script>
