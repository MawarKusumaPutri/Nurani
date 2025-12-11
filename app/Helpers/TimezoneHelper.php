<?php

namespace App\Helpers;

class TimezoneHelper
{
    /**
     * Get timezone based on IP address with fallback
     */
    public static function getTimezoneFromIP($ip)
    {
        // Default timezone
        $defaultTimezone = 'Asia/Jakarta'; // WIB
        
        // Skip for localhost or private IPs - LANGSUNG RETURN (TIDAK API CALL)
        if ($ip === '127.0.0.1' || $ip === '::1' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0 || strpos($ip, 'localhost') !== false) {
            return $defaultTimezone;
        }
        
        try {
            // Use IP geolocation service (free tier) - DENGAN TIMEOUT SANGAT PENDEK
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=timezone", false, stream_context_create([
                'http' => [
                    'timeout' => 1, // Timeout 1 detik (sangat pendek untuk tidak blocking)
                    'ignore_errors' => true
                ]
            ]));
            
            if ($response !== false) {
                $data = @json_decode($response, true);
                
                if (isset($data['timezone']) && !empty($data['timezone'])) {
                    return $data['timezone'];
                }
            }
        } catch (\Exception $e) {
            // Fallback to default - tidak throw error
        }
        
        // Fallback: Try to determine based on IP range (simplified)
        $ipLong = @ip2long($ip);
        
        if ($ipLong !== false) {
            // Indonesia timezone ranges (simplified)
            if ($ipLong >= ip2long('103.0.0.0') && $ipLong <= ip2long('103.255.255.255')) {
                return 'Asia/Jakarta'; // WIB
            } elseif ($ipLong >= ip2long('114.0.0.0') && $ipLong <= ip2long('114.255.255.255')) {
                return 'Asia/Makassar'; // WITA
            } elseif ($ipLong >= ip2long('125.0.0.0') && $ipLong <= ip2long('125.255.255.255')) {
                return 'Asia/Jayapura'; // WIT
            }
        }
        
        return $defaultTimezone;
    }

    /**
     * Get timezone abbreviation
     */
    public static function getTimezoneAbbreviation($timezone)
    {
        $abbreviations = [
            'Asia/Jakarta' => 'WIB',
            'Asia/Makassar' => 'WITA', 
            'Asia/Jayapura' => 'WIT',
            'Asia/Pontianak' => 'WIB',
            'Asia/Bandung' => 'WIB',
            'Asia/Surabaya' => 'WIB',
            'Asia/Denpasar' => 'WITA',
            'Asia/Ujung_Pandang' => 'WITA',
            'Asia/Manado' => 'WITA',
            'Asia/Palembang' => 'WIB',
            'Asia/Medan' => 'WIB',
            'Asia/Bali' => 'WITA',
            'Asia/Kupang' => 'WITA',
            'Asia/Maluku' => 'WIT',
            'Asia/Papua' => 'WIT'
        ];
        
        return $abbreviations[$timezone] ?? 'WIB';
    }

    /**
     * Get location from IP address
     */
    public static function getLocationFromIP($ip)
    {
        // Skip for localhost or private IPs - LANGSUNG RETURN (TIDAK API CALL)
        if ($ip === '127.0.0.1' || $ip === '::1' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0 || strpos($ip, 'localhost') !== false) {
            return 'Local Development';
        }
        
        try {
            // DENGAN TIMEOUT SANGAT PENDEK untuk tidak blocking
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country,regionName,city", false, stream_context_create([
                'http' => [
                    'timeout' => 1, // Timeout 1 detik (sangat pendek untuk tidak blocking)
                    'ignore_errors' => true
                ]
            ]));
            
            if ($response !== false) {
                $data = @json_decode($response, true);
                
                if (isset($data['country']) && isset($data['city'])) {
                    return $data['city'] . ', ' . $data['regionName'] . ', ' . $data['country'];
                }
            }
        } catch (\Exception $e) {
            // Fallback to default - tidak throw error
        }
        
        return 'Unknown Location';
    }

    /**
     * Get formatted time with timezone
     */
    public static function getFormattedTime($time, $timezone = null)
    {
        if ($timezone) {
            $time = $time->setTimezone($timezone);
        }
        
        $timezoneAbbr = self::getTimezoneAbbreviation($timezone ?? 'Asia/Jakarta');
        return $time->format('d M Y, H:i') . ' ' . $timezoneAbbr;
    }

    /**
     * Get all Indonesian timezones
     */
    public static function getIndonesianTimezones()
    {
        return [
            'Asia/Jakarta' => 'WIB (Waktu Indonesia Barat)',
            'Asia/Makassar' => 'WITA (Waktu Indonesia Tengah)',
            'Asia/Jayapura' => 'WIT (Waktu Indonesia Timur)'
        ];
    }

    /**
     * Get current time in all Indonesian timezones
     */
    public static function getCurrentTimeInAllZones()
    {
        $timezones = self::getIndonesianTimezones();
        $times = [];
        
        foreach ($timezones as $timezone => $label) {
            $times[$timezone] = [
                'label' => $label,
                'time' => now()->setTimezone($timezone)->format('H:i'),
                'date' => now()->setTimezone($timezone)->format('d M Y'),
                'abbr' => self::getTimezoneAbbreviation($timezone)
            ];
        }
        
        return $times;
    }
}
