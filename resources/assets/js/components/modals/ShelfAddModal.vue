<template>
    <modal title="Create a New Shelf" :isVisible="isVisible" @close="hide">
        <template slot="body">
            <section class="modal-card-body">
                <form>
                    <div class="field">
                        <label class="label">Shelf Name</label>
                        <p class="control">
                            <input class="input" type="text" name="name" placeholder="Name your new shelf"
                                   v-model="name">
                        </p>
                        <p class="help is-danger" v-text="getErrors('name')"></p>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot">
                <a class="button is-success" :class="{'is-loading': isLoading}" @click="addShelf()">Create
                    Shelf</a>
                <a class="button" @click="hide()">Cancel</a>
            </footer>
        </template>
    </modal>
</template>

<script>
    import Modal from '../Modal.vue';
    import Errors from '../../core/Errors';

    export default {
        data() {
            return {
                isLoading: false,
                name: null,
                formErrors: new Errors()
            }
        },
        components: {Modal},
        props: ['isVisible'],
        methods: {
            addShelf() {
                let self = this;
                this.isLoading = true;
                this.$store.dispatch('bookcase/addShelf', this.name)
                    .then((response) => {
                        self.isLoading = false;
                        return self.$emit('close');
                    }, (error) => {
                        /** if error display feedback to user */
                        self.formErrors.record(error.response.data.errors);
                        self.isLoading = false;
                        return false;
                    });
                //
                // axios.post(`/api/user/shelf`,)
                //     .then((response) => {
                //         /** add new shelf to bookcase in store **/
                //         this.$store.commit('bookcase/addShelf', {shelf: response.data.shelf});
                //         self.hide();
                //         self.isLoading = false;
                //     }, (error) => {
                //         if (error.response.data) {
                //             /** if error display feedback to user */
                //             self.formErrors.record(error.response.data.errors);
                //             self.isLoading = false;
                //             return false;
                //         }
                //     });
            },
            hide() {
                this.$emit('close');
            },
            /** method to get form field errors **/
            getErrors(fieldName) {
                return this.formErrors.get(fieldName);
            }
        },
    }
</script>
