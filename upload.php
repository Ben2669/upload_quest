<?php


if(isset($_POST['submit'])) {
    if (count($_FILES['upload']['name']) > 0) {
        $folder = 'uploads/';
        $maxSize = 1000000;
        $extensions = array('.png', '.gif', '.jpg');
        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
            $file = basename($_FILES['upload']['name'][$i]);
            $extension = strrchr($_FILES['upload']['name'][$i], '.');
            $size = filesize($_FILES['upload']['tmp_name'][$i]);
            if (!in_array($extension, $extensions)) {
                $error = "You must upload either a .png, .gif or .jpg file!";
            }
            if (!$size) {
                $error = "File could not be uploaded because of size limitation!";
            }
            if (!isset($error)) {
                $file = uniqid().'.'.$extension;
                if (move_uploaded_file($_FILES['upload']['tmp_name'][$i], $folder . $file)) {
                    echo "Upload successful!";
                } else {
                    echo "Upload failed!";
                }
            } else {
                echo $error;
            }
        }
    }
}
;?>

<form action="" enctype="multipart/form-data" method="post">

    <div>
        <label for='upload'>Add Attachments:</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        <input id='upload' name="upload[]" type="file" multiple="multiple" />
    </div>

    <p><input type="submit" name="submit" value="Submit"></p>

</form>

<?php

$uploadedFiles = new FilesystemIterator("uploads/");
foreach ($uploadedFiles as $uploadedFile) :?>
    <figure>
        <img src="<?php echo $uploadedFile;?>">
        <figcaption><?php echo $uploadedFile->getFilename();?></figcaption>
    </figure>
<?php endforeach;?>
