import axios from "axios"
// /**
//  * Initialize Likes
//  */

class Likes {
    // Initiate object
    constructor() {
        this.likeBtn = document.querySelector("#btn-like")
        this.body = this.events()
    }

    // Events
    events() {
        this.likeBtn.addEventListener("click", this.clickDispatcher.bind(this))
    }

    // Methods
    clickDispatcher(e) {
        const clickBox = e.currentTarget;
        if (clickBox.dataset.status === 'active') {
            this.deleteLike(clickBox)
        }
        else if (clickBox.dataset.status === 'inactive') {
            this.createLike(clickBox)
        }
    }

    async createLike(clickBox) {
        const data = {
            "likedPostId": clickBox.dataset.id,
        };
        try {
            const response = await axios.post(
                gbThemeData.root_url + "/wp-json/all/v1/manageLikes",
                data,
                {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': gbThemeData.nonce
                    }
                }
            );
            const results = response.data;
            clickBox.setAttribute("data-status", "active");
            clickBox.setAttribute("data-likesid", results);
            const counter = document.querySelector("#like-count");
            counter.innerHTML = parseInt(counter.innerHTML) + 1;
        } catch (error) {
            console.error('Error during like creation:', error);
            if (error.response) {
                console.error('Error response:', error.response.data);
            }
        }

    }
    async deleteLike(clickBox) {
        const data = {
            "likesId": clickBox.dataset.likesid,
        };
        try {
            const response = await axios.delete(
                gbThemeData.root_url + "/wp-json/all/v1/manageLikes",
                {
                    data: data,
                    headers: {
                        'X-WP-Nonce': gbThemeData.nonce
                    }
                }
            )
            const results = response.data;
            console.log(results)
            clickBox.setAttribute("data-status", "inactive");
            clickBox.removeAttribute("data-likesid");
            const counter = document.querySelector("#like-count");
            counter.innerHTML = parseInt(counter.innerHTML) - 1;
        } catch (error) {
            console.error('Error during like creation:', error);
            if (error.response) {
                console.error('Error response:', error.response.data);
            }
        }
    }
}

export default Likes;