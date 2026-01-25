import "./index.scss"
import { useBlockProps} from "@wordpress/block-editor"
import { useSelect } from "@wordpress/data"
import { useState, useEffect } from "react";
import apiFetch from '@wordpress/api-fetch'
const __ = wp.i18n.__ // use instead of '@wordpress/i18n' for compatibility issues with loco translate

wp.blocks.registerBlockType("theme-custom-blocks/le-featured-block", {
    title: "le featured block",
    icon: "networking",
    category: "common",
    attributes: {
        featuredId: {type: "number"},
        bgColor: {
            type: "string",
            default:"#ebebeb"
        },
    },
    description:`This is a new custom block`,
    example:{
        attributes: {
            bgColor: "#CFE8F1"
        },
    },
    edit: EditComponent,
    save: function (props) {
        return null
    }
})

function EditComponent (props) {
    const [thePreview, setThePreview] = useState("");

    useEffect(() => {
     if(props.attributes.featuredId){
        updateTheMeta();
        async function go() {
            const response = await apiFetch({
                path: `/featuredPost/v1/getHTML?postId=${props.attributes.featuredId}`,
                method: "GET"
            })
            setThePreview(response)
        }
        go()
        };
    },[props.attributes.featuredId])
        
    useEffect(() => {
        return () => {
            updateTheMeta()
        }
    },[])

    function updateTheMeta() {
        const featuredPostsForMeta = wp.data.select("core/block-editor")
            .getBlocks()
            .filter(x => x.name == "theme-custom-blocks/le-featured-block")
            .map(x => x.attributes.featuredId)
            .filter(id => id && !isNaN(id))
            .filter((x, index, arr) => {
                return arr.indexOf(x) == index
            })
        wp.data.dispatch("core/editor").editPost({meta: {
            featuredpostmeta: featuredPostsForMeta
        }});
    }

    const blockProps = useBlockProps({
        className: "lfb-edit-block", 
        style:{backgroundColor: props.attributes.bgColor}
    })

    const allowedPostTypes = ['roadmap', 'projects', 'features', 'post', 'guides', "wikis", "notes"];
    
    const allPostsForFeature = useSelect(select => {
        const allPosts = [];
        
        allowedPostTypes.forEach(postType => {
            const posts = select("core").getEntityRecords("postType", postType, {
                per_page: -1
            });
            
            if (posts) {
                allPosts.push(...posts);
            }
        });
        
        return allPosts;
    }, [allowedPostTypes]);

    if(!allPostsForFeature) {
        return <p>Loading...</p>
    }

    return (
        <div {...blockProps}>
            <div className="featured-block-wrapper">
                <div className="featured-select-container">
                    <select
                        value={props.attributes.featuredId || ""}
                        onChange={(e) => {props.setAttributes({featuredId : parseInt(e.target.value)});}}
                    >
                        <option value="">{__("Select a Post", "le-featured-custom-block")}</option>
                        {allPostsForFeature.map(featuredPost => {
                        return (
                            <option
                                key={featuredPost.id}
                                value={featuredPost.id}
                            >
                                {featuredPost.title.rendered || featuredPost.title}
                            </option>
                            )
                        })}
                    </select>
                </div>
                <div dangerouslySetInnerHTML={{__html: thePreview}}></div>
            </div>
        </div>
    )
}