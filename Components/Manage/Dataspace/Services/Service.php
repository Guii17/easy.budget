<?php

namespace Components\Manage\Dataspace\Services;

class Service implements IService
{
    private $table;

    private $entity;

    protected $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Permet de créer un élément.
     *
     * @param array $params
     *
     * @return bool
     */
    public function create(array $params): bool
    {
        $fields = array_keys($params);
        $values = join(
            ', ', array_map(
                function ($field) {
                    return ':'.$field;
                }, $fields
            )
        );
        $fields = join(', ', $fields);
        $query = $this->connection->prepare("INSERT INTO {$this->table} ($fields) VALUES ($values)");

        return $query->execute($params);
    }

    /**
     * Permet d'afficher un élément.
     */
    public function read(string $field, string $var)
    {
    }

    /**
     * Permet de modifier un élément.
     *
     * @param int   $id
     * @param array $params
     */
    public function update(int $id, array $params)
    {
        $fieldQuery = $this->buildFieldQuery($params);
        $params['id'] = $id;
        $query = $this->connection->prepare("UPDATE {$this->table} SET $fieldQuery WHERE id = :id");
        $query->execute($params);

        return $query;
    }

    /**
     * Permet de supprimer un élément.
     *
     * @param string $slug
     *
     * @return bool
     */
    public function delete(string $slug): bool
    {
        $query = $this->connection->prepare("DELETE FROM {$this->table} WHERE slug = ?");

        return $query->execute([$slug]);
    }

    /**
     * Permet de récupérer tout les éléments d'une table.
     *
     * @return array
     */
    public function getAll(): array
    {
        $query = $this->connection->query("SELECT * FROM {$this->table}");
        if ($this->entity) {
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        } else {
            $query->setFetchMode(\PDO::FETCH_OBJ);
        }

        return $query->fetchAll();
    }

    /**
     * Permet de récupérer l'enregistrement d'une table par une clef donnée.
     *
     * @param string $field
     * @param string $value
     */
    public function getBy(string $field, string $value)
    {
        return $this->fetchOrFail("SELECT * FROM {$this->table} WHERE $field = ?", [$value]);
    }

    /**
     * Permet de récupérer un enregistrement par son id.
     *
     * @param int $id
     */
    public function getById(int $id)
    {
        return $this->connection->query("SELECT * FROM {$this->table} WHERE id = $id");
        // return $this->fetchOrFail("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    /**
     * Permet de récupérer une liste d'enregistrement.
     *
     * @param string $field
     * @param string $value
     *
     * @return array
     */
    public function getByList(string $field, string $value): array
    {
        $results = $this->connection
            ->query("SELECT id, name FROM {$this->table}")
            ->fetchAll(\PDO::FETCH_NUM);
        $list = [];
        foreach ($results as $result) {
            $list[$result[0]] = $result[1];
        }

        return $list;
    }

    /**
     * Permet de paginer des éléments.
     *
     * @param int $perPage
     * @param int $currentPage
     *
     * @return Pagerfanta
     */
    public function paginate(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->connection,
            "SELECT * FROM {$this->table}",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->entity
        );

        return (new Pagerfanta($query))
            ->setMaxPerPage($perPage)
            ->setCurrentPage($currentPage);
    }

    /**
     * Permet de récupérer un nombre d'enregistrement d'une table.
     *
     * @return int
     */
    public function getCount(): int
    {
        return $this->fetchColumn("SELECT COUNT(id) FROM {$this->table}");
    }

    /**
     * Permet de vérifier si un enregistrement existe belle et bien.
     *
     * @param [type] $id
     *
     * @return bool
     */
    public function DataExists($id): bool
    {
        $query = $this->connection->prepare("SELECT id FROM {$this->table} WHERE id = ?");
        $query->execute([$id]);

        return $query->fetchColumn() !== false;
    }

    /**
     * Undocumented function.
     *
     * @param array $params
     */
    private function buildFieldQuery(array $params)
    {
        return join(
            ', ', array_map(
                function ($field) {
                    return "$field = :$field";
                }, array_keys($params)
            )
        );
    }

    /**
     * Undocumented function.
     *
     * @param string $query
     * @param array  $params
     */
    protected function fetchOrFail(string $query, array $params = [])
    {
        $query = $this->connection->prepare($query);
        $query->execute($params);
        if ($this->entity) {
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        }
        $record = $query->fetch();
        if ($record === false) {
            throw new NoRecordException();
        }

        return $record;
    }

    /**
     * Undocumented function.
     *
     * @param string $query
     * @param array  $params
     */
    private function fetchColumn(string $query, array $params = [])
    {
        $query = $this->connection->prepare($query);
        $query->execute($params);
        if ($this->entity) {
            $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        }

        return $query->fetchColumn();
    }

    /**
     * Get the value of table.
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the value of entity.
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Get the value of connection.
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
