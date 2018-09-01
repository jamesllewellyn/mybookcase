<template>
    <a class="dropdown-item" @click="toggleReading">
        <span v-if="!reading">Mark As Reading</span>
        <span v-else>Remove From Reading</span>
    </a>
</template>

<script>
    export default {
        props:['isbn'],
        computed:{
            reading(){
                return this.$store.getters['bookcase/isFlaggedAsReading'](this.isbn);
            }
        },
        methods:{
            toggleReading(){
                let self = this;
                axios.put(`/api/book/${this.isbn}/reading`)
                    .then((response) => {
                        if(response.data.reading){
                            self.$store.commit('bookcase/addReading', self.isbn);
                        }else{
                            self.$store.commit('bookcase/removeReading', self.isbn);
                        }
                        self.$emit('readingToggled');
                    }, (error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>



