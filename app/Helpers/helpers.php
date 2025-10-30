<?php

if (!function_exists('getStatusBadgeClass')) {
    /**
     * Get Tailwind CSS classes for status badges
     */
    function getStatusBadgeClass($status, $type = 'opportunity')
    {
        if ($type === 'opportunity') {
            return match($status) {
                'Active' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                'Paused' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                'Completed' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                'Cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
            };
        }
        
        if ($type === 'verification') {
            return match($status) {
                'Verified' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                'Pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                'Rejected' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
            };
        }
        
        if ($type === 'application') {
            return match($status) {
                'Accepted' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                'Pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                'Under Review' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                'Rejected' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                'Withdrawn' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                default => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'
            };
        }
        
        return 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
    }
}

if (!function_exists('getStatusIcon')) {
    /**
     * Get icon for status
     */
    function getStatusIcon($status, $type = 'opportunity')
    {
        if ($type === 'opportunity') {
            return match($status) {
                'Active' => 'fa-check-circle',
                'Paused' => 'fa-pause-circle',
                'Completed' => 'fa-check-double',
                'Cancelled' => 'fa-times-circle',
                default => 'fa-circle'
            };
        }
        
        if ($type === 'application') {
            return match($status) {
                'Accepted' => 'fa-check-circle',
                'Pending' => 'fa-clock',
                'Under Review' => 'fa-eye',
                'Rejected' => 'fa-times-circle',
                'Withdrawn' => 'fa-undo',
                default => 'fa-circle'
            };
        }
        
        return 'fa-circle';
    }
}

if (!function_exists('formatDate')) {
    /**
     * Format date for display
     */
    function formatDate($date, $format = 'M d, Y')
    {
        if (!$date) return 'N/A';
        
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('formatDateTime')) {
    /**
     * Format datetime for display
     */
    function formatDateTime($datetime, $format = 'M d, Y H:i')
    {
        if (!$datetime) return 'N/A';
        
        return \Carbon\Carbon::parse($datetime)->format($format);
    }
}

if (!function_exists('timeAgo')) {
    /**
     * Get human readable time difference
     */
    function timeAgo($datetime)
    {
        if (!$datetime) return 'N/A';
        
        return \Carbon\Carbon::parse($datetime)->diffForHumans();
    }
}