<?php

namespace Components\Manage\Dataspace\Services;

interface IService
{
    /**
     * Permet de créer un élément.
     *
     * @param array $params
     *
     * @return bool
     */
    public function create(array $params): bool;

    /**
     * Permet d'afficher un élément.
     *
     * @param string $field
     * @param string $var
     */
    public function read(string $field, string $var);

    /**
     * Permet de modifier un élément.
     *
     * @param int   $id
     * @param array $params
     */
    public function update(int $id, array $params);

    /**
     * Permet de supprimer un élément.
     *
     * @param string $slug
     *
     * @return bool
     */
    public function delete(string $slug): bool;

    /**
     * Permet de récupérer tout les éléments d'une table.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Permet de récupérer l'enregistrement d'une table par une clef donnée.
     *
     * @param string $field
     * @param string $value
     */
    public function getBy(string $field, string $value);

    /**
     * Permet de récupérer un enregistrement par son id.
     *
     * @param int $id
     */
    public function getById(int $id);

    /**
     * Permet de récupérer une liste d'enregistrement.
     *
     * @param string $field
     * @param string $value
     *
     * @return array
     */
    public function getByList(string $field, string $value): array;

    /**
     * Permet de paginer des éléments.
     *
     * @param int $perPage
     * @param int $currentPage
     *
     * @return Pagerfanta
     */
    public function paginate(int $perPage, int $currentPage): Pagerfanta;

    /**
     * Permet de récupérer un nombre d'enregistrement d'une table.
     *
     * @return int
     */
    public function getCount(): int;

    /**
     * Permet de vérifier si un enregistrement existe belle et bien.
     *
     * @param [type] $id
     *
     * @return bool
     */
    public function DataExists($id): bool;
}
