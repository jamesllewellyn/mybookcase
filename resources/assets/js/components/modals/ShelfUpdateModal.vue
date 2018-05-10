<template>
    <div>
        <section class="modal-card-body">
            <form>
                <div class="field">
                    <label class="label">Shelf Name</label>
                    <p class="control">
                        <input class="input" type="text" name="name" placeholder="Name your new shelf" v-model="shelf.name">
                    </p>
                    <p class="help is-danger" v-text="getErrors('name')"></p>
                </div>
                <div class="field">
                    <p class="control">
                        <input id="switchRoundedSuccess" type="checkbox" name="switchRoundedSuccess" class="switch is-rounded is-success is-rtl" v-model="shelf.public">
                        <label for="switchRoundedSuccess" class="label">Make Public</label>
                    </p>
                </div>
            </form>
        </section>
        <footer class="modal-card-foot">
            <a class="button is-success" :class="{'is-loading': modal.isLoading}"  @click="updateShelf()">Update Shelf</a>
            <a class="button"  @click="hide()">Cancel</a>
        </footer>
    </div>
</template>

<script>
    import store from '../../store';
    export default {
        data() {
            return{
                modalName : 'shelfUpdate',
            }
        },
        computed:{
            modal(){
                return store.getters.getModalByName(this.modalName);
            },
            shelf () { return this.$store.getters.getShelf }
        },
        methods: {
            updateShelf () {
                /** set modal save button to loading status **/
                this.modal.loading();
                /** dispatch add new project action **/
                store.dispatch('shelfUpdate');
            },
            hide(){
                this.modal.hide();
            },
            /** method to get form field errors **/
            getErrors(fieldName) {
                return store.getters.getFormErrors(fieldName);
            }
        }
    }
</script>
