<?php
require_once __DIR__ . '/../Repository/DepartmentRepository.php';
require_once __DIR__ . '/../Core/Render.php';

class DepartmentController
{
    private $departmentRepo;

    public function __construct()
    {
        $this->departmentRepo = DepartmentRepository::getInstance();
    }

    public function editDepartmentForm($id)
    {
        $department = $this->departmentRepo->getDepartmentById($id);
        $viewPath = __DIR__ . '/../Views/admin/edit_department.php';
        renderSite($viewPath, ['department' => $department]);
    }

    public function updateDepartment($data)
    {
        if (isset($data['id'], $data['department_name'], $data['department_head'])) {
            try {
                $this->departmentRepo->updateDepartment(
                    (int)$data['id'],
                    $data['department_name'],
                    (int)$data['department_head']
                );
                header("Location: index.php?route=admin/departments");
                exit;
            } catch (Exception $e) {
                echo "Error saving changes: " . $e->getMessage();
            }
        } else {
            echo "Invalid input data.";
        }
    }

    public function deleteDepartment($id)
    {
        try {
            $this->departmentRepo->deleteDepartment((int)$id);
            header("Location: index.php?route=admin/departments");
            exit;
        } catch (Exception $e) {
            echo "Error deleting department: " . $e->getMessage();
        }
    }

    public function addDepartmentForm()
    {
        $viewPath = __DIR__ . '/../Views/admin/add_department.php';
        renderSite($viewPath);
    }

    public function storeDepartment($data)
    {
        if (isset($data['department_name'], $data['department_head'])) {
            try {
                $this->departmentRepo->addDepartment(
                    $data['department_name'],
                    (int)$data['department_head']
                );
                header("Location: index.php?route=admin/departments");
                exit;
            } catch (Exception $e) {
                echo "Error adding department: " . $e->getMessage();
            }
        } else {
            echo "Invalid input data.";
        }
    }
}