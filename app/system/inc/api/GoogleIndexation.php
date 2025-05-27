<?php

include _SYSDIR_ . 'system/lib/vendor/autoload.php';

/**
 * need download google/apiclient via composer
 * Class GoogleIndexation
 *
 * example delete: GoogleIndexation::delete(url('job/' . $this->view->edit->slug . '/'));
 * example update: GoogleIndexation::update(url('job/' . $this->view->edit->slug . '/'));
 * example batch: GoogleIndexation::batch($batchData) $batchData -> array ['http://123.com/job/123' => 'URL_UPDATED', ...]
 *
 */

class GoogleIndexation
{
    static public function update($url)
    {
       return self::action($url, 'URL_UPDATED');
    }

    static public function delete($url)
    {
        return self::action($url, 'URL_DELETED');
    }

    /**
     * $urls example ['http://123.com/job/123' => 'URL_UPDATED']
     * @param array $urls
     * @return bool
     */
    static public function batch(array $urls): bool
    {
        if (!is_array($urls))
            return false;

        try {
            $googleClient = new Google_Client();

            // Add here location to the JSON key file that you created and downloaded earlier.
            $googleClient->setAuthConfig(KEYS_FILE); // todo path to  json with keys
            $googleClient->addScope('https://www.googleapis.com/auth/indexing');
            $googleClient->setUseBatch(true);

            $service = new Google_Service_Indexing($googleClient);
            $batch = $service->createBatch();

            foreach($urls as $url => $type) {
                $postBody = new Google_Service_Indexing_UrlNotification(['url' => $url, 'type' => $type]);
                $batch->add($service->urlNotifications->publish($postBody));
            }

            $batch->execute();
            Logger("[INDEXATION SUCCESS][BATCH]", 'indexation.txt');

            return true;
        } catch (\Exception $e) {
            Logger("[GUZZLE ERROR][EXCEPTION][BATCH]", 'indexation.txt');
            return false;
        }
    }

    /**
     * @param $url
     * @param $action_type
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static private function action($url, $action_type)
    {
        try {
            $client = new Google_Client();
            $client->setAuthConfig(KEYS_FILE); // todo path to  json with keys
            $client->addScope('https://www.googleapis.com/auth/indexing');

            $httpClient = $client->authorize();
            $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';

            $content = [
                "url" => $url,
                "type" => $action_type
            ];

            $response = $httpClient->post($endpoint, ['json' => $content]);
            $status_code = $response->getStatusCode();

            if ($status_code != 200) {
                Logger("[INDEXATION ERROR][$status_code][$url]", 'indexation.txt');
                return false;
            }

            Logger("[INDEXATION SUCCESS][$status_code][$url]", 'indexation.txt');

            return true;
        } catch (\Exception $e) {
            Logger("[GUZZLE ERROR][EXCEPTION][$url]", 'indexation.txt');
            return false;
        }
    }
}
