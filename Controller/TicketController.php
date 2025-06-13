<?php

require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Repository/DepartmentRepository.php';
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Repository/AttachmentRepository.php';
require_once __DIR__ . '/../Flash/Msg.php';

use FlashMsg\msg;

class ticketController
{

    private $ticketRepo = null;
    private $departmentRepo = null;
    private $userRepo = null;
    private $attachmentRepo = null;
    private Msg $msg;


    public function __construct()
    {
        $this->ticketRepo = TicketRepository::getInstance();
        $this->departmentRepo = DepartmentRepository::getInstance();
        $this->userRepo = UserRepository::getInstance();
        $this->attachmentRepo = AttachmentRepository::getInstance();
        $this->msg = Msg::getInstance();
    }

    public function editTicket(array $post, array $files)
    {

        // List of required fields
        $requiredFields = ['ticket_id', 'title', 'priority', 'department', 'responsible', 'date_deadline'];

        // Check for empty required fields
        foreach ($requiredFields as $field) {
            if (empty($post[$field])) {
                $this->msg->set_flash('edit_error', 'Error: Missing required field' . $field);
                header("Location: /ticketpro_app/ticket");
                exit;
            }
        }

        $filename = basename($files["attachment"]["name"]);
        $file_url = 'http://localhost/ticketpro_app/Attachments/upload/' . rawurlencode($filename) ?? '';
        $files = $_FILES;

        self::fileUpload();

        $ticket_id = $post['ticket_id'];
        $title = $post['title'] ?? '';
        $priority = $post['priority'] ?? '';
        $department_id = $post['department'] ?? '';
        $responsible_id = $post['responsible'] ?? '';
        $date_deadline = $post['date_deadline'] ?? '';
        $is_resolved = isset($post['is_resolved']) ? 1 : 0;

        $currentTicket = $this->ticketRepo->getTicket($ticket_id);
        $currentDeadline = $currentTicket['date_deadline'] ?? null;


        $today = date('Y-m-d');
        $newDeadlineDate = date('Y-m-d', strtotime($date_deadline));
        $oldDeadlineDate = $currentDeadline ? date('Y-m-d', strtotime($currentDeadline)) : null;

        if ($newDeadlineDate < $today && ($oldDeadlineDate === null || $newDeadlineDate < $oldDeadlineDate)) {
            $this->msg->set_flash('edit_error', 'Error: Deadline cannot be earlier than today.');
            header("Location: /ticketpro_app/ticket");
            exit;
        }


        if ($file_url != '') {
            $this->attachmentRepo->addAttachment($ticket_id, basename($files["attachment"]["name"]), $file_url);
        }
        $this->ticketRepo->editTicket($ticket_id, $title, $priority, $department_id, $responsible_id, $date_deadline, $is_resolved);

        header('Location: /ticketpro_app/ticket');
        exit;
    }

    private function fileUpload()
    {
        if (empty($files["attachment"]["name"])) {
            $file_url = '';
        } else {
            $uploadOk = 1;
            $target_dir = realpath(__DIR__ . '/../Attachments/upload');
            if ($target_dir === false) {
                die("Upload folder not found.");
            }

            $target_file = $target_dir . DIRECTORY_SEPARATOR . basename($files["attachment"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileTmp = $files["attachment"]["tmp_name"];
            $fileMime = mime_content_type($fileTmp);
            $check = getimagesize($fileTmp);

            if ($check === false || !in_array($fileMime, $allowedTypes)) {
                echo "File is not a valid image.";
                $uploadOk = 0;
            }

            if (file_exists($target_file)) {
                echo "Upload failed, file already exists.";
                $uploadOk = 0;
            }

            if ($files["attachment"]["size"] > 2500000) {
                echo "File size limit exceeded.";
                $uploadOk = 0;
            }

            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                echo "Invalid file extension.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "File was not uploaded.";
            } else {
                if (move_uploaded_file($fileTmp, $target_file)) {
                    var_dump(is_writable($target_dir));     // czy folder jest zapisywalny?
                    var_dump(file_exists($fileTmp));         // czy tymczasowy plik istnieje?
                    var_dump($target_file);                  // gdzie próbujesz zapisać?

                    echo "File uploaded: " . htmlspecialchars(basename($files["attachment"]["name"]));
                } else {
                    error_log("move_uploaded_file failed. TMP: $fileTmp, TARGET: $target_file");
                    echo "Upload error.";
                }
            }
        }
    }

    public function addTicket(array $post, array $files)
    {
        $requiredFields = ['title', 'priority', 'department', 'date_deadline'];

        foreach ($requiredFields as $field) {
            if (empty($post[$field])) {
                $this->msg->set_flash('edit_error', 'Error: Missing required field ' . $field);
                exit('Error: Missing required field ' . $field);
                header("Location: /ticketpro_app/ticket");
                exit;
            }
        }


        $title = $post['title'] ?? '';
        $priority = $post['priority'] ?? '';
        $department_id = $post['department'] ?? null;
        $responsible_id = $post['responsible'] ?? null;
        $date_deadline = $post['date_deadline'] ?? '';

        $currentDeadline = $currentTicket['date_deadline'] ?? null;

        $today = date('Y-m-d');
        $deadlineDate = date('Y-m-d', strtotime($date_deadline));

        if ($deadlineDate < $today) {
            $this->msg->set_flash('edit_error', 'Error: Deadline cannot be earlier than today.');
//            exit("date");
            header("Location: /ticketpro_app/ticket");
            exit;
        }

        $this->ticketRepo->addTicket($title, $priority, $department_id, $responsible_id, $date_deadline);


        if (isset($_FILES['attachment'])) {
            $filename = basename($files["attachment"]["name"]);
            $file_url = 'http://localhost/ticketpro_app/Attachments/upload/' . rawurlencode($filename) ?? '';
            $files = $_FILES;
            self::fileUpload();
            $new_ticket_id = $this->ticketRepo->getLastTicket();
            $this->attachmentRepo->addAttachment($new_ticket_id["ticket_id"], basename($files["attachment"]["name"]), $file_url);
            header('Location: /ticketpro_app/ticket');
            exit;
        } else {
            header('Location: /ticketpro_app/ticket');
            exit;
        }
    }

    public function removeTicket($ticket_id)
    {
        $this->ticketRepo->removeTicket($ticket_id);
        header('Location: /ticketpro_app/ticket');
        exit;
    }


}