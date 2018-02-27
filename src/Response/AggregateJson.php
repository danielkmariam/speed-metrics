<?php

namespace Response;

use ApiClient\DataPointService;
use Repository\MetricsRepository;

class AggregateJson
{
    /**
     * @var DataPointService
     */
    private $dataPointService;

    /**
     * @var MetricsRepository
     */
    private $repository;

    /**
     * @param DataPointService  $dataPointService
     * @param MetricsRepository $repository
     */
    public function __construct(DataPointService $dataPointService, MetricsRepository $repository)
    {
        $this->dataPointService = $dataPointService;
        $this->repository = $repository;
    }

    /**
     *  Aggregate response data and store to db
     */
    public function aggregate()
    {
        $dataSet = $this->dataPointService->get();
        $decoded = \GuzzleHttp\json_decode($dataSet);

        foreach ($decoded as $decode) {
            $this->saveDownloadData($decode);
            $this->saveUploadData($decode);
            $this->saveLatencyData($decode);
            $this->savePacketLossData($decode);
        }
    }

    /**
     * @param $decode
     */
    private function saveDownloadData($decode)
    {
        foreach ($decode->metrics->download as $download) {
            $this->repository->persist(MetricsRepository::DOWNLOAD_TABLE, [
                'unit_id' => $decode->unit_id,
                'timestamp' => sprintf("'%s'", $download->timestamp),
                'value' => $download->value,
            ]);
        }
    }

    /**
     * @param $decode
     */
    private function saveUploadData($decode)
    {
        foreach ($decode->metrics->upload as $upload) {
            $this->repository->persist(MetricsRepository::UPLOAD_TABLE, [
                'unit_id' => $decode->unit_id,
                'timestamp' => sprintf("'%s'", $upload->timestamp),
                'value' => $upload->value,
            ]);
        }
    }
    /**
     * @param $decode
     */
    private function saveLatencyData($decode)
    {
        foreach ($decode->metrics->latency as $latency) {
            $this->repository->persist(MetricsRepository::LATENCY_TABLE, [
                'unit_id' => $decode->unit_id,
                'timestamp' => sprintf("'%s'", $latency->timestamp),
                'value' => $latency->value,
            ]);
        }
    }

    /**
     * @param $decode
     */
    private function savePacketLossData($decode)
    {
        foreach ($decode->metrics->packet_loss as $packetLoss) {
            $this->repository->persist(MetricsRepository::PACKET_LOSS_TABLE, [
                'unit_id' => $decode->unit_id,
                'timestamp' => sprintf("'%s'", $packetLoss->timestamp),
                'value' => $packetLoss->value,
            ]);
        }
    }

}
