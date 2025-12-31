// /**
//  * Initialize Notes
//  */
class Notes {
    // Initiate object
    constructor() {
        this.deleteBtns = document.querySelectorAll(".btn__delete")
        this.editBtns = document.querySelectorAll(".btn__edit")
        this.saveBtns = document.querySelectorAll(".btn__save")
        this.submitBtn = document.querySelector(".btn__submit")
        this.contents = document.querySelector("#user-notes")
        this.errorMessage = document.querySelector("#user-notes")
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
        this.submitBtn.addEventListener("click", this.submitHandler.bind(this))
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
    submitHandler(e) {
        this.submitItem(e)
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
            console.error('Network error during update operation:', error);
        }
    }
    async submitItem(e) {
        const item = e.target.closest('#new-note');
        const titleField = item.querySelector(".title-notes");
        const contentField = item.querySelector(".content-notes");
        const data = {
            "title": titleField.value,
            "content": contentField.value,
            "status": 'private',
        };
        try {
            // To do
            // Maybe rework to axios?
            // Check tradeoffs
            const response = await fetch(`${gbThemeData.root_url}/wp-json/wp/v2/notes`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': gbThemeData.nonce
                },
                body: JSON.stringify(data)
            });
            if (response.ok) {
                const createdNote = await response.json();
                const createdNoteHTML = `
                  <li class="fx-col gap-r1" data-id="${createdNote.id}" data-title="${createdNote.slug}">
                        <div class=" fx-row-between w100">
                            <input readonly value="${createdNote.slug}" id="title-notes-${createdNote.slug}"
                                class="title-notes">
                        </div>
                        <textarea readonly id="content-notes-${createdNote.id}"
                            class="content-notes">${createdNote.content.raw}</textarea>
                        <button class="btn btn__save">Save</button>
                    </li>
                `
                titleField.value = "";
                contentField.value = "";
                this.contents.insertAdjacentHTML('afterbegin', createdNoteHTML);
                console.log(response)
            }
            else {
                const errorData = await response.json();
                this.errorMessage.innerHTML = "Error: " + errorData.message;
                this.errorMessage.classList.remove("hidden")
            }
        } catch (error) {
            console.error('Network error during creation:', error);
        }
    }
}

export default Notes;