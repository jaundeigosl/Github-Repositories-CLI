<?php

require_once __DIR__ . "/autoload.php";

use app\Exceptions\ValidationException;
use app\Others\Date;
use app\Validators\Validator;
use app\Api\ApiConnection;

echo "Welcome to the Github Repositories CLI \n";
echo "This script will allow you to consult the trending repositories on Github \n";
echo "To use it you should use the following instruction:\n";
echo "trending-repos --duration {day,week,month or year} --limit {between 1 and 20} \n";
echo "If not specified the duration or limit , it would use the default values, being the duration a week and the limit 10 repositories \n\n";
echo "Please enter the command:\n\n";

$input = trim(fgets(STDIN));

$input_array = explode(" ", $input);

$date = new Date();
$validator = new Validator();
$apiConnection = new ApiConnection(); 

$default_attributes = [
    "duration" => DEFAULT_RANGE,
    "limit" => DEFAULT_LIMIT
];

$used_inputs = [];

$user_input_attributes =[];

$size = count($input_array);


try{

    if($size > 0 && $input_array[0] == VALID_INPUTS["base-action"]){

        //Attribute validation

        for($i = 1; $i < $size ; $i = $i + 2){

            $key = substr($input_array[$i], 2);

            if(($key == VALID_INPUTS["attribute-duration"] || $key == VALID_INPUTS["attribute-limit"]) && !in_array($key, $used_inputs)){

                $used_inputs[] = $key;

                if(isset($input_array[$i+1])){
                    $user_input_attributes[$key] = $input_array[$i+1];
                }
                else{
                    throw new ValidationException("There is no value to the attribute : " . $input_array[$i] . "\n" );
                }

            }else{

                throw new ValidationException("Invalid attribute: typing error in " . $input_array[$i] . "\n");
            }
        }

    }else{
        throw new ValidationException("Invalid input: typing error in trending-repos \n");
    }

    $final_attributes = array_merge($default_attributes, $user_input_attributes);

    //Attribute value validation

    $time_range_validation = $validator->validTimeRange($final_attributes['duration']);
    $limit_validation = $validator->validLimit($final_attributes["limit"]);

    if(!$time_range_validation ){
        throw new ValidationException("Invalid input: error in attribute value --duration " .  $final_attributes["duration"] . "\n");
    }

    if(!$limit_validation){
        throw new ValidationException("Invalid input: error in attribute value --limit " .  $final_attributes["limit"] . "\n");
    }

    //Getting a valid time range

    $valid_range = $date->setDateRange($final_attributes["duration"]);

    //Making the request

    $request_result = $apiConnection->requestRepositories($valid_range , $final_attributes['limit']);
    
    if(!$request_result){
        throw new ValidationException("An error occurred while connecting to Github \n");
    }

    $json_response = json_decode($request_result, true);

    //Creating the response structure

    if(!(is_array($json_response) && isset($json_response["items"]))){
        throw new ValidationException("An error occurred, bad response from Github");
    }

    $repositories = $json_response["items"];
    $responses = [];

    foreach($repositories as $repository){

        $responses[] = [
            "repo" => "Repository name: " . ($repository["name"] ?? "Not Available") . "\n",
            "author" => "Author : " . ($repository["owner"]["login"] ?? "Not Available") . "\n",
            "stars" => "Stars number: " . ($repository["stargazers_count"] ?? "Not Available") . "\n",
            "description" => "Repository description : " . ($repository["description"] ?? "Not Available") . "\n",
            "language" => "Programming Language : " . ($repository["language"] ?? "Not Available") . "\n"
        ];

    }



    echo "\nThe results are : \n\n";
    
    foreach($responses as $response){
        echo $response["repo"];
        echo $response["author"];
        echo $response["stars"];
        echo $response["description"];
        echo $response["language"];
        echo "\n";
    }

}

catch(ValidationException $e){
    echo $e->getMessage();
}

