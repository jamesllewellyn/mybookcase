export default {
    namespaced: true,
    state: {
        isAuthenticated: false,
        user: null,
        readCount: 0
    },
    mutations: {
        getSuccess: (state, {user}) => {
            state.user = user;
            return state.isAuthenticated = true;
        },
        updateSuccess: (state, {user}) => {
            return state.user = user;
        },
        updateReadCount: (state, readCount) => {
            console.log(readCount);
            return state.user.read_count = readCount;
        },
        clear: (state) => {
            console.log('user/clear');
            state.user = null;
            return state.isAuthenticated = false;
        },
    },
    actions: {
        get: ({commit}) => {
            return new Promise((resolve, reject) => {
            axios.get('/api/user')
                .then((response) => {
                    commit('getSuccess', {user: response.data.user});
                    return resolve(response);
                }, (error) => {
                    reject(error);
                });
            });
        },
        update: ({commit, state}, user) => {
            return new Promise((resolve, reject) => {
                console.log(user);
                axios.put(`/api/user/${state.user.id}`, user)
                    .then((response) => {
                        commit('updateSuccess', {user: response.data.user});
                        return resolve(response);
                    }, (error) => {
                        if (error.response.data) {
                            return reject(error.response.data.errors);
                        }
                    });
            });
        },
    },
    getters: {
        get: (state) => {
            if (!state.user) {
                return false;
            }
            return state.user;
        },
        getUserId: (state) => {
            if (!state.user) {
                return false
            }
            return state.user.id;
        },
        isAuthenticated(state) {
            return state.isAuthenticated;
        },
    }
}