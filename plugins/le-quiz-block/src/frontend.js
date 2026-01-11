import React from "react";
import { createRoot } from 'react-dom/client';
import "./frontend.scss";

const divsToUpdate = document.querySelectorAll(".lqb-update-me")

divsToUpdate.forEach(function(div) {
  createRoot(div).render(<LeQuiz />)
  div.classList.remove("paying-attention-update-me");
})

function LeQuiz() {
    return (
        <div className="le-quiz-block-frontend">
            Ello React
        </div>
    )
}