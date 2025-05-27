<?php

final class ImageAlts
{
    /**
     * @param string $fieldName
     * @param string $load
     * @param $defaultImageValue
     * @param string $pathDir
     * @param bool $valueAlt
     * @param string $title
     * @return string
     */
    public static function createField(string $fieldName, string $load, $defaultImageValue, string $pathDir, $valueAlt = false, string $title = 'Image'): string
    {
        $fullLoad = $load . ", 'preview=#preview_image_$fieldName'";
        //todo move to php file
        $html = "
        <label for=\"image\">$title<small><i>(Image files must be under " . file_current_max_size() . ", and JPG, GIF or PNG format)</i></small></label>
        <div class=\"choose-file modern\">
            <input type=\"hidden\" name=\"$fieldName\" id=\"$fieldName\" value=\"" . post($fieldName, false, $defaultImageValue) . "\">
             <a class=\"file-fake\" onclick=\"load($fullLoad)\" style=\"cursor: pointer;\">
             <i class=\"fas fa-folder-open\"></i>Choose image</a>
            <div id=\"preview_image_$fieldName\" class=\"preview_image\">
                <img src=\"" . $pathDir . post($fieldName, false, $defaultImageValue) . "\" alt=''>
            </div>
        </div>
        <input class='form-control' type='text' name='alt_attributes[$fieldName]' value='$valueAlt' placeholder='Alt attribute'>
        ";

        return $html;
    }

    public static function createFieldCustom(string $fieldName, string $load, $defaultImageValue, string $pathDir, $valueAlt = false, string $title = 'Image'): string
    {
        $fullLoad = $load . ", 'preview=#preview_image_$fieldName'";
        //todo move to php file
        $html = "
        <label for=\"image\">$title<small><i>(Image files must be under " . file_current_max_size() . ", and JPG, GIF or PNG format)</i></small></label>
        <div class=\"choose-file modern\">
            <input type=\"hidden\" name=\"$fieldName\" id=\"$fieldName\" value=\"" . post($fieldName, false, $defaultImageValue) . "\">
             <a class=\"file-fake\" onclick=\"load($fullLoad)\" style=\"cursor: pointer;\">
             <i class=\"fas fa-folder-open\"></i>Choose image</a>
            <div id=\"preview_image_$fieldName\" class=\"preview_image\">
                <img src=\"" . $pathDir . post($fieldName, false, $defaultImageValue) . "\" alt=''>
            </div>
        </div>
        ";

        return $html;
    }

    /**
     * @param $alts
     * @param string $table
     * @param int $id
     */
    public static function saveAlts($alts, string $table, int $id): void
    {
        Model::delete('alt_attributes', " `entity` = '$table' AND `entity_id` = $id");
        if ($alts) {
            $sql = "INSERT INTO `alt_attributes`(`entity`, `entity_id`, `field_name`, `alt`) VALUES ";

            foreach ($alts as $field => $alt) {
                $sql .= "('$table', $id, '$field', '$alt'),";
            }

            $sql = rtrim($sql, ',');

            Model::query($sql);
        }
    }

    /**
     * @param string $table
     * @param int $id
     * @return object
     */
    public static function getAlts(string $table, object $object): object
    {
        $alts = Model::fetchAll(Model::select('alt_attributes', " `entity` = '$table' AND `entity_id` = $object->id"));

        $object->alt_attributes = [];
        if ($alts) {
            foreach ($alts as $alt) {
                $object->alt_attributes[$alt->field_name] = $alt->alt;
            }
        }

        return $object;
    }

    /**
     * return array with objects that have alt attributes
     * @param string $table
     * @param array $objects
     * @return array
     */
    public static function getAltsForMany(string $table, array $objects): array
    {
        //get ids for entities
        $ids = [];
        foreach ($objects as $object) {
            $ids[] = $object->id;
        }

        $alts = Model::fetchAll(Model::select('alt_attributes', " `entity` = '$table' AND `entity_id` IN (" . implode(',', $ids) . ")"));
        if ($alts) {
            foreach ($objects as $object) {
                $object->alt_attributes = [];
                foreach ($alts as $alt) {
                    if ($object->id === $alt->entity_id)
                        $object->alt_attributes[$alt->field_name] = $alt->alt;
                }
            }
        }

        return $objects;
    }
}
