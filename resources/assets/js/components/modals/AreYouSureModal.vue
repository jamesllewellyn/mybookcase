<template>
    <transition name="modal" mode="out-in">
        <div class="modal" :class="{'is-active' : modal.isVisible }" v-if="modal.isVisible">
            <div class="modal-background"  @click="hide()"></div>
            <div class="modal-card modal-container">
                <header class="modal-card-head">
                    <p class="modal-card-title" >Are you sure about that?</p>
                    <button class="delete" @click="hide()"></button>
                </header>
                <section class="modal-card-body">
                    <p>Do you really want to <span v-text="action"></span> ?</p>
                </section>
                <footer class="modal-card-foot">
                    <a class="button is-success" :class="{'is-loading': modal.isLoading}" @click="yes">Yes</a>
                    <a class="button" @click="hide">Cancel</a>
                </footer>
            </div>
        </div>
    </transition>
</template>

<script>
    import store from '../../store';
    export default {
        data() {
            return{
                action:'',
                yesAction : '',
                modalName : 'areYouSure'
            }
        },
        computed:{
            modal(){
                return store.getters.getModalByName(this.modalName);
            }
        },
        methods: {
            hide(){
                this.modal.hide();
            },
            yes(){
                /** set modal save button to loading status **/
                this.modal.loading();
                Event.$emit(this.yesAction);
            }
        },
        created: function() {
            let self = this;
            store.commit('modalAdd',  { name:  this.modalName })
            Event.$on('showAreYouSure', function(action, yesAction) {
                console.log('showAreYouSure event')
                self.action = action;
                self.yesAction = yesAction;
                self.modal.show();
            });
            Event.$on('hideAreYouSure', function() {
                self.action = '';
                self.yesAction = '';
                self.modal.hide();
            });
        }
    }
</script>
