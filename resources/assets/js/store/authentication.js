export default {
    namespaced: true,
    state: {},
    mutations: {
        loginSuccess(state, {access_token, token_type, refresh_token}) {
            localStorage.setItem('access_token', access_token);
            localStorage.setItem('token_type', token_type);
            localStorage.setItem('refresh_token', refresh_token);
            return state.authError = null;
        },
        unauthorized() {
            localStorage.removeItem('access_token');
            localStorage.removeItem('token_type');
            localStorage.removeItem('refresh_token');
            Event.$emit('/login');
        },
        logout() {
            console.log('authentication/logout');
            localStorage.removeItem('access_token');
            localStorage.removeItem('token_type');
            localStorage.removeItem('refresh_token');
        }
    },
    actions: {
        login({commit}, {login}) {
            return new Promise((resolve, reject) => {
                axios.post('/oauth/token', login)
                    .then((response) => {
                        commit('loginSuccess', {
                            access_token: response.data.access_token,
                            token_type: response.data.token_type,
                            refresh_token: response.data.refresh_token
                        });
                        return resolve(response);
                    }, (error) => {
                        return reject(error);
                    });
            });
        },
        logout({commit}) {
            return new Promise((resolve, reject) => {
                // axios.delete('/oauth/token')
                //     .then((response) => {
                        commit('logout');
                        return resolve(true);
                    // }, (error) => {
                    //     return reject(error);
                    // });
            });
        }
    }
}