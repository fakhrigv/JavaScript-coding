	let Form = document.forms.namedItem("10");
	let elems = Form.querySelectorAll('input[name] , textarea[name] , select[name]');
	var DataBase = {};

	EListenerOnChange();
	EListenerOnClick();
	let bool = false;


	function noJQuery() {
		bool = true;
		var FormField = new FormData();
		FormField.append('info',JSON.stringify(DataBase));
		FormField.append('submitted',bool);
		var xml = new XMLHttpRequest();
		xml.onload = function() {
			console.log(this.responseText);
		}
		xml.open('POST','service.php',true);
		xml.send(FormField);
	}



	function EListenerOnChange() {
		for(let i=0;i<elems.length;i++) {
			elems[i].addEventListener("change",function()
				 {  
				 	DataBase[Date.now()] = { 
					control: this.getAttribute("name")
					,event:"change"
					,value: this.value };
				}
			); 
		}					
	}		 


	function EListenerOnClick() {
		for(let i=0;i<elems.length;i++) {
			elems[i].addEventListener("click",function() 
				{   
				DataBase[Date.now()] = { 
				control: this.getAttribute("name")
				,event:"click" };
				}
			);
		}
	}


		/*
		function EListenerShowData() {
		for(let i=0;i<elemDiv.length;i++) {
		elemDiv[i].addEventListener("click",function() { 
			console.log(DataBase);
			});
		}
	}
	*/