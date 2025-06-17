<?php

require_once __DIR__ . '/../Repository/RoleRepository.php';
require_once __DIR__ . '/../Core/Render.php';

class RoleController
{
    private RoleRepository $roleRepo;

    public function __construct()
    {
        $this->roleRepo = RoleRepository::getInstance();
    }

    public function addRoleForm()
    {
        $viewPath = __DIR__ . '/../Views/admin/add_role.php';
        renderSite($viewPath);
    }

    public function storeRole($data)
    {
        if (isset($data['role'])) {
            try {
                $this->roleRepo->addRole($data['role']);
                header("Location: index.php?route=admin/roles");
                exit;
            } catch (Exception $e) {
                echo "Error adding role: " . $e->getMessage();
            }
        } else {
            echo "Invalid input.";
        }
    }

    public function editRoleForm($id)
    {
        $role = $this->roleRepo->getRoleById($id);
        $viewPath = __DIR__ . '/../Views/admin/edit_role.php';
        renderSite($viewPath, ['role' => $role]);
    }

    public function updateRole($data)
    {
        if (isset($data['role_id'], $data['role'])) {
            $role_id = (int)$data['role_id'];
            $role = $data['role'];

            try {
                $this->roleRepo->updateRole($role_id, $role);
                header("Location: index.php?route=admin/roles");
                exit;
            } catch (Exception $e) {
                echo "Error updating role: " . $e->getMessage();
            }
        } else {
            echo "Invalid data.";
        }
    }

    public function deleteRole($id)
    {
        try {
            $this->roleRepo->deleteRole($id);
            header("Location: index.php?route=admin/roles");
            exit;
        } catch (Exception $e) {
            echo "Error deleting role: " . $e->getMessage();
        }
    }
}