<?php
function getDomainExpiry($domain) {
    $api_url = "https://api.whois.vu/?q=" . urlencode($domain);

    $response = @file_get_contents($api_url);

    if ($response === false) return null;

    $data = json_decode($response, true);

    if (isset($data['expires'])) {
        // Genelde 2026-11-01 gibi bir tarih döner
        return date('Y-m-d', strtotime($data['expires']));
    }

    return null;
}
