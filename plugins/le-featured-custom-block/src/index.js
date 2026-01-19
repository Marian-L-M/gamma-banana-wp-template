import "./index.scss"
import { useBlockProps} from "@wordpress/block-editor"
import { useSelect } from "@wordpress/data"

wp.blocks.registerBlockType("theme-custom-blocks/le-featured-block", {
    title: "le featured block",
    icon: "networking",
    category: "common",
    attributes: {
        featuredId: {
            type: "string",
        },
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
    const allowedPostTypes = ['roadmap', 'projects', 'features', 'posts', 'guides', "wikis", "notes"];
    
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
    
    const blockProps = useBlockProps({
        className: "lfb-edit-block", 
        style:{backgroundColor: props.attributes.bgColor}
    })

    console.log(allPostsForFeature)

    return (
    <div {...blockProps}>
        <div className="featured-block-wrapper">
        <div className="featured-select-container">
            <select id="select-featured" onChange={(e) => props.setAttributes({featuredId : e.target.value})}>
                <option value="">Select a Post</option>
                <option value="1" selected={props.attributes.featuredId == 1}>1</option>
                <option value="2" selected={props.attributes.featuredId == 2}>2</option>
                <option value="3" selected={props.attributes.featuredId == 3}>3</option>
                <option value="4" selected={props.attributes.featuredId == 4}>4</option>
            </select>
        </div>
        <h1>Ello Povna</h1>
        </div>
    </div>
    )
}