import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import "./frontend.scss";
import { useState, useEffect } from 'react';

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
    const [isCorrect, setIsCorrect] = useState(undefined)
    const [isCorrectDelay, setIsCorrectDelay] = useState(undefined)

    useEffect(() => {
        if(isCorrect === false) {
            setTimeout(()=>{setIsCorrect(undefined)},2600)
        }
        if(isCorrect === true) {
            setTimeout(()=>{
            setIsCorrectDelay(true);
            },1000)
        }
    }, [isCorrect])

    function handleAnswer(index) {
        if(index === props.correctAnswer) {
            setIsCorrect(true);
        } else {
            setIsCorrect(false);
        }
    }

    return (
        <div className="le-quiz-block-frontend" style={{backgroundColor: props.bgColor, textAlign: props.theAlignment}}>
           <p> {props.question}</p>
           <ul>
            {props.answers.map((answer, index)=> {
                return (
                    <li 
                        key={`${props.question}-answer-${answer}-${index}`} 
                        onClick={isCorrect === true ? undefined : () => handleAnswer(index)}
                        className={
                                (isCorrectDelay === true && index == props.correctAnswer ? "no-click": "") + 
                                (isCorrectDelay === true && index != props.correctAnswer ? "fade-incorrect": "")
                                } 
                        >
                        {isCorrectDelay === true && index == props.correctAnswer && (
                            "✅　"
                        )}
                        {isCorrectDelay === true && index != props.correctAnswer && (
                            "❌　"
                        )}
                        {answer}
                    </li>)
            })}
           </ul>
           <div className={`correct-message ${isCorrect == true ? "correct-message--visible" : ""}` }>
            <p>Le correct!</p>
           </div>
           <div className={`incorrect-message ${isCorrect === false ? "incorrect-message--visible" : ""}`}>
            <p>Sowwwy! Try again!</p>
           </div>
        </div>
    )
}