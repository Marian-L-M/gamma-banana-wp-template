// /**
//  * Initialize Notes
//  */
class Notes {
    // Initiate object
    constructor() {
        this.deleteBtns = document.querySelectorAll(".btn__delete")
        this.editBtns = document.querySelectorAll(".btn__edit")
        this.saveBtns = document.querySelectorAll(".btn__save")
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
        this.saveBtns.forEach((btn) => {
            btn.addEventListener("click", this.updateHandler.bind(this))
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

    editHandler(e) {
        const currentItem = e.target.closest('li')
        if (currentItem.dataset.state == "editable") {
            this.deactivateItemForEdit(currentItem)
            currentItem.setAttribute("data-state", "")
            e.target.innerHTML = "Edit"
        } else {
            this.activateItemForEdit(currentItem)
            currentItem.setAttribute("data-state", "editable")
            e.target.innerHTML = "Cancel"
        }
    }
    updateHandler(e) {
        this.updateItem(e)
    }

    activateItemForEdit(item) {
        item.classList.add("active")
        const inputs = item.querySelectorAll('.title-notes, .content-notes')
        inputs.forEach(input => {
            input.removeAttribute("readonly");
            input.classList.add("active");
        });
    }
    deactivateItemForEdit(item) {
        item.classList.remove("active")
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

    async updateItem(e) {
        const item = e.target.closest('li');
        const data = {
            "title": item.querySelector(".title-notes").value,
            "content": item.querySelector(".content-notes").value
        };
        try {
            const response = await fetch(`${gbThemeData.root_url}/wp-json/wp/v2/notes/${item.dataset.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': gbThemeData.nonce
                },
                body: JSON.stringify(data)
            });
            if (response.ok) {
                console.log(`Item ${item.dataset.title} updated successfully.`);
                this.deactivateItemForEdit(item)
            } else {
                console.error(`Failed to update item. Status: ${response.status}`);
                const errorData = await response.json();
                console.error('Error details:', errorData);
            }
        } catch (error) {
            console.error('Network error during delete operation:', error);
        }
    }
}

export default Notes;