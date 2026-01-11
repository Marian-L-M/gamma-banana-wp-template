import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components"

(function(){
    let locked = false;
    
    // subscribe function is called anytime anything changes in tne blocks
    wp.data.subscribe(function() {
        const results = wp.data.select("core/block-editor").getBlocks().filter(function(block) {
                    return block.name == "theme-custom-blocks/le-quiz-block" && block.attributes.correctAnswer == undefined;
        });

        if(results.length && locked == false) {
            locked = true;
            wp.data.dispatch("core/editor").lockPostSaving("noanswer");
        }

    if(!results.length && locked) {
            locked = false;
            wp.data.dispatch("core/editor").unlockPostSaving("noanswer");
        }
    })
})()

wp.blocks.registerBlockType("theme-custom-blocks/le-quiz-block", {
    title: "le quiz block",
    icon: "smiley",
    category: "common",
    attributes: {
        question: {
            type: "string",
        },
        answers:{
            type:"array",
            default: [""],
        },
        correctAnswer: {
            type:"number",
            default:undefined
        }
    },
    edit: EditComponent,
    save: function (props) {
        return null
    }
})

function EditComponent (props) {
    function updateQuestion(value) {
        props.setAttributes({question: value})
    }

    function deleteAnswer(indexToDelete) {
        const newAnswers = props.attributes.answers.filter((answer, index)=> {
            return index != indexToDelete;
        });
        props.setAttributes({answers: newAnswers})

        if(indexToDelete == props.attributes.correctAnswer) {
            props.setAttributes({correctAnswer: undefined})
        }
    }

    function markAsCorrect(index) {
       
        props.setAttributes({correctAnswer: index})
    }

    return (
    <div className="lqb-edit-block">
        <TextControl label={"Question: "} value={props.attributes.question} onChange={updateQuestion} __next40pxDefaultSize={true} __nextHasNoMarginBottom={true} style={{fontSize: "24px"}}/>
        <p style={{fontSize: "13px", margin: "20px 0 8px 0" }}>Answers</p>
        <div className="answer-container">
            {props.attributes.answers.map((answer, index) => {
            return (
                <Flex>
                    <FlexBlock>
                        <TextControl value={answer} onChange={newValue => {
                            const newAnswers = props.attributes.answers.concat([]);
                            newAnswers[index] = newValue;
                            props.setAttributes({answers: newAnswers})}
                            }  __next40pxDefaultSize={true} __nextHasNoMarginBottom={true}  autoFocus={answer == undefined} />
                    </FlexBlock>
                    <FlexItem>
                        <Button onClick={() => markAsCorrect(index)} className="lqb-select"><Icon className="mark-correct" icon={props.attributes.correctAnswer == index  ? "star-filled" :"star-empty"}/></Button>
                    </FlexItem>
                    <FlexItem>
                        <Button isLink className="lqb-delete" onClick={()=> deleteAnswer(index)}>Delete</Button>
                    </FlexItem>
                </Flex>
            )
            })}
        </div>
        <Button isPrimary onClick={()=>{
            props.setAttributes({answers: props.attributes.answers.concat([undefined])})
        }}>Add another answer</Button>
    </div>
    )
}