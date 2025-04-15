<?php
namespace helpers;

use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;

class GoogleOAuth {
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $client;
    
    public function __construct() {
        require_once ROOT_PATH . '/vendor/autoload.php';

        $this->clientId = '475827883823-2unkk5kf7s1avq4gteuql468j8635u6c.apps.googleusercontent.com'; 
        $this->clientSecret = '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'; 
        $this->redirectUri = SITE_URL . '/auth/googlecallback';
        
        // Initialize Google Client
        $this->client = new Google_Client();
        $this->client->setClientId($this->clientId);
        $this->client->setClientSecret($this->clientSecret);
        $this->client->setRedirectUri($this->redirectUri);
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }
    
    public function getAuthUrl($role = 'job_seeker') {
        try {
            // Generate a state parameter to prevent CSRF
            $state = bin2hex(random_bytes(16));
            $state = $role . '|' . $state; // Include role in state
            
            // Store in session for verification
            $_SESSION['google_oauth_state'] = $state;
            
            // Set state in Google Client
            $this->client->setState($state);
            
            // Return the authorization URL
            $authUrl = $this->client->createAuthUrl();
            
            // Debug: Log the URL being generated
            error_log("Generated Google Auth URL: " . $authUrl);
            
            return $authUrl;
        } catch (\Exception $e) {
            // Log the error
            error_log("Google OAuth error: " . $e->getMessage());
            return null;
        }
    }
    
    public function getUserInfo($code) {
        try {
            // Exchange authorization code for access token
            $token = $this->client->fetchAccessTokenWithAuthCode($code);
            
            if (isset($token['error'])) {
                error_log('Google Auth Error: ' . $token['error_description'] ?? $token['error']);
                return null;
            }
            
            $this->client->setAccessToken($token);
            
            // Get profile info
            $oauth2 = new Google_Service_Oauth2($this->client);
            $userInfo = $oauth2->userinfo->get();
            
            // Create a standardized user info array
            return [
                'id' => $userInfo->getId(),
                'email' => $userInfo->getEmail(),
                'name' => $userInfo->getName(),
                'given_name' => $userInfo->getGivenName(),
                'family_name' => $userInfo->getFamilyName(),
                'picture' => $userInfo->getPicture(),
                'locale' => $userInfo->getLocale()
            ];
        } catch (\Exception $e) {
            error_log('Google OAuth Error: ' . $e->getMessage());
            return null;
        }
    }
    
    public function validateState($state) {
        $sessionState = $_SESSION['google_oauth_state'] ?? '';
        
        if (empty($state) || empty($sessionState)) {
            return [false, 'job_seeker']; // Default to job_seeker
        }
        
        // Extract role from state
        $parts = explode('|', $state, 2);
        $role = $parts[0] ?? 'job_seeker';
        
        // Convert 'employer' to 'company_admin' for database lookup
        $dbRole = $role === 'employer' ? 'company_admin' : $role;
        
        // Validate state matches
        return [$sessionState === $state, $dbRole];
    }
}