<?php
class Upload
{
    function doUpload($files, $uploadDirectory)
    {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/" . $uploadDirectory . "/";
        $imageFileType = strtolower(pathinfo($files["name"], PATHINFO_EXTENSION));
        $fileName = pathinfo($files["name"], PATHINFO_FILENAME);
        $fileExtension = strtolower(pathinfo($files["name"], PATHINFO_EXTENSION));
        $newFileName = $fileName . "_" . time() . "." . $fileExtension;
        $target_file = $target_dir . $newFileName;
        $uploadOk = 1;

        // Kiểm tra thư mục upload
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Kiểm tra file ảnh
        $check = getimagesize($files["tmp_name"]);
        if ($check === false) {
            return ['status' => 'error', 'message' => 'File không phải là hình ảnh.'];
        }

        // Kiểm tra kích thước file
        if ($files["size"] > 500000) {
            return ['status' => 'error', 'message' => 'Dung lượng file quá lớn. Kích thước tối đa cho phép là 500KB.'];
        }

        // Kiểm tra định dạng file
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            return ['status' => 'error', 'message' => 'Chỉ chấp nhận các định dạng JPG, JPEG, PNG và GIF.'];
        }

        // Upload file
        if (move_uploaded_file($files["tmp_name"], $target_file)) {
            return ['status' => 'success', 'file_path' => $target_file, 'file_name' => $newFileName];
        } else {
            return ['status' => 'error', 'message' => 'Đã xảy ra lỗi trong quá trình tải file.'];
        }
    }
}
?>