import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import "./frontend.scss";

domReady( () => {
    const divsToUpdate = document.querySelectorAll(".lqb-update-me")
    divsToUpdate.forEach(function(div) {
        const data = JSON.parse(div.querySelector("pre").innerHTML)
        const root = createRoot(div)
        div.classList.remove("lqb-update-me");
        root.render( <LeQuiz {...data} /> );
    })
})

function LeQuiz(props) {
    function handleAnswer(index) {
        if(index === props.correctAnswer) {
            alert("Correct!")
        } else {
            alert("false:(")
        }
    }

    return (
        <div className="le-quiz-block-frontend">
           <p> {props.question}</p>
           <ul>
            {props.answers.map((answer, index)=> {
                return <li key={`${props.question}-answer-${answer}-${index}`} onClick={() => handleAnswer(index)}>{answer}</li>
            })}
           </ul>
        </div>
    )
}