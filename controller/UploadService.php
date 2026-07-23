<?php
class UploadService {
    public static function uploadUserPhoto($file, $userId) {
        $targetDir = __DIR__ . "/../public/images/users/";
        $fileName = basename($file["name"]);
        $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // 1. Vérifier si c'est une vraie image
        $check = getimagesize($file["tmp_name"]);
        if($check === false) return ["error" => "Le fichier n'est pas une image."];

        // 2. Vérifier la taille (max 2Mo)
        if ($file["size"] > 2000000) return ["error" => "Fichier trop lourd (max 2Mo)."];

        // 3. Autoriser certains formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return ["error" => "Seuls les formats JPG, JPEG et PNG sont autorisés."];
        }

        // 4. Renommer le fichier pour éviter les doublons (ex: user_5_162548.jpg)
        $newFileName = "user_" . $userId . "_" . time() . "." . $imageFileType;
        $targetFile = $targetDir . $newFileName;

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return ["success" => $newFileName];
        } else {
            return ["error" => "Erreur lors du déplacement du fichier."];
        }
    }
}