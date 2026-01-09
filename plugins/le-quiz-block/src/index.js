import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components"

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
            default: ["red", "blue"],
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
                        <Button className="lqb-select"><Icon className="mark-correct" icon="star-empty"/></Button>
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