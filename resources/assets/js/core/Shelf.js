import store from '../store';

class Shelf {
    constructor(shelf) {
        this.id = shelf.id
        this.description = shelf.description
        this.name = shelf.name
        this.books_count = shelf.books_count
        this.public = shelf.public
        this.books = []
    }

    addBooks(books){
        this.books = books;
    }

    addBookCount(){
        return this.books_count ++
    }

    subtractBookCount(){
        return this.books_count --
    }

    removeBook(isbn){
        console.log(isbn)
        console.log(this.books)
        this.books = _.reject(this.books, ['isbn',isbn])
        console.log(this.books)
        this.books_count --
    }

    update(shelf){
        this.description = shelf.description
        this.name = shelf.name
    }

    destroy(){
        console.log('shelfDelete')
        store.dispatch('shelfDelete', this.id);
    }
}

export default Shelf;