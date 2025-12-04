class Search {
    // Initiate object
    constructor() {
        this.initializeSearchOverlay()
        this.resultsContainer = document.querySelector("#search-overlay-results")
        this.openButton = document.querySelector("#toggle-search-overlay")
        this.closeButton = document.querySelector("#close-search-overlay")
        this.searchOverlay = document.querySelector("#search-overlay")
        this.searchField = document.querySelector("#search-term")
        this.body =
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
    async getResults() {
        const keyword = this.searchField.value;
        const data = await fetch(`/wp-json/wp/v2/search/?search=${keyword}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(searchResults => {
                console.log(searchResults);
                if (searchResults.length === 0) {
                    this.resultsContainer.innerHTML = '<p>No results found</p>';
                    this.isLoading = false;
                    return;
                } else {
                    let contents = "";
                    searchResults.forEach(item => {
                        contents += `
                        <div class="result-item">
                            <div class="fx-row gap-1">
                                <a href="${item["url"]}"><h4>▶︎ ${item["title"]}</h4></a>
                                <span class="${item["subtype"]}-label">${item["subtype"]}</span>
                            </div>
                        </div>
                        `;
                    });
                    this.resultsContainer.innerHTML = contents;
                }

            })
            .catch(error => {
                console.error('Error fetching JSON:', error);
            });
        this.isLoading = false;
        console.log(data)
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
                }, 750)
            } else {
                this.resultsContainer.innerHTML = "";
            }
        }
        this.previousValue = this.searchField.value
    }
    openOverlay() {
        this.searchOverlay.classList.add("search-overlay__active")
        this.searchField.focus()
        this.isOverlayOpen = true
    }
    closeOverlay() {
        this.searchOverlay.classList.remove("search-overlay__active")
        this.isOverlayOpen = false
    }
    initializeSearchOverlay() {
        const searchOverlay = `
            <div id="search-overlay" class="search-overlay" aria-expanded="false">
                <div class="content">
                    <div class="search-overlay__content search-overlay__top">
                        <h2>Search</h2>
                    </div>
                    <div class="search-overlay__content search-overlay__main p-1">
                        <div class="fx-row-center gap-1 w100">
                            <input type="text" class="search-term" id="search-term" placeholder="Search">
                        </div>
                        <div id="search-overlay-results"></div>
                    </div>
                    <div class="search-overlay__content search-overlay__bottom"></div>
                </div>
                <div class="close__wrapper" id="close-search-overlay"><span class="close__button"
                        aria-label="close search search-overlay"></span></div>
            </div>
            `
        document.querySelector("body").innerHTML += searchOverlay
    }
}

export default Search;