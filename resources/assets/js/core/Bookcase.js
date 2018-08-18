import Shelf from './Shelf'

class Bookcase{
    constructor(shelves){
        this.shelves = shelves.map(shelf =>{
            return new Shelf(shelf);
        });
    }

    getShelves(){
        return this.shelves;
    }

    getShelf(id){
        return this.shelves.find(shelf => shelf.id === parseInt(id));
    }

    findBook(isbn){
        return this.shelves.filter((shelf) => {
            return shelf.books.find(book => book.isbn === isbn);
        });
    }

    addShelf(shelf){
        return this.shelves.push(new Shelf(shelf));
    }

    updateShelf(updatedShelf){
        let shelf = this.getShelf(updatedShelf.id);
        if(!shelf){
            return false;
        }
        return shelf.update(updatedShelf);
    }

    removeShelf(id){
        return this.shelves = _.reject(this.shelves, ['id',id]);
    }

}
export default Bookcase;