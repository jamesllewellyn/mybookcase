export default {
    namespaced: true,
    state: {
        friends: {
            'sent': [],
            'pending': [],
            'active': [],
        },
    },
    mutations: {
        getSuccess: (state, {pending, sent, active}) => {
            state.friends.pending = pending;
            state.friends.sent = sent;
            return state.friends.active = active;
        },
        requestSent(state, {friend}) {
            return state.friends.sent.push(friend);
        },
        requestRescinded(state, friendRequestId) {
            return state.friends.sent = _.reject(state.friends.sent, ['id', friendRequestId]);
        },
        requestAccepted(state, {friend, friendRequestId}) {
            state.friends.active.push(friend);
            return state.friends.pending = _.reject(state.friends.pending, ['id', friendRequestId]);
        },
        requestDeclined(state, {friend, friendRequestId}) {
            return state.friends.pending = _.reject(state.friends.pending, ['id', friendRequestId]);
        },
    },
    actions: {
        get({state, commit}) {
            axios.get(`/api/friends`)
                .then((response) => {
                    commit('getSuccess', {
                        pending: response.data.pending,
                        sent: response.data.sent,
                        active: response.data.active
                    })
                }, (error) => {
                    console.log(error);
                });
        },
        sendRequest({state, commit}, friendId) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/friend-request/${friendId}`)
                    .then((response) => {
                        if(!response.data.success){
                            return reject(response);
                        }
                        commit('requestSent', {friend: response.data.friend});
                        return resolve(response);
                    }, (error) => {
                        return reject(error);
                    });
            });
        },
        rescindRequest({state, commit}, friendRequestId) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/friend-request/${friendRequestId}`)
                    .then((response) => {
                        if(!response.data.success){
                            return reject(response);
                        }
                        commit('requestRescinded', friendRequestId);
                        return resolve(response);
                    }, (error) => {
                        return reject(error);
                    });
            });
        },
        acceptRequest({state, commit}, friendRequestId) {
            return new Promise((resolve, reject) => {
                axios.put(`/api/friend-request/${friendRequestId}`, {accept : true})
                    .then((response) => {
                        if(!response.data.success){
                            return reject(response);
                        }
                        commit('requestAccepted', {friend : response.data.friend, friendRequestId : friendRequestId});
                        return resolve(response);
                    }, (error) => {
                        return reject(error);
                    });
            });
        },
        declineRequest({state, commit}, friendRequestId) {
            return new Promise((resolve, reject) => {
                axios.put(`/api/friend-request/${friendRequestId}`, {accept : false})
                    .then((response) => {
                        if(!response.data.success){
                            return reject(response);
                        }
                        commit('requestDeclined', {friend : response.data.friend, friendRequestId : friendRequestId});
                        return resolve(response);
                    }, (error) => {
                        return reject(error);
                    });
            });
        },
    },
    getters: {
        getActive(state) {
            return state.friends.active;
        },
        getSent(state) {
            return state.friends.sent;
        },
        getPending(state) {
            return state.friends.pending;
        },
        getCount(state) {
            return {
                pending: state.friends.pending.length,
                sent: state.friends.sent.length,
                active: state.friends.active.length
            };
        }
    }
}