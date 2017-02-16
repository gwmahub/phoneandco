/**
 * @author NG2012
 */
//vars
var myNewCategList      = document.querySelector('#newCategList');
var adCategBut          = document.querySelector('#addCateg');
   
//Gestion de l'ajout de nouvelles catégories d'articles'

function myNewArtCateg(){
    var myTabTxt = ["Catégorie FR","Catégorie EN "];
    
    var newLabelFr              = document.createElement('label');
        newLabelFr.for          = "new category";
        newLabelFr.className    = "labelTyp_1";
    var newLabelEn              = document.createElement('label');
        newLabelEn.for          = "new category";
        newLabelEn.className    = "labelTyp_1";
    var newLabelTxtFr           = document.createTextNode(myTabTxt[0]);
    var newLabelTxtEn           = document.createTextNode(myTabTxt[1]);

    //var myLastLabelNewCateg = (myLabelsNewCateg.length)-1;
    
    var newInputFr              = document.createElement('input');
        newInputFr.type         = "text";
        newInputFr.name         = "new_art_categ[]";
        //newInputFr.value        = "<?php echo $post_new_categ_fr; ?>";
        newInputFr.className    = "inputTyp_1";
    var newInputEn              = document.createElement('input');
        newInputEn.type         = "text";
        newInputEn.name         = "new_art_categ[]";
        //newInputEn.value        = "<?php echo $post_new_categ_en; ?>";
        newInputEn.className    = "inputTyp_1";
    
    var myBr = document.createElement('br');
    
    myNewCategList.appendChild(myBr);
    
    //FR
    myNewCategList.appendChild(newLabelFr);
        newLabelFr.appendChild(newLabelTxtFr);
    myNewCategList.appendChild(newInputFr);
    
    //EN
    myNewCategList.appendChild(newLabelEn);
        newLabelEn.appendChild(newLabelTxtEn);
    myNewCategList.appendChild(newInputEn);
}

adCategBut.addEventListener("click", myNewArtCateg, false);

