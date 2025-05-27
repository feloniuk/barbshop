<?php


class JobPosting
{
   private object $job;

   public function __construct(object $job)
   {
        $this->setJob($job);
   }

   public function setJob(object $job)
   {
       $this->job = $job;
   }

   public function getJob() : object
   {
       return $this->job;
   }

    /**
     * recommended properties to add: baseSalary.
     * Use address for JobLocation like:
     * "address": {
            "@type": "PostalAddress",
            "addressLocality": "London",
            "addressCountry": "GB" // ISO 3166-1 alpha-2 country code
        }
     * include json structure
     */
   public function includeStructure()
   {
       $job = $this->getJob();
       $datePosted = $this->getDatePosted();
       $dateExpired = $this->getDateExpired();
       $employmentType = $this->getEmploymentType();
       require_once _SYSDIR_ . 'system/inc/googleStructure/views/_job_posting.php';
   }

    /**
     * get date posted.Format should be Y-m-d (ISO 8601)
     * @return false|string
     */
   private function getDatePosted()
   {
       return date("Y-m-d", $this->getJob()->time);
   }

    /**
     * get date expired.Format should be Y-m-d (ISO 8601)
     * @return false|string
     */
    private function getDateExpired()
    {
        return date("Y-m-d", $this->getJob()->time_expire);
    }

    /**
     * get employment type. allowed values: FULL_TIME, TEMPORARY, PART_TIME
     * @return string
     */
    private function getEmploymentType()
    {
        switch (strtolower($this->getJob()->contract_type)) {
            case 'temporary':
                return 'TEMPORARY';
            case 'contract':
                return 'PART_TIME';
            default: //for permanent
                return 'FULL_TIME';

        }
    }
}