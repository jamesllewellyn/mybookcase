<template>
    <modal title="Update Shelf" :isVisible="isVisible" @close="hide">
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
                    <div class="field">
                        <p class="control">
                            <input id="switchRoundedSuccess" type="checkbox" name="switchRoundedSuccess"
                                   class="switch is-rounded is-success is-rtl" v-model="public">
                            <label for="switchRoundedSuccess" class="label">Make Public</label>
                        </p>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot">
                <a class="button is-success" :class="{'is-loading': isLoading}" @click="updateShelf()">Update Shelf</a>
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
                'public': false,
                formErrors: new Errors()
            }
        },
        props: ['isVisible', 'shelf', 'userId'],
        components: {Modal},
        methods: {
            updateShelf() {
                let self = this;
                this.isLoading = true;
                this.$store.dispatch('bookcase/updateShelf', {id : this.shelf.id, shelf : {name: this.name, 'public': this.public}})
                    .then((response) => {
                        self.isLoading = false;
                        return self.hide();
                    }, (error) => {
                        self.formErrors.record(error);
                        return self.isLoading = false;
                    });
            },
            hide() {
                this.$emit('close');
            },
            /** method to get form field errors **/
            getErrors(fieldName) {
                return this.formErrors.get(fieldName);
            }
        },
        mounted() {
            this.name = this.shelf.name;
            this.public = this.shelf.public;
        }
    }
</script>
