<?php
require _SYSDIR_ . 'system/lib/vendor/autoload.php';

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\OrderBy;
use Google\Analytics\Data\V1beta\OrderBy\DimensionOrderBy;

class AnalyticsController extends Controller
{
    protected $layout = 'layout_panel';

    use Validator;

    public function indexAction()
    {
//        if ($this->startValidation()) {
//            $this->validatePost('view_id',          'View ID',          'required|trim|min_length[1]');
//            $this->validatePost('credentials_json', 'Credentials JSON', 'required|trim|min_length[1]');
//
//            if ($this->isValid()) {
//                // View ID
//                SettingsModel::set('analytics_view_id', post('view_id'));
//
//                // Credentials JSON
//                SettingsModel::set('analytics_credentials_json', post('credentials_json'));
//
//                Request::addResponse('func', 'noticeSuccess', 'Saved');
//                Request::endAjax();
//            } else {
//                if (Request::isAjax())
//                    Request::returnErrors($this->validationErrors);
//            }
//        }
//
//        // Values
//        $this->view->view_id          = SettingsModel::get('analytics_view_id');
//        $this->view->credentials_json = SettingsModel::get('analytics_credentials_json');

        Request::setTitle('Google Analytics');
    }


    public function refersAction()
    {
        $this->view->list = Model::fetchAll(Model::select('refer_friend', " `deleted` = 'no' ORDER BY `time`"));

        Request::setTitle('Uploaded CVs');
    }

    public function export_dataAction()
    {
        Request::ajaxPart();

        $data = Model::fetchAll(Model::select('refer_friend'));

        if (is_array($data) && count($data) > 0) {
            // Prepare data
            $dataToCsv = [];
            $i = 0;
            foreach ($data as $item) {
                $dataToCsv[$i]['id'] = $item->id;
                $dataToCsv[$i]['name'] = $item->name;
                $dataToCsv[$i]['email'] = $item->email;
                $dataToCsv[$i]['tel'] = $item->tel;
                $dataToCsv[$i]['friend_name'] = $item->name;
                $dataToCsv[$i]['friend_email'] = $item->email;
                $dataToCsv[$i]['friend_tel'] = $item->tel;
                $dataToCsv[$i]['date submitted'] = date('m.d.Y', $item->time);
                $dataToCsv[$i]['cv link'] = SITE_NAME . _SITEDIR_ . 'data/cvs/' . $item->cv;
                $i++;
            }

            $df = fopen("app/data/tmp/export.csv", 'w');
            fputcsv($df, array_keys(reset($dataToCsv)), ';');
            foreach ($dataToCsv as $row)
                fputcsv($df, $row, ';');
            fclose($df);

            Request::addResponse('func', 'downloadFile', _SITEDIR_ . 'data/tmp/export.csv');
            Request::endAjax();
        } else {
            Request::returnError('No Data');
        }
    }

    public function include_codeAction()
    {
        if ($this->startValidation()) {
            $this->validatePost('include_code_top',     'Include Code Header',  'trim|min_length[1]');
            $this->validatePost('include_code_bottom',  'Include Code Footer',  'trim|min_length[1]');

            if ($this->isValid()) {
                SettingsModel::set('include_code_top',      post('include_code_top', 'string')); // Include JS Code Top
                SettingsModel::set('include_code_bottom',   post('include_code_bottom', 'string')); // Include JS Code Bottom

                Request::addResponse('func', 'noticeSuccess', 'Saved');
                Request::endAjax();
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        $this->view->include_code_top = SettingsModel::get('include_code_top');
        $this->view->include_code_bottom = SettingsModel::get('include_code_bottom');

        Request::setTitle('Include JS code');
    }

    public function ajaxAction()
    {
        Request::ajaxPart();

        $source = Request::getUri(0);
        if (!$source) $source = NULL;

        $view_id          = SettingsModel::get('analytics_view_id');
        $credentials_json = file_exists('app/data/cache/credentials.json') ? read('app/data/cache/credentials.json') : false;


        if (!$credentials_json || empty($credentials_json)) {
            Request::returnError('Analytics module will not work without login credentials - to get credentials use instruction here - https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php and save at Configure page.');
        } else {
            $credentials = json_decode(reFilter($credentials_json), TRUE);

            if (!$credentials) {
                Request::returnError('Analytics module will not work without CORRECT login credentials -  to get credentials use instruction here - https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php and save at Configure page.');
            } else {

                if (!$view_id || !isset($view_id) || empty($view_id)) {
                    Request::returnError('Analytics module will not work without View ID - get it at Developers Console and save at Configure page.');
                } else {

                    try {
                        putenv("GOOGLE_APPLICATION_CREDENTIALS=app/data/cache/credentials.json");

                        $client = new BetaAnalyticsDataClient();

                        switch ($source) {
                            case 'new_users':

//                                $response = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'date']), new Dimension(['name' => 'newVsReturning'])], [new Metric(['name' => 'activeUsers'])]);
//                                $response = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'date'])], [new Metric(['name' => 'activeUsers'])]);
//                                $response2 = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'date'])], [new Metric(['name' => 'newUsers'])]);


                                [$response, $response2] = $this->runGAUsersReport($client, $view_id);

                                //todo mb redo?
                                if ($response2[date('Ymd')]) {
                                    unset($response2[date('Ymd')]);
                                }

                                //todo mb redo?
                                if ($response[date('Ymd')]) {
                                    unset($response[date('Ymd')]);
                                }

                                $users = $this->processDimensionData($response, 'date', 'users');
                                $newUsers = $this->processDimensionData($response2, 'date', 'new_users');

                                // sorting
                                $users = sortArrayByDate($users);
                                $newUsers = sortArrayByDate($newUsers);

                                $dataResponse = [];

                                if ($users && $newUsers) {

                                    for ($i = 0; $i < count($users); $i++) {
                                        $dataResponse['returning'][] = [
                                            'date' => $users[$i]['date'],
                                            'users' => $users[$i]['users'],
                                        ];

                                        if (isset($newUsers[$i]['date'])) {
                                            $dataResponse['new'][] = [
                                                'date' => $newUsers[$i]['date'],
                                                'users' => $newUsers[$i]['new_users'],
                                            ];
                                        }
                                    }
                                }

                                break;
                            case 'devices':
                                $response = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'deviceCategory'])], [new Metric(['name' => 'sessions'])]);

                                $devices = $this->processDimensionData($response, 'base', 'ga:visits');

                                $dataResponse = $devices;

                                break;
                            case 'country':
                                $response = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'country'])], [new Metric(['name' => 'sessions'])], null, 10);

