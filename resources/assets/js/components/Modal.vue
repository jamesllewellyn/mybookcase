<template>
    <transition name="modal" mode="out-in">
        <div class="modal" :class="{'is-active' : isVisible}">
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
    export default {
        props: {
            title: {
                type: String,
                required: true
            },
            isVisible:{
                type: Boolean,
                required: false
            }
        },
        methods: {
            hide(){
                this.$emit('close');
            },
        }
    }
</script>
