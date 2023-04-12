<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Je vérifie si le formulaire est soumis en methode POST
if($_SERVER['REQUEST_METHOD'] === "POST"){ 
    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
    $uploadDir = 'public/uploads/';
    // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client (mais d'autre stratégies de nommage sont possibles)
    $uploadFile = basename(tempnam($uploadDir, $_FILES['homerPic']['name']));
    // tempnam(string $directory, string $prefix): string|false
    // Je récupère l'extension du fichier
    $extension = pathinfo($_FILES['homerPic']['name'], PATHINFO_EXTENSION);
    // Les extensions autorisées
    $authorizedExtensions = ['jpg','gif','png','webp'];
    // Le poids max géré de l'image peut être de 1Mo
    $maxFileSize = 1000000;
        
    // Securisation du form
    /****** Si l'extension est autorisée *************/
    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de type Jpg, Gif, Png ou Webp !';
    }
    /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
    if( file_exists($_FILES['homerPic']['tmp_name']) && filesize($_FILES['homerPic']['tmp_name']) > $maxFileSize)
    {
    $errors[] = "Votre fichier doit faire moins de 1Mo !";
    }
    /****** Si je n'ai pas d"erreur alors j'upload *************/
      //transfert du fichier temporaire vers un dossier sur le serveur 
      move_uploaded_file($_FILES['homerPic']['tmp_name'], $uploadFile);
    if(isset($uploadFile)) {
        echo nl2br ("<img src=$uploadFile>") . PHP_EOL;
        echo nl2br  ('Ton nom:' . $_POST['name']) . PHP_EOL;
        echo nl2br  ('Ton prénom:' . $_POST['fname']) . PHP_EOL;
        echo nl2br  ('Ton âge:' . $_POST['age']) . PHP_EOL;
        
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <label for="springfieldwild">Ajoute une photo:</label>
    <input type="file" name="homerPic" id="springfieldwild">
    <label for="name">Ton nom:</label>
    <input type="text" name="name" id="name">
    <label for="fname">Ton prénom:</label>
    <input type="text" name="fname" id="fname">
    <label for="age">Ton âge:</label>
    <input type="text" name="age" id="age">
    <button name="send">Envoyer</button>
</form>
</body>
</html>