                                $countries = $this->processDimensionData($response, 'base', 'ga:visits');

                                $dataResponse = $countries;

                                break;
                            case 'sources':
                                $response = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'sessionSource'])], [new Metric(['name' => 'sessions'])], null, 10);

                                $sources = $this->processDimensionData($response, 'base', 'ga:visits');

                                $dataResponse = $sources;

                                break;
                            case 'top':
                                $response = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'pagePath'])], [new Metric(['name' => 'sessions'])], null, 10);

                                $tops = $this->processDimensionData($response, 'path', 'pageviews');

                                $dataResponse = $tops;

                                break;
                            case 'bounceRate':
                                $response = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'pagePath'])], [new Metric(['name' => 'bounceRate'])], ["desc" => false, "metric" => ["metricName" => 'bounceRate']], 10);

                                $bounceRates = $this->processDimensionData($response, 'path', 'bounceRate');

                                $dataResponse = $bounceRates;

                                break;
                            case 'avgSessionDuration':
                                $response = $this->runGAReport($client, $view_id, [new Dimension(['name' => 'pagePath'])], [new Metric(['name' => 'averageSessionDuration'])], null, 10);

                                $avg = $this->processDimensionData($response, 'path', 'avgSessionDuration');

                                $dataResponse = $avg;

                                break;
                            default:
                                $dataResponse = [];

                                break;
                        }
                    } catch (Exception $e) {
                        Request::returnError($e->getMessage());
                    }
                }
            }
        }

        header("Content-type:application/json");
        echo json_encode($dataResponse);
        exit;
    }

    /**
     * @param $client
     * @param $property_id
     * @param $dimensions
     * @param $metrics
     * @param $orderBy
     * @param $limit
     * @return array
     */
    function runGAReport($client, $property_id, $dimensions, $metrics, $orderBy = null, $limit = null) {
        $response = $client->runReport([
            'property' => 'properties/' . $property_id,
            'dateRanges' => [
                new DateRange([
                    'start_date' => date('Y-m-d', time() - 3600 * 24 * 365),
                    'end_date' => 'today',
                ]),
            ],
            'dimensions' => $dimensions,
            'metrics' => $metrics,
            'orderBy' => $orderBy,
            'limit' => $limit,
        ]);

        $data = [];

        if ($response) {
            foreach ($response->getRows() as $row) {
                $data[$row->getDimensionValues()[0]->getValue()] = $row->getMetricValues()[0]->getValue();
            }
        }

        return $data;
    }


    function runGAUsersReport($client, $property_id) {
        $response = $client->runReport([
            'property' => 'properties/' . $property_id,
            'dateRanges' => [
                new DateRange([
                    'start_date' => date('Y-m-d', time() - 3600 * 24 * 365),
                    'end_date' => 'today',
                ]),
            ],
            'dimensions' => [new Dimension(['name' => 'date']), new Dimension(['name' => 'newVsReturning'])],
            'metrics' => [new Metric(['name' => 'activeUsers'])],
            'orderBy' => [
                new OrderBy([
                    'dimension' => new DimensionOrderBy([
                        'dimension_name' => 'date',
                    ]),
                ])
            ]
        ]);

        $dataNew = [];
        $dataReturning = [];

        if ($response) {
            foreach ($response->getRows() as $row) {
                if ($row->getDimensionValues()[1]->getValue() === 'new') {
                    $dataNew[$row->getDimensionValues()[0]->getValue()] = $row->getMetricValues()[0]->getValue();
                } elseif ($row->getDimensionValues()[1]->getValue() === 'returning') {
                    $dataReturning[$row->getDimensionValues()[0]->getValue()] = $row->getMetricValues()[0]->getValue();
                }
            }
        }

        return [$dataReturning, $dataNew];
    }

    /**
     * @param $data
     * @param $dimensionKey
     * @param $metricKey
     * @return array
     */
    function processDimensionData($data, $dimensionKey, $metricKey) {
        $dataResponse = [];
        if ($data) {
            $i = 0;
            foreach ($data as $k => $value) {
                $dataResponse[$i][$dimensionKey] = $k;
                $dataResponse[$i][$metricKey] = $value;
                $i++;
            }
        }

        return $dataResponse;
    }
}
/* End of file */