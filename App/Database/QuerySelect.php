<?php

namespace System\Database;

class QuerySelect
{
    protected Connection $db;
    protected SelectBuilder $builder;
    protected array $brings = [];

    public function __construct(Connection $db, SelectBuilder $builder)
    {
        $this->db = $db;
        $this->builder = $builder;
    }

    public function where(string $where, array $brings = [])
    {
        $this->builder->addWhere($where);
        $this->brings = $brings + $this->brings;

        return $this;
    }

    public function limit(int $shift, ?int $cnt = null)
    {
        $this->builder->limit($shift . (($cnt !== null) ? ",$cnt" : ''));

        return $this;
    }

    public function get(): array
    {
        return $this->db->select($this->builder, $this->brings);
    }
}