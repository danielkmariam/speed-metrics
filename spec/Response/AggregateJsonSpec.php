<?php

namespace spec\Response;

use ApiClient\DataPointService;
use PhpSpec\ObjectBehavior;
use Repository\MetricsRepository;

class AggregateJsonSpec extends ObjectBehavior
{
    function let(DataPointService $dataPointService, MetricsRepository $repository)
    {
        $this->beConstructedWith($dataPointService, $repository);
    }

    /**
     * @param DataPointService $dataPointService
     */
    function is_saves_aggregate_data_to_database(DataPointService $dataPointService) {
        $jsonData = '[{
            "unit_id": 1,
            "metrics": {
              "download": [
                {
                  "timestamp": "2017-02-10 17:00:00",
                  "value": 4670170
                },
                {
                  "timestamp": "2017-02-10 18:00:00",
                  "value": 4670000
                }
              ],
              "upload": [
                {
                  "timestamp": "2017-02-28 17:00:00",
                  "value": 1214720
                }
              ],
              "latency": [
                {
                  "timestamp": "2017-02-22 16:00:00",
                  "value": 44868
                }
              ],
              "packet_loss": [
                {
                  "timestamp": "2017-02-08 05:00:00",
                  "value": 0.12
                }
              ]
            }
        }]';

        $response = \GuzzleHttp\json_decode($jsonData);
        $dataPointService->get()->willReturn($response);

        $this->aggregate();
    }
}
