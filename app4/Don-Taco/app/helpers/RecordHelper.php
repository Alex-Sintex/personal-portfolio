<?php

namespace App\Helpers;

use App\Libraries\Base;

class RecordHelper
{
    /**
     * Checks if a record already exists for a given table and field value.
     *
     * @param string $table        The table name to check
     * @param string $field        The column name to check
     * @param mixed  $value        The value to look for
     * @param int|null $excludeId  Optional: if given, will exclude this id (useful on updates)
     * @param string  $idField     Optional: primary key field name, default 'id'
     * @return bool
     */
    public static function exists(
        string $table,
        string $field,
        $value,
        ?int $excludeId = null,
        string $idField = 'id'
    ): bool {
        $db = new Base();

        $sql = "SELECT COUNT(*) as total FROM {$table} WHERE {$field} = :value";
        $params = ['value' => $value];

        if (!is_null($excludeId)) {
            $sql .= " AND {$idField} != :excludeId";
            $params['excludeId'] = $excludeId;
        }

        $db->query($sql);
        $db->bindMultiple($params);
        $result = $db->record();

        return ($result && $result->total > 0);
    }
}
