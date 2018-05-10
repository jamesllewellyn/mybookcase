class Modal{
    constructor(name){
        this.isVisible = false
        this.isLoading = false
        this.data = null
        this.name = name
    }

    show(){
        this.isVisible = true
    }

    hide(){
        this.isVisible = false
        this.loaded()
    }

    loading(){
        this.isLoading = true
    }

    loaded(){
        this.isLoading = false
    }

}
export default Modal;