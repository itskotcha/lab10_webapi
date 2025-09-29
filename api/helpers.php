<?php
// api/helpers.php
function json_headers() {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
}
function get_json_body() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}
function product_row_to_payload($row) {
    // Match fakestore-like shape (rating nested object)
    return [
        'id' => (int)$row['id'],
        'title' => $row['title'],
        'price' => (float)$row['price'],
        'description' => $row['description'],
        'category' => $row['category'],
        'image' => $row['image'],
        'rating' => [
            'rate' => isset($row['rating_rate']) ? (float)$row['rating_rate'] : 0.0,
            'count' => isset($row['rating_count']) ? (int)$row['rating_count'] : 0,
        ]
    ];
}