// /**
//  * Initialize Notes
//  */
class Notes {
    // Initiate object
    constructor() {
        this.deleteBtns = document.querySelectorAll(".btn__delete")
        this.body = this.events()

    }
    // Events
    events() {
        this.deleteBtns.forEach((btn) => {
            btn.addEventListener("click", this.deleteItem.bind(this))
        })
    }

    // Methods
    deleteItem() {
        alert("are you sure you want to delete XYZ")
    }
}

export default Notes;