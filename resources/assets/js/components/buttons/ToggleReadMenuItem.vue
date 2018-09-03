<template>
    <a class="dropdown-item" @click="toggleRead">
        <span v-if="!read">Mark As Read</span>
        <span v-else>Mark As Not Read</span>
    </a>
</template>

<script>
    export default {
        props:['isbn'],
        computed:{
            read(){
                return this.$store.getters['bookcase/isFlaggedAsRead'](this.isbn);
            }
        },
        methods:{
            toggleRead(){
                let self = this;
                axios.put(`/api/book/${this.isbn}/read`)
                    .then((response) => {
                        if(response.data.read){
                            self.$store.commit('bookcase/addRead', self.isbn);
                        }else{
                            self.$store.commit('bookcase/removeRead', self.isbn);
                        }
                        self.$emit('readToggled');
                    }, (error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>



