import Likes from "./modules/Likes";
import Notes from "./modules/Notes";
import Search from "./modules/Search";

document.addEventListener("DOMContentLoaded", () => {
    const search = new Search();

    if (document.body.classList.contains("page-id-94")) {
        const note = new Notes();
    }
    if (
        document.body.classList.contains("single-projects")) {
        const like = new Likes();
    }
});