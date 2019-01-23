<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 02/01/2019
 * Time: 16:03
 */

namespace Application\Home\Repositories;

use Components\Database\Repository;

class HomeRepository extends Repository
{
    private $connection;

    public function __construct(\PDO $connection) {

        $this->connection = $connection;
    }

    public function findAll() {
        return $this->connection->query('SELECT * FROM tutorials');
    }

    public function find(int $id) {
        $query = $this->connection
            ->prepare('SELECT * FROM tutorials WHERE id = ?');
        $query->execute([$id]);
        return $query->fetch() ?: null;

    }

    /*public function findAll()
    {
        $req = $this->connection->getPDO()->prepare("SELECT * FROM posts");
        $req->execute();

        $posts = [];
        foreach ($req as $post) {
            $posts[] = new PostEntity($post);
        }

        return $posts;
    }*/

    /**
     * Met à jour un enregistrement dans la base de données
     *
     * @param int $id
     * @param array $fields
     * @return bool
     */
    public function update(int $id, array $params) {
        $fieldQuery = join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
        $params['id'] = $id;
        $statment = $this->connection->prepare("UPDATE tutorials SET $fieldQuery WHERE id = :id");
        return $statment->execute($params);
    }
}