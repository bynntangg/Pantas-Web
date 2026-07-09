<?php
// api/index.php - Copy paste ini

// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-CSRF-TOKEN, X-Requested-With');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Get path
$path = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($path, PHP_URL_PATH);
$path = str_replace('/api', '', $path);
$path = trim($path, '/');

// Get input
$input = json_decode(file_get_contents('php://input'), true) ?? [];

// === ROUTES ===
switch ($path) {
    case 'health':
        echo json_encode([
            'success' => true,
            'status' => 'healthy',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        break;
        
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Login logic - selalu success untuk testing
            $email = $input['email'] ?? 'demo@test.com';
            
            echo json_encode([
                'success' => true,
                'message' => 'Login successful',
                'user' => [
                    'id' => 1,
                    'name' => 'Demo User',
                    'email' => $email,
                    'role' => 'customer'
                ],
                'role' => 'customer',
                'token' => 'demo-token-12345'
            ]);
        }
        break;
        
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo json_encode([
                'success' => true,
                'message' => 'Registration successful',
                'user' => [
                    'id' => 2,
                    'name' => $input['name'] ?? 'New User',
                    'email' => $input['email'] ?? 'new@test.com',
                    'role' => $input['role'] ?? 'customer'
                ]
            ]);
        }
        break;
        
    case 'logout':
        echo json_encode([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
        break;
        
    default:
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error' => 'Route not found',
            'path' => $path
        ]);
}