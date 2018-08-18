import store from '../store';

class Shelf {
    constructor(shelf) {
        this.id = shelf.id;
        this.description = shelf.description;
        this.name = shelf.name;
        this.public = shelf.public;
        this.books = shelf.books ? shelf.books : [];
        this.books_count = shelf.books_count ? shelf.books_count : 0;
    }

    addBook(book) {
        this.books.push(book);
        return this.books_count++;
    }

    removeBook(isbn) {
        this.books = _.reject(this.books, ['isbn', isbn]);
        return this.books_count--;
    }

    update(shelf) {
        this.description = shelf.description;
        this.public = shelf.public;
        return this.name = shelf.name;
    }

}

export default Shelf;