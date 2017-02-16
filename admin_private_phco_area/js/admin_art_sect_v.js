/**
 * @author NG2012
 */

//vars
var myButDisplayElem    = document.querySelectorAll(".butDisplay");
var myDivArtCateg       = document.querySelectorAll(".blocDispCategElem");
    
function displayArtCateg(){
   if(myDivArtCateg){
       myDiv = {};
       for(var i=0, c=myDivArtCateg.length; i<c; i++ ){
           myDiv = myDivArtCateg[i];
           if(myDiv.style.visibility == "visible"){
                myDiv.style.visibility = "hidden";
           }else{
               myDiv.style.visibility = "visible";
           }
       }
   }
}

for(var j=0, c=myButDisplayElem.length; j<c; j++){
    myButDisplayEl = {};
    myButDisplayEl = myButDisplayElem[j];
    myButDisplayEl.addEventListener("click", displayArtCateg, false);
}

