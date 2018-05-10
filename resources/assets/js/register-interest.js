require('./bootstrap');

window.Vue = require('vue');

Vue.component('user-register-form', require('./components/invitations/InterestedUser.vue'));
/** structure components **/
const app = new Vue({
    el: '#app',
    data() {
        return {
            email: '',
            formErrors: [],
            hasRegisteredInterest: false,
            isLoading: false
        }
    },
    components: {},
    computed: {},
    methods: {
        submit() {
            let self = this
            this.isLoading = true;
            axios.post(`/api/interested-user`, {email : this.email})
                .then((response) => {
                    self.isLoading = false;
                    self.hasRegisteredInterest = true;
                }, (error) => {
                    if (error.response.data) {
                        self.isLoading = false;
                        return self.formErrors = error.response.data.errors;
                    }
                });
        },
        getErrors(fieldName) {
            if (this.formErrors[fieldName]) {
                return this.formErrors[fieldName][0];
            }
        }
    },
    mounted() {

    }
});
