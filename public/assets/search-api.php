<?php
error_reporting(0);
ini_set('display_errors', 0);

$rootPath = $_SERVER['DOCUMENT_ROOT'] . '/huntly';

require_once $rootPath . '/app/config/config.php';
require_once $rootPath . '/app/config/Database.php';

use config\Database;

header('Content-Type: application/json');
$response = ['status' => 'error', 'data' => []];

try {
    $database = new Database();

    // find companies and jobs
    if (isset($_POST['query'])) {
        $q = $_POST['query'];

        // find companies
        $database->query("SELECT company_id, company_name FROM companies WHERE company_name LIKE :query LIMIT 5");
        $database->bind(':query', $q . '%');
        $companies = $database->resultSet();
        $formattedCompanies = [];
        foreach ($companies as $company) {
            $formattedCompanies[] = [
                'id' => $company['company_id'],
                'name' => $company['company_name'],
                'type' => 'company'
            ];
        }

        // find jobs
        $database->query("SELECT job_id, title FROM job_posts WHERE title LIKE :query LIMIT 5");
        $database->bind(':query', $q . '%');
        $jobs = $database->resultSet();
        $formattedJobs = [];
        foreach ($jobs as $job) {
            $formattedJobs[] = [
                'id' => $job['job_id'],
                'name' => $job['title'],
                'type' => 'job'
            ];
        }

        $response = [
            'status' => 'success',
            'data' => array_merge($formattedCompanies, $formattedJobs)
        ];
    }

    // find job locations
    else if (isset($_POST['location'])) {
        $location = $_POST['location'];

        $database->query("SELECT DISTINCT location FROM job_posts WHERE location LIKE :location LIMIT 5");
        $database->bind(':location', $location . '%');
        $locations = $database->resultSet();

        $formattedLocations = [];
        foreach ($locations as $loc) {
            $formattedLocations[] = [
                'id' => urlencode($loc['location']),
                'name' => $loc['location'],
                'type' => 'location'
            ];
        }

        $response = [
            'status' => 'success',
            'data' => $formattedLocations
        ];
    }
} catch (Exception $e) {
    error_log("Search API Error: " . $e->getMessage());
    $response = [
        'status' => 'error',
        'message' => 'Error occurred: ' . $e->getMessage(),
        'error_code' => $e->getCode()
    ];
}

echo json_encode($response);
exit;
