/**
 * Initializes a search from
 */
class Search {
    // Initiate object
    constructor() {
        this.initializeSearchOverlay()
        this.resultsContainer = document.querySelector("#search-overlay-results")
        this.openButtons = document.querySelectorAll(".toggle-search-overlay")
        this.closeButton = document.querySelector("#close-search-overlay")
        this.searchOverlay = document.querySelector("#search-overlay")
        this.searchField = document.querySelector("#search-term")
        this.body =
            this.events();
        this.isOverlayOpen = false;
        this.isLoading = false;
        this.previousValue;
        this.typingTimer;
        this.postTypes = null;
        this.fetchPostTypes();
    }

    // Events
    events() {
        this.openButtons.forEach(openButton => { openButton.addEventListener("click", this.openOverlay.bind(this)) });
        this.closeButton.addEventListener("click", this.closeOverlay.bind(this))
        document.addEventListener('keydown', this.keyPressDispatcher.bind(this))
        this.searchField.addEventListener("keyup", this.typingLogic.bind(this))
    }

    // Methods
    // Initialize Custom Post Types
    // Note: Search endpoint as alternative possible to get all CPTs, but returns less data.
    async fetchPostTypes() {
        try {
            const response = await fetch('/wp-json/wp/v2/types');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const types = await response.json();

            // Add post type to exclude from fetch logic
            const excludedTypes = [
                'attachment',
                'wp_block',
                'wp_template',
                'wp_template_part',
                'wp_navigation',
                'nav_menu_item',
                'wp_global_styles',
                'wp_font_family',
                'wp_font_face'
            ];
            this.postTypes = Object.values(types)
                .filter(type => !excludedTypes.includes(type.slug))
                .map(type => type.rest_base);

        } catch (error) {
            console.error('Error fetching post types:', error);
            this.postTypes = ['posts', 'pages']; // fallback if type initialization fails
        }
    }

    async getResults() {
        const keyword = this.searchField.value;

        if (!this.postTypes) {
            await this.fetchPostTypes();
        }

        try {
            const fetchPromises = this.postTypes.map(restBase =>
                fetch(`/wp-json/wp/v2/${restBase}/?search=${keyword}`)
            );

            const responses = await Promise.all(fetchPromises);

            const failedResponses = responses.filter(r => !r.ok);
            if (failedResponses.length > 0) {
                console.warn('Some post type queries failed:', failedResponses);
            }
            const results = await Promise.all(
                responses.map(r => r.ok ? r.json() : Promise.resolve([]))
            );

            const searchResults = results.flat();

            if (searchResults.length === 0) {
                this.resultsContainer.innerHTML = '<p>No results found</p>';
                this.isLoading = false;
                return;
            }

            let contents = "";
            console.log(searchResults)
            searchResults.forEach(item => {
                contents += `
                <div class="result-item">
                    <div class="fx-row gap-1">
                        <a href="${item["link"]}"><h4>▶︎ ${item["title"]["rendered"]}</h4></a>
                        <span class="${item["type"]}-label">${item["type"]}</span>
                    </div>
                </div>
                `;
            });
            this.resultsContainer.innerHTML = contents;

        } catch (error) {
            console.error('Error fetching JSON:', error);
        }

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