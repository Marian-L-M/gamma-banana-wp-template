import { createRoot } from '@wordpress/element';
import "./frontend.scss";

document.addEventListener("DOMContentLoaded", function(){
    const divsToUpdate = document.querySelectorAll(".lfb-update-me")
    divsToUpdate.forEach(function(div) {
        const data = JSON.parse(div.querySelector("pre").innerHTML)
        const root = createRoot(div)
        root.render( <LeFeatured {...data} /> );
    })
})

function LeFeatured(props) {
    return (
        <div className="le-featured-block-frontend" style={{backgroundColor: props.bgColor}}>
            <h1>Wasabi Kimosabi</h1>
        </div>
   
    )
}