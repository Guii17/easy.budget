<?php

namespace Components\Manage\Pagination;

use Pagerfanta\Adapter\AdapterInterface;

class PaginatedQuery implements AdapterInterface
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $countQuery;

    /**
     * @var string|null
     */
    private $entity;
    /**
     * @var array
     */
    private $params;

    /**
     * PaginatedQuery constructor.
     *
     * @param \PDO        $connection
     * @param string      $query      Requête permettant de récupérer X résultats
     * @param string      $countQuery Requête permettant de compter le nbre de résultats total
     * @param string|null $entity
     * @param array       $params
     */
    public function __construct(
        \PDO $connection,
        string $query,
        string $countQuery,
        ?string $entity,
        array $params = []
    ) {
        $this->connection = $connection;
        $this->query = $query;
        $this->countQuery = $countQuery;
        $this->entity = $entity;
        $this->params = $params;
    }

    /**
     * Returns the number of results.
     *
     * @return int the number of results
     */
    public function getNbResults(): int
    {
        if (!empty($this->params)) {
            $query = $this->connection->prepare($this->countQuery);
            $query->execute($this->params);

            return $query->fetchColumn();
        }

        return $this->connection->query($this->countQuery)->fetchColumn();
    }

    /**
     * Returns an slice of the results.
     *
     * @param int $offset the offset
     * @param int $length the length
     *
     * @return array|\Traversable the slice
     */
    public function getSlice($offset, $length): array
    {
        $statement = $this->connection->prepare($this->query.' LIMIT :offset, :length');
        foreach ($this->params as $key => $param) {
            $statement->bindParam($key, $param);
        }
        $statement->bindParam('offset', $offset, \PDO::PARAM_INT);
        $statement->bindParam('length', $length, \PDO::PARAM_INT);
        if ($this->entity) {
            $statement->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        }
        $statement->execute();

        return $statement->fetchAll();
    }
}
