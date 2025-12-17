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
            btn.addEventListener("click", this.deleteHandler.bind(this))
        })
    }

    // Methods
    deleteHandler(e) {
        const clickedElement = e.target
        const currentItem = clickedElement.closest('li')
        alert(`Are you sure you want to delete ${currentItem.dataset.title}?`)
        this.deleteItem(currentItem)
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