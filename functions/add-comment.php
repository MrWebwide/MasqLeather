<?php
include("../admin/include/baglan.php");
include("../admin/include/fonksiyonlar.php");




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all fields are filled
    if (!empty($_POST['comment']) && !empty($_POST['author']) && !empty($_POST['email'])) {
        // Veritabanına ekleme işlemi
        $comment = $_POST['comment'];
        $author = $_POST['author'];
        $email = $_POST['email'];
        $yorumid = $_POST['yorumid'];
        $allowedTypes = ['bagpurses', 'accessories', 'homedecor', 'jewe'];
        $tur = isset($_POST['tur']) && in_array($_POST['tur'], $allowedTypes) ? $_POST['tur'] : '';

        if (empty($tur)) {
            echo '<div id="error-message" class="message"><p>Invalid product category.</p></div>';
            exit;
        }

        // Veritabanında aynı yorumun daha önce gönderilip gönderilmediğini kontrol et
        $existingCommentQuery = "SELECT * FROM bloggelen WHERE email = :email AND yorumid = :yorumid AND tur = :tur";
        $stmt = $db->prepare($existingCommentQuery);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':yorumid', $yorumid);
        $stmt->bindParam(':tur', $tur);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Eğer aynı yorum varsa, kullanıcıya bir hata mesajı Show
            echo '
            <div id="error-message" class="message">
                <p>This comment has already been submitted.</p>
            </div>
            ';
        } else {
            // Eğer aynı yorum veritabanında yoksa, yeni yorumu kaydet
            $sql = "INSERT INTO bloggelen (name, email, messagee, yorumid, tur, eklenme_tarihi)
                VALUES (:author, :email, :comment, :yorumid, :tur, NOW())";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':yorumid', $yorumid);
            $stmt->bindParam(':tur', $tur);

            if ($stmt->execute()) {
                echo '
                <div id="success-message" class "message">
                    <p>Your review has been successfully submitted!</p>
                </div>
                ';
            } else {
                echo '
                <div id="error-message" class="message">
                    <p>The review submission has failed..</p>
                </div>
                ';
            }
        }
    } else {
        echo '
        <div id="error-message" class="message">
            <p>Please fill in all of the fields!</p>
        </div>
        ';
    }
}


?>
