<script type="application/ld+json">
            {
              "@context" : "https://schema.org/",
              "@type" : "JobPosting",
              "title" : "<?= reFilter($job->title); ?>",
              "description" : "<?= str_replace('"', "'", reFilter($job->content)); ?>",
              "identifier": {
                "@type": "PropertyValue",
                "name": "JobRef",
                "value": "<?= $job->ref; ?>"
              },
              "datePosted" : "<?= $datePosted; ?>",
              "validThrough" : "<?= $dateExpired;?>",
              "employmentType": "<?= $employmentType; ?>",
              "hiringOrganization" : {
                "@type" : "Organization",
                "name" : "<?= SITE_NAME ?>",
                "sameAs" : "<?= SITE_URL ?>",
                "logo" : "<?= SITE_URL ?>app/public/images/logos/am_logo.png"
              },
              "jobLocation": {
                "@type": "Place",
                "address": "<?= $job->locations[0]->name ?>"
              }
            }
</script>
