;(function(){
    /*
        "Life is not a problem to be solved, but a reality to be experienced."
        ~ Soren Kierkegaard
    */
    function getHoveredElementType(){
        var tag = document.activeElement.querySelector(':hover') || document.activeElement;
        return tag.tagName.toLowerCase();
    }

    document.addEventListener("contextmenu",function(e){
        var tag = getHoveredElementType();
        console.log(tag);
        if(tag == "img" || tag == "article" || tag == "main" ){
            e.preventDefault();
        }
    },false);
})();
