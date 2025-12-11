// /**
//  * Initializes a search from
//  */
class Search {
    // Initiate object
    constructor() {
        this.initializeSearchOverlay();
        this.postTypes = null;
        this.fetchPostTypes();
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

    async fetchPostTypes() {
        try {
            const response = await fetch('/wp-json/wp/v2/types');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const types = await response.json();
            this.postTypes = Object.values(types).map(type => type.rest_base);

        } catch (error) {
            console.error('Error fetching post types:', error);
            this.postTypes = ['posts', 'pages']; // fallback if type initialization fails
        }
    }

    // Methods
    async getResults() {
        const keyword = this.searchField.value;
        const arrayKeys = this.postTypes;
        let resultsCount = 0
        const data = await fetch(`/wp-json/all/v1/search/?keyword=${keyword}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(searchResults => {
                arrayKeys.forEach(
                    key => {
                        if (searchResults[key]) {
                            resultsCount += searchResults[key].length;
                        }
                    }
                )
                if (resultsCount === 0) {
                    this.resultsContainer.innerHTML = '<p class="alert">No results found</p>';
                    this.isLoading = false;
                    return;
                } else {
                    let contents = "";
                    arrayKeys.forEach(key => {
                        if (searchResults[key]?.length > 0) {
                            // Open Group
                            contents += `
                                <div class="results-group fx-col gap-1">
                                    <h3>${[key]}</h3>
                            `;

                            // Group Content
                            searchResults[key]?.forEach(item => {
                                contents += `
                                <div class="result-item">
                                    <a class="${item["post_type"]}-item" href="${item["permalink"]}"><h4>▶︎ ${item["title"]}</h4></a>
                                </div>
                                `;
                            });

                            // Close Group
                            contents += `
                                </div>
                            `;
                        }
                    })
                    this.resultsContainer.innerHTML = contents;
                }

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
                }, 750)
            } else {
                this.resultsContainer.innerHTML = "";
            }
        }
        this.previousValue = this.searchField.value
    }
    openOverlay(e) {
        e.preventDefault()
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