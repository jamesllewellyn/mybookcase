import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

/** import Classes */
import Modal from '../core/Modal'
import Bookcase from '../core/Bookcase'
import Shelf from "../core/Shelf";

const store = new Vuex.Store({
    state: {
        user: null,
        bookcase: {
            shelves: {}
        },
        friends: {
            'sent': null,
            'pending': null,
            'active': null,
        },
        shelf: null,
        bestSellers: null,
        book: null,
        pageLoading: true,
        searchAsyncResults: null,
        lastAsyncSearchTime: null,
        friendsSearchAsyncResults: null,
        showFriendsSearchOptions: false,
        searchResults: null,
        searchQuery: null,
        isLoadingOptions: false,
        isSearching: false,
        showSearchOptions: false,
        modals: [], /** all app models */
        formErrors: {}, /** current form errors */
    },
    actions: {
        /** user **/
        userGet({commit}) {
            axios.get('/api/user')
                .then((response) => {
                    commit('userGetSuccess', {user: response.data.user})
                    commit('createUsersBookcase', {shelves: response.data.shelves})
                }, (error) => {
                    console.log(response);
                });
        },
        userUpdate({state, commit}, user) {
            axios.put(`/api/user/${state.user.id}`, user)
                .then((response) => {
                    commit('userGetSuccess', {user: response.data.user})
                    commit('modalHide', {name: 'userUpdateModal'})
                    Event.$emit('changePage', `/user/@${response.data.user.handle}`);
                }, (error) => {
                    if (error.response.data) {
                        /** if error display feedback to user */
                        commit('userUpdateError', {errors: error.response.data.errors});
                        commit('modalLoaded', {name: 'userUpdateModal'});
                        return false;
                    }
                });
        },
        /** Goodreads */
        searchGoodreads({state, commit}, query) {
            commit('toggleIsSearching');
            commit('clearSearchResults');
            commit('pageIsLoading');
            state.isSearching = true;
            state.searchResults = null;
            axios.get('/api/goodreads?search=' + query)
                .then((response) => {
                    commit('searchSuccess', {searchResults: response.data.searchResults, query: query})
                }, (error) => {
                    console.log(response);
                });
        },
        searchAsyncFind({state, commit}, query) {
            commit('toggleIsSearching');
            state.isLoadingOptions = true;
            state.lastAsyncSearchTime = _.now();
            axios.get('/api/goodreads?search=' + query)
                .then((response) => {
                    commit('searchAsyncFindSuccess', {searchResults: response.data.searchResults, query: query})
                }, (error) => {
                    console.log(response);
                });
        },
        getGoodreadsBook({commit}, {id, isbn}) {
            commit('clearBook');
            axios.get(`/api/goodreads/${id}?isbn=${isbn}`)
                .then((response) => {
                    commit('bookGetSuccess', {book: response.data.book})
                }, (error) => {
                    console.log(response);
                });
        },
        /** New York Times */
        newYorkTimeGetBestSellers({commit}) {
            axios.get(`/api/new-york-times/best-sellers`)
                .then((response) => {
                    commit('newYorkTimeGetBestSellersSuccess', {bestSellers: response.data.bestSellers})
                }, (error) => {
                    console.log(response);
                });
        },
        /** Shelves */
        shelfAdd({state, commit}, name) {
            axios.post(`/api/user/${state.user.id}/shelf`, {name})
                .then((response) => {
                    commit('shelfAddSuccess', {shelf: response.data.shelf})
                    commit('modalHide', {name: 'shelfAdd'})
                }, (error) => {
                    if (error.response.data) {
                        /** if error display feedback to user */
                        commit('shelfAddError', {errors: error.response.data.errors});
                        commit('modalLoaded', {name: 'shelfAdd'});
                        return false;
                    }
                });
        },
        shelfGet({state, commit}, id) {
            state.shelf = null
            axios.get(`/api/user/${state.user.id}/shelf/${id}`)
                .then((response) => {
                    commit('shelfGetSuccess', {shelf: response.data.shelf})
                    commit('shelfGetsBookSuccess', {books: response.data.books})
                }, (error) => {
                    console.log(error);
                });
        },
        shelfUpdate({state, commit}) {
            axios.put(`/api/user/${state.user.id}/shelf/${state.shelf.id}`, {
                name: state.shelf.name,
                'public': state.shelf.public
            })
                .then((response) => {
                    commit('modalHide', {name: 'shelfUpdate'})
                }, (error) => {
                    if (error.response.data) {
                        /** if error display feedback to user */
                        commit('shelfUpdateError', {errors: error.response.data.errors});
                        commit('modalLoaded', {name: 'shelfUpdate'});
                        return false;
                    }
                });
        },
        shelfDelete({state, commit}, id) {
            axios.delete(`/api/user/${state.user.id}/shelf/${id}`)
                .then((response) => {
                    commit('modalHide', {name: 'areYouSure'})
                    commit('shelfDeleteSuccess', {id})
                }, (error) => {
                    if (error.response.data) {
                        /** if error display feedback to user */
                        commit('shelfUpdateError', {errors: error.response.data.errors});
                        commit('modalLoaded', {name: 'shelfUpdate'});
                        return false;
                    }
                });
        },
        shelfAddBook({state, commit}, shelf) {
            axios.post(`/api/user/${state.user.id}/shelf/${shelf.id}/book`, {
                isbn: state.book.isbn,
                isbn_13: state.book.isbn13
            })
                .then((response) => {
                    commit('modalHide', {name: 'addToShelf'})
                    commit('shelfAddBookSuccess', {shelf: shelf})
                }, (error) => {
                    if (error.response.data) {
                        /** if error display feedback to user */
                        commit('shelfUpdateError', {errors: error.response.data.errors});
                        commit('modalLoaded', {name: 'shelfUpdate'});
                        return false;
                    }
                });
        },
        shelfRemoveBook({state, commit}, isbn) {
            axios.delete(`/api/user/${state.user.id}/shelf/${state.shelf.id}/book/${isbn}`)
                .then((response) => {
                    commit('modalHide', {name: 'areYouSure'})
                    commit('shelfRemoveBookSuccess', {isbn: response.data.isbn})
                }, (error) => {
                    if (error.response.data) {
                        /** if error display feedback to user */
                        commit('shelfUpdateError', {errors: error.response.data.errors});
                        commit('modalLoaded', {name: 'shelfUpdate'});
                        return false;
                    }
                });
        },
        shelfMove({state, commit}, {shelf, isbn}) {
            axios.put(`/api/user/${state.user.id}/shelf/${state.shelf.id}/book/${isbn}`, {'new_shelf_id': shelf.id})
                .then((response) => {
                    console.log(response)
                    commit('modalHide', {name: 'bookMoveShelf'})
                    commit('shelfMoveSuccess', {book: response.data.book})
                }, (error) => {
                    // if(error.response.data){
                    //     /** if error display feedback to user */
                    //     commit('shelfUpdateError', { errors:  error.response.data.errors });
                    //     commit('modalLoaded', {name : 'shelfUpdate'});
                    //     return false;
                    // }
                });
        },
        /** Friends **/
        searchAsyncFindFriends({state, commit}, search) {
            // commit('toggleIsSearching');
            // state.isLoadingOptions = true;
            // state.lastAsyncSearchTime = _.now();
            axios.get(`/api/friends?search=${search}`)
                .then((response) => {
                    commit('friendsSearchAsyncSuccess', {users: response.data.users})
                }, (error) => {
                    console.log(response);
                });
        },
        friendAdd({state, commit}, friendId) {
            axios.post(`/api/user/${state.user.id}/friend-request/${friendId}`)
                .then((response) => {
                    commit('modalHide', {name: 'friendAddModal'})
                    commit('friendAddSuccess', {friend: response.data.friend})
                }, (error) => {
                    console.log(response);
                });
        },
        friendsGet({state, commit}) {
            axios.get(`/api/friend/`)
                .then((response) => {
                    console.log(response)
                    // commit('modalHide', {name: 'friendAddModal'})
                    commit('friendsGetSuccess', {
                        pending: response.data.pending,
                        sent: response.data.sent,
                        active: response.data.active
                    })
                }, (error) => {
                    console.log(response);
                });
        },
        friendAccept({state, commit}, friendId) {
            axios.put(`/api/user/${state.user.id}/friend-request/${friendId}`, {'accept': true})
                .then((response) => {
                    commit('modalHide', {name: 'friendAcceptModal'})
                    commit('friendAcceptSuccess', {friend: response.data.friend})
                }, (error) => {
                    console.log(response);
                });
        },
        friendRequestDelete({state, commit}, requestId) {
            axios.delete(`/api/user/${state.user.id}/friend-request/${requestId}`)
                .then((response) => {
                    commit('modalHide', {name: 'areYouSure'})
                    commit('friendRequestDeleteSuccess', {requestId})
                }, (error) => {
                    console.log(response);
                });
        },
        /** Modals */
    },
    mutations: {
        userGetSuccess: (state, {user}) => {
            state.user = user;
        },
        createUsersBookcase: (state, {shelves}) => {
            state.bookcase = new Bookcase(shelves);
        },
        userUpdateError: (state, {errors}) => {
            /** add form errors */
            state.formErrors = errors
        },
        pageIsLoading: (state) => {
            state.pageLoading = true;
        },
        pageStopLoading: (state) => {
            state.pageLoading = false;
        },
        toggleIsSearching: (state) => {
            state.searchResults = null;
        },
        clearSearchResults: (state) => {
            state.searchResults = null;
        },
        clearBook: (state) => {
            state.book = null;
        },
        hideSearchOptions: (state) => {
            state.showSearchOptions = false;
        },
        showSearchOptions: (state) => {
            state.showSearchOptions = true;
        },
        searchAsyncFindSuccess: (state, {searchResults}) => {
            /** add search results to store */
            state.searchAsyncResults = searchResults;
            state.isLoadingOptions = false;
            if (state.searchAsyncResults) {
                state.showSearchOptions = true;
            }
        },
        searchSuccess: (state, {searchResults, query}) => {
            /** add search results to store */
            state.searchResults = searchResults;
            state.searchQuery = query;
            /** take user to search page */
            Event.$emit('changePage', '/search/');
            state.isSearching = false
            setTimeout(function () {
                state.pageLoading = false
            }, 2000);
        },
        bookGetSuccess: (state, {book}) => {
            state.book = book;
        },
        newYorkTimeGetBestSellersSuccess: (state, {bestSellers}) => {
            state.bestSellers = bestSellers
            state.pageLoading = false
        },
        shelfAddSuccess: (state, {shelf}) => {
            state.bookcase.addShelf(shelf)
        },
        shelfAddError: (state, {errors}) => {
            /** add form errors */
            state.formErrors = errors
        },
        shelfGetSuccess: (state, {shelf}) => {
            state.shelf = new Shelf(shelf)
        },
        shelfGetsBookSuccess: (state, {books}) => {
            state.shelf.books = books
        },
        shelfDeleteSuccess: (state, {id}) => {
            state.bookcase.removeShelf(id);
            Event.$emit('changePage', '/home/');
        },
        shelfAddBookSuccess: (state, {shelf}) => {
            state.bookcase.getShelf(shelf.id).addBookCount()
        },
        shelfRemoveBookSuccess: (state, {isbn}) => {
            state.shelf.removeBook(isbn)
            state.bookcase.getShelf(state.shelf.id).subtractBookCount()
        },
        shelfMoveSuccess: (state, {book}) => {
            state.shelf.removeBook(book.isbn);
            state.bookcase.getShelf(book.shelf_id).addBookCount()
            state.bookcase.getShelf(state.shelf.id).subtractBookCount()
        },
        /***********************
         * Friends
         **********************/
        friendsSearchAsyncSuccess: (state, {users}) => {
            state.friendsSearchAsyncResults = users;
            state.showFriendsSearchOptions = true;
        },
        friendsAddSuccess: (state, {users}) => {
            // state.friendsSearchAsyncResults = users;
            // state.showFriendsSearchOptions = true;
        },
        friendsGetSuccess: (state, {pending, sent, active}) => {
            state.friends.pending = pending;
            state.friends.sent = sent;
            state.friends.active = active;
        },
        friendAcceptSuccess: (state, {friend}) => {
            state.friends.active.push(friend)
            state.friends.pending = _.reject(state.friends.pending, ['user_id', friend.id])
        },
        friendRequestDeleteSuccess: (state, {requestId}) => {
            state.friends.sent = _.reject(state.friends.sent, ['id', requestId])
        },

        /***********************
         * Modal Mutations
         **********************/
        modalAdd: (state, {name}) => {
            state.modals.push(new Modal(name));
        },
        modalShow: (state, {name}) => {
            state.formErrors = {};
            state.modals.find(modal => modal.name === name).show();
        },
        modalShowWithPayload: (state, {name, payload}) => {
            state.formErrors = {};
            let modal = state.modals.find(modal => modal.name === name)
            modal.data = payload
            modal.show()
        },
        modalHide: (state, {name}) => {
            state.formErrors = {};
            state.modals.find(modal => modal.name === name).hide();
        },
        modalLoading: (state, {name}) => {
            state.modals.find(modal => modal.name === name).loading();
        },
        modalLoaded: (state, {name}) => {
            state.modals.find(modal => modal.name === name).loaded();
        },
    },
    getters: {
        getPageLoading: (state) => {
            return state.pageLoading;
        },
        getUser: (state) => {
            if (!state.user) {
                return false;
            }
            return state.user;
        },
        getBook: (state) => {
            if (!state.book) {
                return false;
            }
            return state.book;
        },
        getShelf: (state) => {
            if (!state.shelf) {
                return false;
            }
            return state.shelf;
        },
        getShelves: (state) => {
            if (!state.bookcase) {
                return false;
            }
            return state.bookcase.shelves;
        },
        getSearchAsyncResults: (state) => {
            return state.searchAsyncResults;
        },
        getIsLoadingOptions: (state) => {
            return state.isLoadingOptions;
        },
        getLastAsyncSearchTime: (state) => {
            return state.lastAsyncSearchTime;
        },
        showSearchOptions: (state) => {
            return state.showSearchOptions;
        },
        getBestSellerLists: (state) => {
            if (!state.bestSellers) {
                return null;
            }
            return state.bestSellers;
        },
        getFriendsSearchAsyncResults: (state) => {
            if (!state.friendsSearchAsyncResults) {
                return null;
            }
            return state.friendsSearchAsyncResults;
        },
        getFriends: (state) => {
            if (!state.friends) {
                return null;
            }
            return state.friends;
        },
        showFriendsSearchOptions: (state) => {
            return state.showFriendsSearchOptions;
        },
        /**
         * modals
         * */
        /** returns isVisible and isLoading states for modal my name **/
        getModalByName: (state, getters) => (name) => {
            return state.modals.find(modal => modal.name === name)
        },
        /** gets form errors by field name**/
        getFormErrors: (state, getters) => (fieldName) => {
            if (state.formErrors[fieldName]) {
                return state.formErrors[fieldName][0];
            }
        }
    }
});

export default store;