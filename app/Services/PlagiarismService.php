<?php

namespace App\Services;

use App\Project;

class PlagiarismService
{
    public $api;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $config = [
            'apiUrl' => 'https://plagiarismsearch.com/api/v3',
            'apiUser' => config('services.plagiarism.api_user'),
            'apiKey' => config('services.plagiarism.api_key'),
        ];

        $this->api = new \Reports($config);
    }

    public function checkProjects()
    {
        $data = [
            'text' => 'PlagiarismSearch.com – advanced online plagiarism checker available 24/7. PlagiarismSearch.com is a leading plagiarism checking website that will provide you with an accurate report during a short timeframe. Prior to submitting your home assignments, run them through our plagiarism checker to make sure your content is authentic.'
        ];

        echo $this->api->createAction($data);
    }

    public function plagiarismComResult(Project $project, $result)
    {

    }
}
