<?php
class Upload
{
    function doUpload($files,$uploadDirectory)
    {
        // $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/NguyenAnhQuoc/asset/avatar/";
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/" . $uploadDirectory . "/"; 
        $imageFileType = strtolower(pathinfo($files["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . basename($files["name"]); // Giữ nguyên tên file
        $uploadOk = 1;

        // Check if image file is an actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($files["tmp_name"]);
            if ($check !== false) {
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "File là hình ảnh - ' . $check["mime"] . '.",
                        confirmButtonText: "OK"
                    });
                </script>';
                $uploadOk = 1;
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "File không phải là hình ảnh.",
                        confirmButtonText: "OK"
                    });
                </script>';
                $uploadOk = 0;
            }
        }

        // Check file size
        if ($files["size"] > 500000) {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Dung lượng file quá lớn. Kích thước tối đa cho phép là 500KB.",
                    confirmButtonText: "OK"
                });
            </script>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Chỉ chấp nhận các định dạng JPG, JPEG, PNG và GIF.",
                    confirmButtonText: "OK"
                });
            </script>';
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Không thể tải file lên do có lỗi.",
                    confirmButtonText: "OK"
                });
            </script>';
        } else {
            if (move_uploaded_file($files["tmp_name"], $target_file)) {
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "File ' . htmlspecialchars(basename($files["name"])) . ' đã được tải lên thành công.",
                        confirmButtonText: "OK"
                    });
                </script>';
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Đã xảy ra lỗi trong quá trình tải file.",
                        confirmButtonText: "OK"
                    });
                </script>';
            }
        }
    }
}
?>
