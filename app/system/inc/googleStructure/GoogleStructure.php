<?php

include _SYSDIR_ . 'system/inc/googleStructure/JobPosting.php';

class GoogleStructure
{
    /**
     * @param string $type
     * @param object $object
     */
    public static function get(string $type, object $object)
    {
        switch ($type) {
            case 'job':
                self::jobPosting($object);
        }
    }

    /**
     * @param object $object
     */
    private static function jobPosting(object $object)
    {
        $jobPosting = new JobPosting($object);
        $jobPosting->includeStructure();
    }
}