<?php

namespace app\Api;

class ApiConnection{
    private $context;
    private $endpoint;
    private $query_base;
    private $query_parameters;

    public function __construct(){

        $this->context = stream_context_create(
    [
            "http" =>
                    [
                    "method" => "GET" , 
                    "header" => [
                        "Accept: application/vnd.github+json", 
                        "X-GitHub-Api-Version: 2022-11-28",
                        "User-Agent: jaundeigosl"
                        ]
                ]
            ]);

        $this->endpoint = "https://api.github.com/search/repositories";

        $this->query_base = "?q=created:>";

        $this->query_parameters = "&sort=stars&order=desc";

    }

    public function requestRepositories($date,$limit):string{
        return file_get_contents($this->endpoint . $this->query_base . $date . $this->query_parameters . "&per_page=" . $limit, false, $this->context);
    }

}


