<?php
namespace helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
    private $mailer;
    
    public function __construct() {
        // Create a new PHPMailer instance
        $this->mailer = new PHPMailer(true);
        
        // Configure SMTP settings
        $this->mailer->isSMTP();
        $this->mailer->Host = SMTP_HOST;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = SMTP_USERNAME;
        $this->mailer->Password = SMTP_PASSWORD;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = SMTP_PORT;
        
        // Set default sender
        $this->mailer->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        
        // Set UTF-8 charset
        $this->mailer->CharSet = 'UTF-8';
    }
    
    public function sendVerificationEmail($email, $name, $verificationToken) {
        try {
            // Set email recipient
            $this->mailer->addAddress($email, $name);
            
            // Set email content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Verify Your Huntly Account';
            
            // Build verification link
            $verificationLink = SITE_URL . '/auth/verify/' . $verificationToken;
            
            // Email body
            $this->mailer->Body = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <div style="background-color: #0631BC; padding: 20px; text-align: center;">
                        <h1 style="color: white; margin: 0;">Welcome to Huntly!</h1>
                    </div>
                    <div style="padding: 20px; border: 1px solid #ddd; border-top: none;">
                        <p>Hello ' . htmlspecialchars($name) . ',</p>
                        <p>Thank you for registering with Huntly! To complete your registration, please verify your email address by clicking the button below:</p>
                        
                        <div style="text-align: center; margin: 30px 0;">
                            <a href="' . $verificationLink . '" style="background-color: #0631BC; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">Verify Your Email</a>
                        </div>
                        
                        <p>Or copy and paste this link into your browser:</p>
                        <p style="word-break: break-all;"><a href="' . $verificationLink . '">' . $verificationLink . '</a></p>
                        
                        <p>This link will expire in 24 hours.</p>
                        
                        <p>If you did not create an account, no further action is required.</p>
                        
                        <p>Best regards,<br>The Huntly Team</p>
                    </div>
                </div>
            ';
            
            // Plain text alternative
            $this->mailer->AltBody = "Hello " . $name . ",\n\nThank you for registering with Huntly! To complete your registration, please verify your email address by visiting this link:\n\n" . $verificationLink . "\n\nThis link will expire in 24 hours.\n\nIf you did not create an account, no further action is required.\n\nBest regards,\nThe Huntly Team";
            
            // Send the email
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        } finally {
            // Clear all recipients for next send
            $this->mailer->clearAddresses();
        }
    }
}