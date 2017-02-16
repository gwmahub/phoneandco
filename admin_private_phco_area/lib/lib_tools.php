<?php
/** /
 * @param  $file = array $_FILES 
 * */

function uploadImg($file, $path=""){
    global $connexion;
	$img="";
	$r = array();
	$a = array("ä", "â", "à");
	$e = array("é", "è", "ê", "ë");
	$i = array("ï", "î");
	$o = array("ö", "ô");
	$u = array("ù", "û", "ü");
    //$r['warnmsg'] = "";
    if (isset($file['src_fichier']['name']) AND $file['src_fichier']['name'] != "") {
        //$img = date("ymdhis")."_".basename($file['src_fichier']['name']);//avant Yh
        $img = $file['src_fichier']['name'];
        
        $img = str_replace(" ", "_", $img);
		$img = str_replace("-", "_", $img);
		$img = str_replace($a, "a", $img);
		$img = str_replace($e, "e", $img);
		$img = str_replace($i, "i", $img);
		$img = str_replace($o, "o", $img);
		$img = str_replace($u, "u", $img);
      
        $img = date("ymdhis")."_".basename($img);
		
        $tmp_file = $file["src_fichier"]["tmp_name"];
        if (is_uploaded_file($tmp_file)) {
            $size = getimagesize($tmp_file);
            if ($size[2] < 4) {
            	$last_id = mysqli_insert_id($connexion);
                move_uploaded_file($tmp_file, WWW_UP .$path. $img);
            } else {
                 return false;
            }
        }
    }
    $r['img'] = $img;
    return $r;
}


function uploadDoc($file, $path=""){
	$doc = "";
	$r = array();
	$a = array("ä", "â", "à");
	$e = array("é", "è", "ê", "ë");
	$i = array("ï", "î");
	$o = array("ö", "ô");
	$u = array("ù", "û", "ü");
    if (isset($file['src_fichier']['name']) AND $file['src_fichier']['name'] != "") {
        $doc = $file['src_fichier']['name'];
        
        $doc = str_replace(" ", "_", $doc);
		$doc = str_replace("-", "_", $doc);
		$doc = str_replace($a, "a", $doc);
		$doc = str_replace($e, "e", $doc);
		$doc = str_replace($i, "i", $doc);
		$doc = str_replace($o, "o", $doc);
		$doc = str_replace($u, "u", $doc);
      
        $doc = date("ymdhis")."_".basename($doc);
		
        $tmp_file = $file["src_fichier"]["tmp_name"];
        if (is_uploaded_file($tmp_file)) {
        	move_uploaded_file($tmp_file, WWW_UP .$path. $doc);
        }else{
        	return false;
        }
    }
    $r['doc'] = $doc;
    return $r;
}

/** /
 * Redimensionne et renomme l'image en fonction des parametres donnés
 * @param type $image = chemin de l'image sur le disque
 * @param type $largeur = future largeur de l'image
 * @param type $nom = futur nom de l'image
 * @return boolean
 */
 
//resize($img, 150, "thumb_".$upload["photo"], WWW_UP."thumb/news/");
//$avatar = "avatar".basename($post_src_fichier['name']);

function resize_jpg($image, $largeur, $nom, $file) {
		$image_origine = imagecreatefromjpeg($image);
	    // Récupération des dimensions de l'image
	    list($width, $height, $type, $attr) = getimagesize($image);
	    // Calcul de la nouvelle hauteur
	    $ratio = $width / $height;
	    $hauteur = $largeur / $ratio;
	    // Création d'un conteneur pour la nouvelle image
	    $new_image = imagecreatetruecolor($largeur, $hauteur);
	
	    if (!$new_image) {
	    	echo "PROBLEME__________JPG______________";
	        return false;
	    } else {
	        // Création de l'image dans les nouvelles dimensions et suppression de l'ancienne
	        imagecopyresampled($new_image, $image_origine, 0, 0, 0, 0, $largeur, $hauteur, $width, $height);
	        imagejpeg($new_image, $file.$nom, 100);
	        imagedestroy($image_origine);
	        return true;
	    }
}

function resize_gif($image, $largeur, $nom, $file) {
		$image_origine = imagecreatefromgif($image);
	    // Récupération des dimensions de l'image
	    list($width, $height, $type, $attr) = getimagesize($image);
	    // Calcul de la nouvelle hauteur
	    $ratio = $width / $height;
	    $hauteur = $largeur / $ratio;
	    // Création d'un conteneur pour la nouvelle image
	    $new_image = imagecreatetruecolor($largeur, $hauteur);
	
	    if (!$new_image) {
	    	echo "PROBLEME_________GIF_______________";
	        return false;
	    } else {
	        // Création de l'image dans les nouvelles dimensions et suppression de l'ancienne
	        imagecopyresampled($new_image, $image_origine, 0, 0, 0, 0, $largeur, $hauteur, $width, $height);
	        imagegif($new_image, $file.$nom, 100);
	        imagedestroy($image_origine);
	        return true;
	    }
}

function resize_png($image, $largeur, $nom, $file) {
		$image_origine = imagecreatefrompng($image);
	    // Récupération des dimensions de l'image
	    list($width, $height, $type, $attr) = getimagesize($image);
	    // Calcul de la nouvelle hauteur
	    $ratio = $width / $height;
	    $hauteur = $largeur / $ratio;
	    // Création d'un conteneur pour la nouvelle image
	    $new_image = imagecreatetruecolor($largeur, $hauteur);
	
	    if (!$new_image) {
	    	echo "PROBLEME____________PNG____________";
	        return false;
	    } else {
	        // Création de l'image dans les nouvelles dimensions et suppression de l'ancienne
	        imagecopyresampled($new_image, $image_origine, 0, 0, 0, 0, $largeur, $hauteur, $width, $height);
	        imagepng($new_image, $file.$nom, 0, 0);
	        imagedestroy($image_origine);
	        return true;
	    }
}

function delPicFile($picfile,$path="") {
    if (file_exists(WWW_UP .$path. $picfile) && is_file(WWW_UP .$path . $picfile) ) {
    	return unlink(WWW_UP .$path. $picfile);
    } else {
        return false;
    }
}


?>