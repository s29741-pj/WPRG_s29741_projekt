<?php
require_once __DIR__ . '/../Repository/UserRepository.php';
require_once __DIR__ . '/../Core/Render.php';

class UserController
{
    private $userRepo;

    public function __construct()
    {
        $this->userRepo = UserRepository::getInstance();
    }


    public function editUserForm($id)
    {
        $user = $this->userRepo->getUserById($id);
        $departmentsRepo = DepartmentRepository::getInstance();

        $departments = $departmentsRepo->listDepartments();

        $viewPath = __DIR__ . '/../Views/admin/edit_user.php';
        renderSite($viewPath, ['user' => $user, 'departments' => $departments]);
    }


    public function updateUser($data)
    {
        $router = new Router();
        
        if (isset($data['id'], $data['surname'], $data['email'], $data['role_id'], $data['department_id'])) {
            try {
                $this->userRepo->updateUser(
                    (int) $data['id'],
                    (int) $data['role_id'],
                    '', // Możesz dostosować, gdy pole "name" będzie potrzebne
                    $data['surname'],
                    $data['email'],
                    (int) $data['department_id'] // Przekazanie ID departamentu
                );
                header("Location:" . $router->getBasePath() . "/admin/users");
            } catch (Exception $e) {
                echo "Error saving changes: " . $e->getMessage();
            }
        } else {
            echo "Invalid input data.";
        }
    }



    public function deleteUser($id)
    {
        $router = new Router();

        try {
            $this->userRepo->deleteUser((int)$id);
            header("Location:" . $router->getBasePath() . "/admin/departments");
        } catch (Exception $e) {
            echo "Error deleting user: " . $e->getMessage();
        }
    }
}