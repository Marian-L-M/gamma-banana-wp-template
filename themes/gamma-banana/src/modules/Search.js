class Search {
    // Initiate object
    constructor() {
        this.resultsContainer = document.querySelector("#search-overlay-results")
        this.openButton = document.querySelector("#toggle-search-overlay")
        this.closeButton = document.querySelector("#close-search-overlay")
        this.searchOverlay = document.querySelector("#search-overlay")
        this.searchField = document.querySelector("#search-term")
        this.events();
        this.isOverlayOpen = false;
        this.isLoading = false;
        this.previousValue;
        this.typingTimer;
    }

    // Events
    events() {
        this.openButton.addEventListener("click", this.openOverlay.bind(this))
        this.closeButton.addEventListener("click", this.closeOverlay.bind(this))
        document.addEventListener('keydown', this.keyPressDispatcher.bind(this))
        this.searchField.addEventListener("keyup", this.typingLogic.bind(this))
    }

    // Methods
    getResults() {
        const keyword = this.searchField.value;
        const data = fetch(`/wp-json/wp/v2/search/?search=${keyword}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                // alert(data[0].title)
            })
            .catch(error => {
                console.error('Error fetching JSON:', error);
            });
        this.isLoading = false;
    }
    keyPressDispatcher(e) {
        if (e.key === "Escape" && this.isOverlayOpen) {
            this.closeOverlay()
            this.isOverlayOpen = false
        }
    }
    typingLogic() {
        if (this.searchField.value != this.previousValue) {
            clearTimeout(this.typingTimer)
            if (this.searchField.value) {
                if (!this.isLoading) {
                    this.resultsContainer.innerHTML = '<div class="fx-col-center mt-half"><span class="loader"></span></div>';
                    this.isLoading = true;
                }
                // Delay timer to prevent query on every key stroke
                this.typingTimer = setTimeout(() => {
                    this.getResults()
                }, 2000)
            } else {
                this.resultsContainer.innerHTML = "";
            }
        }
        this.previousValue = this.searchField.value
    }
    openOverlay() {
        this.searchOverlay.classList.add("search-overlay__active")
        this.isOverlayOpen = true
    }
    closeOverlay() {
        this.searchOverlay.classList.remove("search-overlay__active")
        this.isOverlayOpen = false
    }
}

export default Search;