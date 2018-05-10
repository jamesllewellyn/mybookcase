<template>
    <div class="column is-one-fifth">
        <!--<div class="">-->
            <router-link exact class="book" tag="div" :to="'/book/'+" >
            <img class="image cover" :src="coverUrl" alt="" width="180">
            <p class="book-title has-text-weight-bold">{{title}}</p>
            <p class="author">by
                <span v-for="(author, index) in authors" :key="index">
                    {{ author }}<span v-if="index != 0 && index == authors.length - 1">, </span>
                </span>
            </p>
            </router-link>
        <!--</div>-->
    </div>
</template>

<script>

    export default {
        props:{
            coverId:{
                type: String,
                required: false,
                default:null
            },
            title:{
                type: String,
                required: true
            },
            authors:{
                type: Array,
                required: true
            }
        },
        computed:{
            coverUrl(){
                if(!this.coverId){
                    return false;
                }
                return "http://covers.openlibrary.org/b/olid/"+this.coverId+"-L.jpg";
            }
        },
        mounted() {

        }
    }
</script>
