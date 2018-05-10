<template>
    <transition name="modal" mode="out-in">
        <div class="modal" :class="{'is-active' : modal.isVisible }" v-if="modal.isVisible">
            <div class="modal-background"  @click="hide()"></div>
            <div class="modal-card modal-container">
                <header class="modal-card-head">
                    <p class="modal-card-title" v-text="title"></p>
                    <button class="delete" @click="hide()"></button>
                </header>
                <slot name="body"></slot>
            </div>
        </div>
    </transition>
</template>

<script>
    import store from '../store';
    export default {
        data() {
            return{
            }
        },
        props: {
            modalName : {
                type: String,
                required: true
            },
            title: {
                type: String,
                required: true
            },
        },
        computed:{
            modal(){
                return store.getters.getModalByName(this.modalName);
            }
        },
        created() {
            console.log(this.modalName )
            store.commit('modalAdd',  { name:  this.modalName })
        },
        methods: {
            hide(){
                this.modal.hide();
            },
        }
    }
</script>
