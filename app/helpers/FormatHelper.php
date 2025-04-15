<?php
namespace helpers;

class FormatHelper {
    public static function formatSalary($min, $max) {
        if (empty($min) && empty($max)) {
            return 'Negotiable';
        }
        
        if (empty($min)) {
            return 'Up to $' . number_format($max);
        }
        
        if (empty($max)) {
            return 'From $' . number_format($min);
        }
        
        return '$' . number_format($min) . ' - $' . number_format($max);
    }
    
    public static function timeAgo($datetime) {
        $timestamp = strtotime($datetime);
        $difference = time() - $timestamp;
        
        if ($difference < 60) {
            return 'just now';
        } elseif ($difference < 3600) {
            $minutes = round($difference / 60);
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 86400) {
            $hours = round($difference / 3600);
            return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 604800) {
            $days = round($difference / 86400);
            return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
        } elseif ($difference < 2592000) {
            $weeks = round($difference / 604800);
            return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
        } else {
            return date('M j, Y', $timestamp);
        }
    }

    public static function formatDate($datetime, $format = 'F j, Y') {
        if (empty($datetime)) {
            return 'N/A';
        }
        
        $timestamp = strtotime($datetime);
        return date($format, $timestamp);
    }

    public static function formatDateTime($datetime) {
        if (empty($datetime)) {
            return 'N/A';
        }
        
        $timestamp = strtotime($datetime);
        return date('F j, Y \a\t g:i a', $timestamp);
    }
}