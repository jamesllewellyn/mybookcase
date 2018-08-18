<template>
    <div class="content">
        <div class="columns is-multiline">
            <friend
                    v-for="(request, index) in sent" :key="index"
                    :request_id="request.id"
                    :id="request.friend.id"
                    :name="request.friend.name"
                    :handle="request.friend.handle"
                    :avatar_url="request.friend.avatar_url"
                    :type="'sent'"
            >
            </friend>
            <friend :placeholder="true" v-if="sent && sent.length === 0">
            </friend>
        </div>
    </div>
</template>

<script>
    import Friend from '../components/Friend';
    export default {
        components:{Friend},
        computed: {
            sent(){
                return this.$store.getters['friends/getSent'];
            }
        },
    }
</script>
