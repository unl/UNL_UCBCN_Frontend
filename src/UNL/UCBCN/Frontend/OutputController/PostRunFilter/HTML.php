<?php
namespace UNL\UCBCN\Frontend\OutputController\PostRunFilter;

class HTML
{
    public static $data;

    public static function setReplacementData($field, $data)
    {
        self::$data[$field] = $data;
    }

    public function postRun($data)
    {
        if (isset(self::$data['pagetitle'])) {
            $data = str_replace('<title>UNL Catalog</title>',
                                '<title>'.self::$data['pagetitle'].' | UNL Catalog</title>',
            $data);
        }

        return $data;
    }
}
