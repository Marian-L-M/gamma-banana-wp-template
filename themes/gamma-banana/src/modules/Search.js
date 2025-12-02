class Search {
    // Initiate object
    constructor() {
        this.openButton = document.querySelector("#toggle-search-overlay")
        this.closeButton = document.querySelector("#close-search-overlay")
        this.searchOverlay = document.querySelector("#search-overlay")
        this.searchField = document.querySelector("#search-term")
        this.events();
        this.isOverlayOpen = false;
        this.typingTimer;
    }
    
    // Events
    events() {
        this.openButton.addEventListener("click", this.openOverlay.bind(this))
        this.closeButton.addEventListener("click", this.closeOverlay.bind(this))
        document.addEventListener('keydown', this.keyPressDispatcher.bind(this))
        this.searchField.addEventListener("keydown", this.typingLogic.bind(this))
    }

    // Methods
    keyPressDispatcher(e) {
        if (e.key === "s" && !this.isOverlayOpen) {
            this.openOverlay()
            this.isOverlayOpen = true
        }
        
        if (e.key === "Escape" && this.isOverlayOpen) {
            this.closeOverlay()
            this.isOverlayOpen = false
        }
    }
    typingLogic(){
        clearTimeout(this.typingTimer)
        this.typingTimer = setTimeout(() => {
            console.log("timeout test")
        }, 2000)
    }
    openOverlay(){
        this.searchOverlay.classList.add("search-overlay__active")
        this.isOverlayOpen = true
    }
    closeOverlay(){
        this.searchOverlay.classList.remove("search-overlay__active")
        this.isOverlayOpen = false
    }
}

export default Search;