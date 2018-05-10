<template>
    <div>
        <section class="modal-card-body">
            <multiselect v-model="selectedShelf" placeholder="Select a shelf to move this book to" :options="shelves" track-by="name" label="name" >
            </multiselect>
        </section>
        <footer class="modal-card-foot">
            <a class="button is-success" :class="{'is-loading': modal.isLoading}"  @click="moveToShelf()">Move To Shelf</a>
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
                selectedShelf: null,
                modalName : 'bookMoveShelf'
            }
        },
        computed:{
            modal(){
                return store.getters.getModalByName(this.modalName);
            },
            shelves(){
                return store.getters.getShelves;
            }
        },
        methods: {
            moveToShelf () {
                /** set modal save button to loading status **/
                this.modal.loading();
                /** dispatch add new project action **/
                store.dispatch('shelfMove', {shelf : this.selectedShelf, isbn : this.modal.data});
            },
            hide(){
                this.modal.hide();
            },
            /** method to get form field errors **/
            getErrors(fieldName) {
                return store.getters.getFormErrors(fieldName);
            }
        },
        created(){
            console.log('bookMoveShelf created')
        }
    }
</script>
