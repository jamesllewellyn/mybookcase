<template>
    <div>
        <section class="modal-card-body">
            <form>
                <div class="field">
                    <label class="label">Shelf Name</label>
                    <p class="control">
                        <input class="input" type="text" name="name" placeholder="Name your new shelf" v-model="name">
                    </p>
                    <p class="help is-danger" v-text="getErrors('name')"></p>
                </div>
            </form>
        </section>
        <footer class="modal-card-foot">
            <a class="button is-success" :class="{'is-loading': modal.isLoading}"  @click="addShelf()">Create Shelf</a>
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
                modalName : 'bookMoveShelf'
            }
        },
        computed:{
            modal(){
                return store.getters.getModalByName(this.modalName);
            }
        },
        methods: {
            addShelf () {
                /** set modal save button to loading status **/
                this.modal.loading();
                /** dispatch add new project action **/
                store.dispatch('shelfAdd', this.name);
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
