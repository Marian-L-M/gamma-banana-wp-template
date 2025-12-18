// /**
//  * Initialize Notes
//  */
class Notes {
    // Initiate object
    constructor() {
        this.deleteBtns = document.querySelectorAll(".btn__delete")
        this.editBtns = document.querySelectorAll(".btn__edit")
        this.cancelBtns = document.querySelectorAll(".btn__cancel")
        this.body = this.events()

    }
    // Events
    events() {
        this.deleteBtns.forEach((btn) => {
            btn.addEventListener("click", this.deleteHandler.bind(this))
        })
        this.editBtns.forEach((btn) => {
            btn.addEventListener("click", this.editHandler.bind(this))
        })
        this.cancelBtns.forEach((btn) => {
            btn.addEventListener("click", this.cancelHandler.bind(this))
        })
    }

    // Methods
    deleteHandler(e) {
        const currentItem = e.target.closest('li')
        if (confirm(`Are you sure you want to delete ${currentItem.dataset.title}?`)) {
            this.deleteItem(currentItem)
        } else {
            console.log("Deletion aborted");
            return;
        }

    }
    cancelHandler(e) {
        const currentItem = e.target.closest('li')
        this.deactivateItemForEdit(currentItem)
        // this.deleteItem(currentItem)
    }
    editHandler(e) {
        const currentItem = e.target.closest('li')
        this.activateItemForEdit(currentItem)
        // this.deleteItem(currentItem)
    }

    activateItemForEdit(item) {
        const inputs = item.querySelectorAll('.title-notes, .content-notes')
        inputs.forEach(input => {
            input.removeAttribute("readonly");
            input.classList.add("active");
        });
    }
    deactivateItemForEdit(item) {
        const inputs = item.querySelectorAll('.title-notes, .content-notes')
        inputs.forEach(input => {
            input.setAttribute("readonly", "");
            input.classList.remove("active");
        });
    }

    async deleteItem(item) {
        try {
            const response = await fetch(`${gbThemeData.root_url}/wp-json/wp/v2/notes/${item.dataset.id}`, {
                method: 'DELETE',
                headers: {
                    'X-WP-Nonce': gbThemeData.nonce
                },
            });
            if (response.ok) {
                console.log(`.Item ${item.dataset.title} deleted successfully.`);
                item.remove()
            } else {
                console.error(`Failed to delete item. Status: ${response.status}`);
                const errorData = await response.json();
                console.error('Error details:', errorData);
            }
        } catch (error) {
            console.error('Network error during delete operation:', error);
        }
    }
    async editItem(item) {
        try {
            const response = await fetch(`${gbThemeData.root_url}/wp-json/wp/v2/notes/${item.dataset.id}`, {
                method: 'POST',
                headers: {
                    'X-WP-Nonce': gbThemeData.nonce
                },
            });
            if (response.ok) {
                console.log(`Item ${item.dataset.title} deleted successfully.`);
                item.remove()
            } else {
                console.error(`Failed to delete item. Status: ${response.status}`);
                const errorData = await response.json();
                console.error('Error details:', errorData);
            }
        } catch (error) {
            console.error('Network error during delete operation:', error);
        }
    }
}

export default Notes;