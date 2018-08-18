<template>
    <div class="content">
        <div class="columns is-multiline">
            <friend
                    v-for="(friend, index) in searchResults" :key="index"
                    :id="friend.id"
                    :name="friend.name"
                    :handle="friend.handle"
                    :avatar_url="friend.avatar_url"
                    :type="'search'"

            >
            </friend>
            <friend :placeholder="true" v-if="searchResults && searchResults.length === 0">
            </friend>
        </div>
    </div>
</template>

<script>
    import VueSimpleSpinner from 'vue-simple-spinner';
    import Friend from '../components/Friend';
    export default {
        data() {
            return {
                query : null,
                searchResults : [],
                isSearching : false
            }
        },
        components:{VueSimpleSpinner, Friend},
        computed:{
            queryString() {
                if (!this.$route.query.query) {
                    return false;
                }
                return  this.$route.query.query;
            },
        },
        methods: {
            search(page) {
                let self = this;
                this.isSearching = true;
                axios.get(`/api/friends-find?search=${this.query}`)
                    .then((response) => {
                        self.isSearching = false;
                        self.searchResults = response.data.users;
                        self.$route.query.query = self.query;
                    }, (error) => {
                        console.log(error);
                    });
            }
        },
        watch:{
            queryString(){
                if(this.queryString){
                    this.query = this.queryString;
                    this.search(1);
                }
            }
        },
        created() {
            if (this.$route.query.query) {
                this.query = this.$route.query.query;
                this.search(1);
            }
        }
    }
</script>
