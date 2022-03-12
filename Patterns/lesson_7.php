<?php
// 1. Найти и указать в проекте Front Controller и расписать классы, которые с ним взаимодействуют.

// FrontController - architecture/app/Kernel.php

// Классы, с которыми он взаимодействует:
// Registry;
// Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
// Symfony\Component\DependencyInjection\ContainerBuilder;
// Symfony\Component\Config\FileLocator;
// Symfony\Component\HttpKernel\Controller\ControllerResolver;
// Symfony\Component\HttpKernel\Controller\ArgumentResolver;
// Symfony\Component\HttpFoundation\Request;
// Symfony\Component\HttpFoundation\Response;
// Symfony\Component\HttpFoundation\Session\Session;
// Symfony\Component\Routing\Exception\ResourceNotFoundException;
// Symfony\Component\Routing\Matcher\UrlMatcher;
// Symfony\Component\Routing\RequestContext;
// Symfony\Component\Routing\RouteCollection;


// 2. Найти в проекте паттерн Registry и объяснить, почему он был применён.

// architecture/app/framework/Registry.php

// Он применяется для создания контейнеров, получения конфигурационных данных и рендеринга страниц.


// 3. Добавить во все классы Repository использование паттерна Identity Map вместо постоянного генерирования сущностей.

// architecture/src/Model/Repository/Product.php
declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class Product
{   
    private $identityMap = [];

    // Добавление в identityMap
    public function add($product)
    {
        $key = $this->getGlobalKey(get_class($product), $product->getId());
        $this->identityMap[$key] = $product;
    }

    // Получение из identityMap. Если его там нет, то запрос в БД.
    public function get(string $classname, int $id)
    {
        $key = $this->getGlobalKey($classname, $id);
 
        if (isset($this->identityMap[$key])) {
            return $this->identityMap[$key];
        } else {
            // Запрос в БД
            $product = _query(); 
            $this->add($product);
            return $product;
        }
    }
 
    private function getGlobalKey(string $classname, int $id)
    {
        return sprintf('%s.%d', $classname, $id);
    }

    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Product[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $productList = [];
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $productList[] = new Entity\Product($item['id'], $item['name'], $item['price']);
        }

        return $productList;
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Product[]
     */
    public function fetchAll(): array
    {
        $productList = [];
        foreach ($this->getDataFromSource() as $item) {
            $productList[] = new Entity\Product($item['id'], $item['name'], $item['price']);
        }

        return $productList;
    }

    /**
     * Получаем продукты из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $dataSource = $this->identityMap;

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $productFilter);
    }
}


// architecture/src/Model/Repository/User.php
declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class User
{    
    private $identityMap = [];

    // Добавление в identityMap
    public function add($user)
    {
        $key = $this->getGlobalKey(get_class($user), $user->getId());
        $this->identityMap[$key] = $user;
    }

    // Получение из identityMap. Если его там нет, то запрос в БД.
    public function get(string $classname, int $id)
    {
        $key = $this->getGlobalKey($classname, $id);
 
        if (isset($this->identityMap[$key])) {
            return $this->identityMap[$key];
        } else {            
            // Запрос в БД
            $product = _query();
            $this->add($product);
            return $product;
        }
    }
    /**
     * Получаем пользователя по идентификатору
     *
     * @param int $id
     * @return Entity\User|null
     */
    public function getById(int $id): ?Entity\User
    {
        foreach ($this->getDataFromSource(['id' => $id]) as $user) {
            return $this->createUser($user);
        }

        return null;
    }

    /**
     * Получаем пользователя по логину
     *
     * @param string $login
     * @return Entity\User
     */
    public function getByLogin(string $login): ?Entity\User
    {
        foreach ($this->getDataFromSource(['login' => $login]) as $user) {
            if ($user['login'] === $login) {
                return $this->createUser($user);
            }
        }

        return null;
    }

    /**
     * Фабрика по созданию сущности пользователя
     *
     * @param array $user
     * @return Entity\User
     */
    private function createUser(array $user): Entity\User
    {
        $role = $user['role'];

        return new Entity\User(
            $user['id'],
            $user['name'],
            $user['login'],
            $user['password'],
            new Entity\Role($role['id'], $role['title'], $role['role'])
        );
    }

    /**
     * Получаем пользователей из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $admin = ['id' => 1, 'title' => 'Super Admin', 'role' => 'admin'];
        $user = ['id' => 1, 'title' => 'Main user', 'role' => 'user'];
        $test = ['id' => 1, 'title' => 'For test needed', 'role' => 'test'];

        $dataSource = $identityMap;

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return (bool) array_intersect($dataSource, $search);
        };

        return array_filter($dataSource, $productFilter);
    }
}