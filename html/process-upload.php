<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

if (empty($_FILES)) {
    exit('$_FILES is empty - is file_uploads set to "Off" in php.ini?');
}

if ($_FILES["pdf"]["error"] !== UPLOAD_ERR_OK) {

    switch ($_FILES["pdf"]["error"]) {
        case UPLOAD_ERR_PARTIAL:
            exit('File only partially uploaded');
            break;
        case UPLOAD_ERR_NO_FILE:
            exit('No file was uploaded');
            break;
        case UPLOAD_ERR_EXTENSION:
            exit('File upload stopped by a PHP extension');
            break;
        case UPLOAD_ERR_FORM_SIZE:
            exit('File exceeds MAX_FILE_SIZE in the HTML form');
            break;
        case UPLOAD_ERR_INI_SIZE:
            exit('File exceeds upload_max_filesize in php.ini');
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            exit('Temporary folder not found');
            break;
        case UPLOAD_ERR_CANT_WRITE:
            exit('Failed to write file');
            break;
        default:
         
        exit('Unknown upload error');
            break;
    }
}

// Reject uploaded file larger than 1MB
// ... Previous PHP code ...

// Check for the PDF file
if ($_FILES["pdf"]["error"] !== UPLOAD_ERR_OK) {
    switch ($_FILES["pdf"]["error"]) {
        // Handle different upload errors, similar to how you did for the image file
        // ...
    }
}

// Reject uploaded PDF file larger than 5MB (you can adjust this size as needed)
if ($_FILES["pdf"]["size"] > 5242880) {
    exit('PDF file too large (max 5MB)');
}

// Use fileinfo to get the mime type of the PDF file
$finfo_pdf = new finfo(FILEINFO_MIME_TYPE);
$mime_type_pdf = $finfo_pdf->file($_FILES["pdf"]["tmp_name"]);

// Define the allowed PDF mime types
$allowed_mime_types_pdf = ["application/pdf"];

// Check if the uploaded file is a valid PDF
if (!in_array($mime_type_pdf, $allowed_mime_types_pdf)) {
    exit("Invalid file type. Only PDF files are allowed.");
}

// Replace any characters not \w- in the original PDF filename
$pathinfo_pdf = pathinfo($_FILES["pdf"]["name"]);
$base_pdf = $pathinfo_pdf["filename"];
$base_pdf = preg_replace("/[^\w-]/", "_", $base_pdf);
$filename_pdf = $base_pdf . "." . $pathinfo_pdf["extension"];
$destination_pdf = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $filename_pdf;

// Add a numeric suffix if the PDF file already exists
$i = 1;
while (file_exists($destination_pdf)) {
    $filename_pdf = $base_pdf . "($i)." . $pathinfo_pdf["extension"];
    $destination_pdf = __DIR__ . "/uploads/" . $filename_pdf;
    $i++;
}

// Move the uploaded PDF file to the destination folder
if (!move_uploaded_file($_FILES["pdf"]["tmp_name"], $destination_pdf)) {
    exit("Can't move uploaded PDF file");
}

// ... Continue with any further processing or display a success message ...
echo "Files uploaded successfully.";
header("Location: uploader-file.html");
