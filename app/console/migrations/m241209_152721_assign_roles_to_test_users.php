<?php

use yii\db\Migration;

/**
 * Class m241209_152721_assign_roles_to_test_users
 */
class m241209_152721_assign_roles_to_test_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Создание разрешений
        $this->createPermissions($auth);

        // Создание ролей
        $this->createRoles($auth);

        // Назначение ролей пользователям
        $this->assignRolesToUsers($auth);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Удаление ролей у пользователей
        $auth->revokeAll(1); // testuser1
        $auth->revokeAll(2); // testuser2
        $auth->revokeAll(3); // testguest
    }

    private function createPermissions($auth)
    {
        $permissions = [
            'viewBook',
            'createBook',
            'updateBook',
            'deleteBook',
        ];

        foreach ($permissions as $permissionName) {
            if (!$auth->getPermission($permissionName)) {
                $permission = $auth->createPermission($permissionName);
                $auth->add($permission);
            }
        }
    }

    private function createRoles($auth)
    {
        $roles = [
            'guest',
            'user',
        ];

        foreach ($roles as $roleName) {
            if (!$auth->getRole($roleName)) {
                $role = $auth->createRole($roleName);
                $auth->add($role);
            }
        }

        // Добавление дочерних элементов
        $this->addChildRoles($auth);
    }

    private function addChildRoles($auth)
    {
        $guest = $auth->getRole('guest');
        $user = $auth->getRole('user');

        $auth->addChild($guest, $auth->getPermission('viewBook'));
        $auth->addChild($user, $auth->getPermission('viewBook'));
        $auth->addChild($user, $auth->getPermission('createBook'));
        $auth->addChild($user, $auth->getPermission('updateBook'));
        $auth->addChild($user, $auth->getPermission('deleteBook'));
    }

    private function assignRolesToUsers($auth)
    {
        $userRole = $auth->getRole('user');
        $guestRole = $auth->getRole('guest');

        // Проверка существования пользователей перед назначением ролей
        if ($this->userExists(1)) {
            $auth->assign($userRole, 1); // testuser1
        }
        if ($this->userExists(2)) {
            $auth->assign($userRole, 2); // testuser2
        }
        if ($this->userExists(3)) {
            $auth->assign($guestRole, 3); // testguest
        }
    }

    private function userExists($id)
    {
        return (new \yii\db\Query())
            ->select('id')
            ->from('user') // Замените 'user' на имя вашей таблицы пользователей
            ->where(['id' => $id])
            ->exists();
    }
}