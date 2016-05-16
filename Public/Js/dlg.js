/*
 * 模态窗口
 * js新建对象，button添加  对象.open事件
 * 
 */
function DialogBox(DlgID)
{
    this.MainID="MainDlgID";//背景层的ID
	this.DlgID=DlgID;     //对话框 层ID

	this.width=0;
	this.height=0;
	
		
		//---------------------------------------------------------大框(背景层)------------------------
	var MainNode=document.createElement("div");
		
		MainNode.setAttribute("id",this.MainID);
		MainNode.style.backgroundColor="#000000";
		
		MainNode.style.left="0px";
		MainNode.style.top="0px";    
		MainNode.style.width="0px";
		MainNode.style.height="0px";
		
		MainNode.innerHTML="";
		MainNode.style.position="absolute";
		MainNode.style.zIndex="9999";
		
		MainNode.style.display="none";
		
		if(MainNode.filters){
			MainNode.style.filter="alpha(opacity=70)";
		}else{
				MainNode.style.opacity="0.7";
		}
			
			//--------------------------------------------------------- 对话框----------------
	var dlgNode=document.createElement("div");	
	var fn=document.getElementById(this.DlgID);	//网页里对话框dom
	var HtmlStr=fn.innerHTML;
			this.width=parseInt(fn.style.width);
			this.height=parseInt(fn.style.height);
			
			fn.parentNode.removeChild(fn);
			
			dlgNode.style.width=this.width+"px";
			dlgNode.style.height=this.height+"px";
			
			dlgNode.style.zIndex="9999";
			dlgNode.style.display="none";
			dlgNode.setAttribute("id",this.DlgID);
			dlgNode.style.position="absolute"; 
			dlgNode.innerHTML=HtmlStr;
			
			//-----------------------------------------------------各节点加入Dom------------
		
			
			document.body.appendChild(MainNode);
			document.body.appendChild(dlgNode);
}
		//====================================================================================
		
		//打开对话框-------------------------------------------------------------------------
		DialogBox.prototype.open=function()
		{
			var Dwidth=document.documentElement.scrollWidth;
			var Dheight=document.documentElement.scrollHeight;
			
			var CHeight=document.documentElement.clientHeight;
			var CWidth=document.documentElement.clientWidth;
			
			var scrolltop=document.documentElement.scrollTop;

			var Dlgwidth=document.getElementById(this.DlgID).style.width;
			var DlgHeight=document.getElementById(this.DlgID).style.height;
			
			document.getElementById(this.MainID).style.width=Dwidth+"px";
			document.getElementById(this.MainID).style.height=Dheight+"px";

			document.getElementById(this.DlgID).style.left=(CWidth/2)-(parseInt(Dlgwidth)/2)+"px";
			document.getElementById(this.DlgID).style.top=(scrolltop+CHeight/2-parseInt(DlgHeight)/2)+"px";
			
			document.getElementById(this.MainID).style.display="block";
			document.getElementById(this.DlgID).style.display="block";  
    }
	DialogBox.prototype.close=function(){
		
		document.getElementById(this.MainID).style.display="none";
		document.getElementById(this.DlgID).style.display="none";
	}