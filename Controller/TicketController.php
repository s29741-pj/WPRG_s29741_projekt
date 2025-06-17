<?php

require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Repository/DepartmentRepository.php';
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Repository/AttachmentRepository.php';
require_once __DIR__ . '/../Flash/Msg.php';

use FlashMsg\Msg;

class TicketController
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
        $this->msg = new Msg();
    }

 private function fileUpload($files)
    {
        $result = ['success' => false, 'file_url' => '', 'filename' => '', 'error' => ''];

        if (empty($files["attachment"]["name"])) {
            return $result;
        }

        $uploadOk = 1;
        // Popraw ścieżkę docelową na absolutną ścieżkę do katalogu upload na serwerze
        $target_dir = '/home/PJWSTK/s29741/public_html/ticketpro_app/Attachments/upload';
        if (!is_dir($target_dir)) {
            $result['error'] = "Upload folder not found.";
            return $result;
        }

        $filename = basename($files["attachment"]["name"]);
        $target_file = $target_dir . DIRECTORY_SEPARATOR . $filename;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp'];
        $fileTmp = $files["attachment"]["tmp_name"];
        $fileMime = mime_content_type($fileTmp);
        $check = getimagesize($fileTmp);

        if ($check === false || !in_array($fileMime, $allowedTypes)) {
            $result['error'] = "File is not a valid image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            $result['error'] = "Upload failed, file already exists.";
            $uploadOk = 0;
        }

        if ($files["attachment"]["size"] > 2500000) {
            $result['error'] = "File size limit exceeded.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
            $result['error'] = "Invalid file extension.";
            $uploadOk = 0;
        }

  



        if ($uploadOk == 0) {
            return $result;
        } else {
            if (move_uploaded_file($fileTmp, $target_file)) {
                $result['success'] = true;
                $result['filename'] = $filename;
                // Poprawiony link:
                $result['file_url'] = '/~s29741/ticketpro_app/Attachments/upload/' . rawurlencode($filename);
                return $result;
            } else {
                $result['error'] = "Upload error.";
                return $result;
            }
        }
    }

    public function editTicket(array $post, array $files)
    {
        $requiredFields = ['ticket_id', 'title', 'priority', 'department', 'responsible', 'date_deadline'];
        foreach ($requiredFields as $field) {
            if (empty($post[$field])) {
                $this->msg->set_flash('edit_error', 'Error: Missing required field ' . $field);
                header("Location: index.php?route=ticket");
                exit;
            }
        }

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
            header("Location: index.php?route=ticket");
            exit;
        }

        // Handle file upload if present
        if (!empty($files["attachment"]["name"])) {
            $uploadResult = $this->fileUpload($files);
            
            if ($uploadResult['success']) {
                $file_url = $uploadResult['file_url'];
                $this->attachmentRepo->addAttachment($ticket_id, $uploadResult['filename'], $file_url);
            } else if ($uploadResult['error']) {
                $this->msg->set_flash('edit_error', $uploadResult['error']);
                header("Location: index.php?route=ticket");
                exit;
            }
        }

        $this->ticketRepo->editTicket($ticket_id, $title, $priority, $department_id, $responsible_id, $date_deadline, $is_resolved);

        header("Location: index.php?route=ticket");
        exit;
    }

   

    public function addTicket(array $post, array $files)
    {
        $requiredFields = ['title', 'priority', 'department', 'date_deadline'];
        foreach ($requiredFields as $field) {
            if (empty($post[$field])) {
                $this->msg->set_flash('edit_error', 'Error: Missing required field ' . $field);
                header("Location: index.php?route=ticket");
                exit;
            }
        }

        $title = $post['title'] ?? '';
        $priority = $post['priority'] ?? '';
        $department_id = $post['department'] ?? null;
        $responsible_id = $post['responsible'] ?? null;
        $date_deadline = $post['date_deadline'] ?? '';

        $today = date('Y-m-d');
        $deadlineDate = date('Y-m-d', strtotime($date_deadline));

        if ($deadlineDate < $today) {
            $this->msg->set_flash('edit_error', 'Error: Deadline cannot be earlier than today.');
            header("Location: index.php?route=ticket");
            exit;
        }

        $ticket_id = $this->ticketRepo->addTicket($title, $priority, $department_id, $responsible_id, $date_deadline);

        if (!empty($files["attachment"]["name"])) {
            $uploadResult = $this->fileUpload($files);
            if ($uploadResult['success']) {
                $this->attachmentRepo->addAttachment($ticket_id, $uploadResult['filename'], $uploadResult['file_url']);
            } else if ($uploadResult['error']) {
                $this->msg->set_flash('edit_error', $uploadResult['error']);
                header("Location: index.php?route=ticket");
                exit;
            }
        }

        header("Location: index.php?route=ticket");
        exit;
    }

    public function removeTicket($ticket_id)
    {
        $this->ticketRepo->removeTicket($ticket_id);
        header('Location: index.php?route=ticket');
        exit;
    }

    public function removeAttachment($attachment_id, $ticket_id)
    {
 
        $attachment = null;
        foreach ($this->attachmentRepo->getAttachments() as $att) {
            if ($att->getAttachmentId() == $attachment_id) {
                $attachment = $att;
                break;
            }
        }

  
        if ($attachment) {
     
            $public_url = $attachment->getFilePath(); 
            $filename = basename($public_url);
            $disk_path = '/home/PJWSTK/s29741/public_html/ticketpro_app/Attachments/upload/' . $filename;
            if (file_exists($disk_path)) {
                unlink($disk_path);
            }
        }

        // Usuń rekord z bazy
        $this->attachmentRepo->removeAttachment($attachment_id);

        // Przekieruj na listę ticketów (ticket_menu)
        header("Location: index.php?route=ticket");
        exit;
    }
}