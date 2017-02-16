/**
 * @author NG2012
 */
//alert('Bonjour');

(function(){
    var ratio = 1.91, myImgs={};
    var myImgs = document.getElementsByClassName('imgIndexHome');
    for(var i=0, c=myImgs.length; i<c; i++){
        var myImg = myImgs[i];
        var theWidth    = parseFloat(myImg.getAttribute("width"));
        var theHeight   = parseFloat(myImg.getAttribute("height"));
        theWidth = theWidth/ratio;
        theHeight = theHeight/ratio;
    
        myImg.width = theWidth;
        myImg.height = theHeight;
    }
}());
