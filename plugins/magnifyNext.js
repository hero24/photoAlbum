;(function(){
    /*
        "There is nothing permanent except change."
        ~ Heraclitus
    */
    var actve_node = null;
    var photos = null;
    var main = null;
    var body = null;
    var target = null;

    document.addEventListener("DOMContentLoaded",contentLoaded,false);
    function contentLoaded(){
        photos = document.getElementsByClassName("photo_sector");
	main = document.getElementById("main");
	body = document.getElementsByTagName("body")[0];
	active_node = false;
	for(var i=0; i< photos.length;i++){
		photos[i].addEventListener("click",magnify,false);
	}
        var observer = new MutationObserver(next);
        observer.observe(body, {childList: true});
    }

    function magnify(event){
	target = event.target || event.srcElement;
	if (target.tagName.toLowerCase() != "article"){
		target = target.parentNode;
        }
	if(!active_node){
		main.style.display = "none";
		active_node = target.cloneNode(true);
		active_node.id = "magnify";
		active_node.addEventListener("click",demagnify,false);
		body.appendChild(active_node);
	}					
    }

    function demagnify(event){
        main.style.display = "grid";
	body.removeChild(active_node);
	active_node = false;
	target.scrollIntoView();
        conuter = 0;
    }

    function next(mutations){
        body.onkeyup = function(event){
            if(mutations.length > 0 && mutations[mutations.length-1].addedNodes.length > 0){
                var node = mutations[mutations.length-1].addedNodes[0];
                var node_id = node.getElementsByTagName("img")[0].id;
                if(event.keyCode === 39) node_id++;
                else if( event.keyCode === 37) node_id--;
                var next_id = "sector_" + (node_id);
                var next_node =  document.getElementById(next_id);
                if(next_node != null){
                    target = next_node;
                    active_node = target.cloneNode(true);
                    active_node.id = node.id;
                    body.removeChild(node);
                    body.appendChild(active_node);
        	    active_node.addEventListener("click",demagnify,false);
                } 
            }
        }
    }

})();
