<?php
// api/products.php
require_once __DIR__ . '/helpers.php';
json_headers();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/config.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = isset($_SERVER['PATH_INFO']) ? trim($_SERVER['PATH_INFO'], '/') : '';
$segments = $path !== '' ? explode('/', $path) : [];

// Expected routes:
// GET    /products
// GET    /products/{id}
// POST   /products
// PUT    /products/{id}
// PATCH  /products/{id}
// DELETE /products/{id}
//
// If not using PATH_INFO (depends on Apache config), also support query string ?id=

function not_found() {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Not found']);
    exit;
}

function validate_payload($data, $partial = false) {
    $fields = ['title','price','description','category','image'];
    if ($partial) {
        return true;
    }
    foreach ($fields as $f) {
        if (!isset($data[$f])) return false;
    }
    return true;
}

function list_products($pdo) {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC");
    $rows = $stmt->fetchAll();
    $out = array_map('product_row_to_payload', $rows);
    echo json_encode($out, JSON_UNESCAPED_UNICODE);
}

function get_product($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Product not found']);
        return;
    }
    echo json_encode(product_row_to_payload($row), JSON_UNESCAPED_UNICODE);
}

function create_product($pdo, $data) {
    if (!validate_payload($data)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        return;
    }
    $stmt = $pdo->prepare("
        INSERT INTO products (title, price, description, category, image, rating_rate, rating_count)
        VALUES (:title, :price, :description, :category, :image, :rate, :count)
    ");
    $stmt->execute([
        ':title' => $data['title'],
        ':price' => $data['price'],
        ':description' => $data['description'],
        ':category' => $data['category'],
        ':image' => $data['image'],
        ':rate' => isset($data['rating']['rate']) ? $data['rating']['rate'] : 0,
        ':count' => isset($data['rating']['count']) ? $data['rating']['count'] : 0,
    ]);
    $id = $pdo->lastInsertId();
    get_product($pdo, $id);
}

function update_product($pdo, $id, $data, $partial = false) {
    // fetch current
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $cur = $stmt->fetch();
    if (!$cur) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Product not found']);
        return;
    }
    if (!$partial && !validate_payload($data)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing required fields']);
        return;
    }
    // merge
    $merged = [
        'title' => $data['title'] ?? $cur['title'],
        'price' => $data['price'] ?? $cur['price'],
        'description' => $data['description'] ?? $cur['description'],
        'category' => $data['category'] ?? $cur['category'],
        'image' => $data['image'] ?? $cur['image'],
        'rating_rate' => $data['rating']['rate'] ?? $cur['rating_rate'],
        'rating_count' => $data['rating']['count'] ?? $cur['rating_count'],
    ];
    $stmt = $pdo->prepare("
        UPDATE products SET
          title = :title,
          price = :price,
          description = :description,
          category = :category,
          image = :image,
          rating_rate = :rate,
          rating_count = :count
        WHERE id = :id
    ");
    $stmt->execute([
        ':title' => $merged['title'],
        ':price' => $merged['price'],
        ':description' => $merged['description'],
        ':category' => $merged['category'],
        ':image' => $merged['image'],
        ':rate' => $merged['rating_rate'],
        ':count' => $merged['rating_count'],
        ':id' => $id
    ]);
    get_product($pdo, $id);
}

function delete_product($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Product not found']);
        return;
    }
    echo json_encode(['success' => true, 'deleted' => (int)$id]);
}

// Simple router
// If using mod_rewrite, PATH_INFO likely looks like "products" or "products/1"
// Fallback: if ?id= is provided, use it.
$id = null;
if (!empty($segments) && $segments[0] === 'products') {
    if (count($segments) > 1 && is_numeric($segments[1])) {
        $id = (int)$segments[1];
    }
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
}

switch ($method) {
    case 'GET':
        if ($id) get_product($pdo, $id);
        else list_products($pdo);
        break;
    case 'POST':
        $data = get_json_body();
        create_product($pdo, $data);
        break;
    case 'PUT':
    case 'PATCH':
        if (!$id) not_found();
        $data = get_json_body();
        update_product($pdo, $id, $data, $partial = ($method === 'PATCH'));
        break;
    case 'DELETE':
        if (!$id) not_found();
        delete_product($pdo, $id);
        break;
    default:
        not_found();
}