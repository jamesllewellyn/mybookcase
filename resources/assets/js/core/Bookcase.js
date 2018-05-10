import Shelf from './Shelf'

class Bookcase{
    constructor(shelves){
        this.shelves = shelves.map(shelf =>{
            return new Shelf(shelf)
        })
    }

    addShelf(shelf){
        return this.shelves.push(new Shelf(shelf))
    }

    removeShelf(id){
        this.shelves = _.reject(this.shelves, ['id',id]);
    }

    getShelf(id){
        return this.shelves.find(shelf => shelf.id === id)
    }
}
export default Bookcase;