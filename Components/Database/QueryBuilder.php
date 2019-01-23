<?php

namespace Components\Database;

class QueryBuilder {

    private $select;

    private $from;

    private $where;

    private $group;

    private $order;

    private $limit;

    private $connection;

    public function __construct(?\PDO $connection = null) {
        $this->connection = $connection;
    }

    public function from(string $table, ?string $alias = null): self {
        $this->from = [$table];
        if ($alias) {
            $this->from[$alias] = $table;
        } else {
            $this->from[] = $table;
        }
        return $this;
    }

    public function select(string ...$fields): self {
        $this->select = $fields;
        return $this;
    }

    public function where(string ...$condition): self {
        $this->where[] = $condition;
        return $this;
    }

    public function count(): int {}

    public function __toString() {
        $parts = ['SELECT'];
        if ($this->select) {
            $parts[] = join(', ', $this->select);
        } else {
            $parts[] = '*';
        }
        $parts[] = 'FROM';
        $parts[] = $this->buildFrom();
        $parts[] = $this->from;
        if ($this->where) {
            $parts[] = "WHERE";
            $parts[] = "(" . join(') AND (', $this-where) . ')';
        }
        return join(' ', $parts);
    }

    private function buildFrom(): string {
        $from = [];
        foreach ($this->from as $key => $value) {
            if (is_string($key)) {
                $from[] = "$value as $key";
            }
        }
    }

}