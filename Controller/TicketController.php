<?php

require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Repository/DepartmentRepository.php';
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Repository/AttachmentRepository.php';

class ticketController
{

    private $ticketRepo = null;
    private $departmentRepo = null;
    private $userRepo = null;
    private $attachmentRepo = null;

    public function __construct()
    {
        $this->ticketRepo = TicketRepository::getInstance();
        $this->departmentRepo = DepartmentRepository::getInstance();
        $this->userRepo = UserRepository::getInstance();
        $this->attachmentRepo = AttachmentRepository::getInstance();
    }

    public function editTicket(array $post, array $files)
    {

        $filename = basename($files["attachment"]["name"]);
        $file_url = 'http://localhost/ticketpro/Attachments/upload/' . rawurlencode($filename)  ?? '';


        if (empty($files["attachment"]["name"])) {
            $file_url = '';
        } else {
            $file_url = 'http://localhost/ticketpro/Attachments/upload/' . rawurlencode($filename)  ?? '';
            $target_dir = realpath(__DIR__ . "\..\Attachments\upload") . "\\";
            $target_file = $target_dir . basename($files["attachment"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


//        echo "filename " . $filename;

//        exit();

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (isset($_POST["ticket_id"])) {
                $fileTmp = $files["attachment"]["tmp_name"];
                $fileMime = mime_content_type($fileTmp); // Better MIME check
                $check = getimagesize($fileTmp);

                if ($check !== false && in_array($fileMime, $allowedTypes)) {
                    echo "File is a valid image - " . $check["mime"] . ".";
                } else {
                    echo "File is not a valid image.";
                    $uploadOk = 0;
                }
            }


            if (file_exists($target_file)) {
                echo "Upload failed, file already exists.";
                $uploadOk = 0;
            }

            if ($files["attachment"]["size"] > 2500000) {
                echo "File size limit exceeded, max file size is 2.5 MB.";
                $uploadOk = 0;
            }

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "bmp") {
                echo "Sorry, only JPG, JPEG, PNG, GIF & BMP files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "File was not uploaded.";
            } else {
                if (move_uploaded_file($files["attachment"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($files["attachment"]["name"])) . " has been uploaded." . "\n";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }

            echo basename($files["attachment"]["name"]);
        }


        $ticket_id = $post['ticket_id'];
        $title = $post['title'] ?? '';
        $priority = $post['priority'] ?? '';
        $department_id = $post['department'] ?? '';
        $responsible_id = $post['responsible'] ?? '';
        $date_deadline = $post['date_deadline'] ?? '';
        $is_resolved = isset($post['is_resolved']) ? 1 : 0;

        if ($file_url != '') {
            $this->attachmentRepo->addAttachment($ticket_id, basename($files["attachment"]["name"]), $file_url);
        }
        $this->ticketRepo->editTicket($ticket_id, $title, $priority, $department_id, $responsible_id, $date_deadline, $is_resolved);

        header('Location: /ticketpro/ticket');
        exit;
    }

}