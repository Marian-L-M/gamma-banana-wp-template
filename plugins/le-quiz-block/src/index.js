import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, ColorPicker} from "@wordpress/components"
import {InspectorControls, BlockControls, AlignmentToolbar, useBlockProps} from "@wordpress/block-editor"
import { HexColorPicker } from "react-colorful";
import { useEffect, useState } from "react";

(function(){
    let locked = false;
    
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
        },
        bgColor: {
            type: "string",
            default:"#ebebeb"
        },
        theAlignment: {
            type: "string",
            default:"left"
        }
    },
    description:`Ask the questions to which you need answers`,
    example:{
        attributes: {
            question: "Le Why, le what, le who?",
            correctAnswer: 3,
            answers: ["Lazer", "Blazer", "Chazer"],
            theAlignment: "center",
            bgColor: "#CFE8F1"
        },
    },
    edit: EditComponent,
    save: function (props) {
        return null
    }
})

function EditComponent (props) {
    const blockProps = useBlockProps({
        className: "lqb-edit-block", 
        style:{backgroundColor: props.attributes.bgColor}
    })
    const [color, setColor] = useState(props.attributes.bgColor);

    useEffect(()=>{
        props.setAttributes({bgColor: color})
    },[color])

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
    <div {...blockProps}>
        <BlockControls>
            <AlignmentToolbar value={props.attributes.theAlignment} onChange={x => props.setAttributes({theAlignment: x})} />
        </BlockControls>
        <InspectorControls>
            <PanelBody title="Background Color" initialOpen={true}>
                <PanelRow>
                    <HexColorPicker color={color} onChange={setColor} />
                </PanelRow>
            </PanelBody>
        </InspectorControls>
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
        <Button variant="primary" onClick={()=>{
            props.setAttributes({answers: props.attributes.answers.concat([undefined])})
        }}>Add another answer</Button>
    </div>
    )
}