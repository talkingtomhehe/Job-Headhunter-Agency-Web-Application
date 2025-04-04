<?php
class Job {
    private $db;

    public function __construct() {
        require_once APP_PATH . '/config/database.php';
        $this->db = new Database();
    }

    public function getTotalJobs($company_id = null, $search_query = '', $job_type = '') {
        $sql = "SELECT COUNT(*) as total FROM job_posts WHERE status = 'active'";
        $params = [];

        if ($company_id) {
            $sql .= " AND company_id = ?";
            $params[] = $company_id;
        }

        if ($search_query) {
            $sql .= " AND (title LIKE ? OR description LIKE ? OR requirements LIKE ?)";
            $search_term = "%{$search_query}%";
            $params = array_merge($params, [$search_term, $search_term, $search_term]);
        }

        if ($job_type) {
            $sql .= " AND job_type = ?";
            $params[] = $job_type;
        }

        $result = $this->db->query($sql, $params);
        return $result[0]['total'] ?? 0;
    }

    public function getJobs($company_id = null, $search_query = '', $page = 1, $per_page = 10, $job_type = '', $sort_by = 'newest') {
        $offset = ($page - 1) * $per_page;

        $sql = "SELECT j.*, c.company_name, c.logo_path as company_logo
                FROM job_posts j
                LEFT JOIN companies c ON j.company_id = c.company_id
                WHERE j.status = 'active'";
        $params = [];

        if ($company_id) {
            $sql .= " AND j.company_id = ?";
            $params[] = $company_id;
        }

        if ($search_query) {
            $sql .= " AND (j.title LIKE ? OR j.description LIKE ? OR j.requirements LIKE ?)";
            $search_term = "%{$search_query}%";
            $params = array_merge($params, [$search_term, $search_term, $search_term]);
        }

        if ($job_type) {
            $sql .= " AND j.job_type = ?";
            $params[] = $job_type;
        }

        // Add sorting
        switch ($sort_by) {
            case 'oldest':
                $sql .= " ORDER BY j.created_at ASC";
                break;
            case 'salary_high':
                $sql .= " ORDER BY j.salary_max DESC";
                break;
            case 'salary_low':
                $sql .= " ORDER BY j.salary_min ASC";
                break;
            default: // newest
                $sql .= " ORDER BY j.created_at DESC";
        }

        $sql .= " LIMIT ? OFFSET ?";
        $params = array_merge($params, [$per_page, $offset]);

        return $this->db->query($sql, $params);
    }

    public function getJobTypes() {
        $sql = "SELECT DISTINCT job_type FROM job_posts WHERE status = 'active' ORDER BY job_type ASC";
        $results = $this->db->query($sql);
        return array_column($results, 'job_type');
    }

    public function getJobCategories($company_id = null) {
        $sql = "SELECT DISTINCT job_category FROM job_posts WHERE job_category IS NOT NULL";
        $params = [];

        if ($company_id) {
            $sql .= " AND company_id = ?";
            $params[] = $company_id;
        }

        $sql .= " ORDER BY job_category ASC";
        $results = $this->db->query($sql, $params);
        return array_column($results, 'job_category');
    }
}