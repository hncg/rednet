$(document).ready(function(){
	
	
	
	
})
function menutoggle(obj){
	
	$(obj).next().toggle();
	var Sp=$(obj).children("span");
	var txt=Sp.attr("class");
	if(txt=="plus")Sp.attr('class',"minus");
	if(txt=="minus")Sp.attr('class',"plus");
	
}