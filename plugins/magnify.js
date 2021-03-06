;(function(){
        /* 
            "What i like about photographs 
            is that they capture a moment that’s gone forever, 
            impossible to reproduce." 
            ~ Karl Lagerfeld
        */
	document.addEventListener("DOMContentLoaded",function(){
		var photos = document.getElementsByClassName("photo_sector");
		var main = document.getElementById("main");
		var body = document.getElementsByTagName("body")[0];
		var active_node = false;
		for(var i=0; i< photos.length;i++){
			photos[i].addEventListener("click",function(event){
				var target = event.target || event.srcElement;
				if (target.tagName.toLowerCase() != "article"){
					target = target.parentNode;
				}
				if(!active_node){
					main.style.display = "none";
					active_node = target.cloneNode(true);
					active_node.id = "magnify";
					console.log(active_node);
					active_node.addEventListener("click",function(event){
						main.style.display = "grid";
						body.removeChild(active_node);
						active_node = false;
						target.scrollIntoView();
					},false);
					body.appendChild(active_node);
				}					
			},false);
		}
	},false);
})();
