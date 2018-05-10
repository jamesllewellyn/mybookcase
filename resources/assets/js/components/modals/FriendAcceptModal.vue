<template>
    <div>
        <section class="modal-card-body">
            <div class="card">
                <div class="card-content">
                    <div class="media">
                        <div class="media-left">
                            <figure class="image is-48x48">
                                <img class="avatar" :src="modal.data.avatar_url" alt="Placeholder image">
                            </figure>
                        </div>
                        <div class="media-content">
                            <p class="title is-4" v-text="modal.data.name">John Smith</p>
                            <p class="subtitle is-6">@{{modal.data.handle}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="modal-card-foot">
            <a class="button is-success" :class="{'is-loading': modal.isLoading}"  @click="accept()">Accept Friend Request</a>
            <a class="button"  @click="hide()">Cancel</a>
        </footer>
    </div>
</template>

<script>
    import store from '../../store';
    export default {
        data() {
            return{
                name : null,
                modalName : 'friendAcceptModal'
            }
        },
        computed:{
            modal(){
                return store.getters.getModalByName(this.modalName);
            }
        },
        methods: {
            accept () {
                /** set modal save button to loading status **/
                this.modal.loading();
                /** dispatch add new project action **/
                store.dispatch('friendAccept', this.modal.data.id);
            },
            hide(){
                this.modal.hide();
            },
            /** method to get form field errors **/
            getErrors(fieldName) {
                return store.getters.getFormErrors(fieldName);
            }
        },
    }
</script>
