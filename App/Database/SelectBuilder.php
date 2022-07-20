<?php

namespace System\Database;

use Exception;

class SelectBuilder
{
    public string $table;
    protected array $fields = ['*'];

    protected array $addons = [
        'join' => null,
        'where' => null,
        'group_by' => null,
        'having' => null,
        'order_by' => null,
        'limit' => null
    ];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function fields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    public function addWhere(string $where)
    {
        $this->addons['where'] .= ' ' . $where;

        return $this;
    }

    public function __toString()
    {
        $activeCommands = [];

        foreach ($this->addons as $command => $setting) {
            if ($setting !== null) {

                $sqlKey = str_replace('_', ' ', strtoupper($command));
                $activeCommands[] = "$sqlKey $setting";
            }
        }

        $fields = implode(', ', $this->fields);
        $addon = implode(' ', $activeCommands);

        return trim("SELECT $fields FROM {$this->table} $addon");
    }

    public function __call($name, $args)
    {
        if (!array_key_exists($name, $this->addons)) {
            throw new Exception('sql error unknown');
        }

        $this->addons[$name] = $args[0];

        return $this;
    }
}