<?php
// api/index.php - Simple API Router

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Supabase Configuration
define('SUPABASE_URL', 'https://krgnajnezqbzrbglmecf.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImtyZ25ham5lenFienJiZ2xtZWNmIiwicm9sZSI6ImFub24iLCJpYXQiOjE3ODMyMjIwNDcsImV4cCI6MjA5ODc5ODA0N30.7HKonrJMyyOgnykeolT1i9ECZ8p29KV86eAiPgLtWBA');

// Get request path
$path = $_SERVER['PATH_INFO'] ?? '/';
$path = trim($path, '/');
$path = explode('?', $path)[0];

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Get input data
$input = json_decode(file_get_contents('php://input'), true) ?? [];

// === ROUTES ===
$routes = [
    'GET' => [
        '/health' => 'handleHealth',
        '/user' => 'handleGetUser',
    ],
    'POST' => [
        '/login' => 'handleLogin',
        '/register' => 'handleRegister',
        '/logout' => 'handleLogout',
    ]
];

// Find matching route
$handler = $routes[$method]["/$path"] ?? null;

if ($handler && function_exists($handler)) {
    $handler($input);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found', 'path' => $path]);
}

// === HANDLER FUNCTIONS ===

function handleHealth($input) {
    echo json_encode([
        'status' => 'healthy',
        'timestamp' => date('Y-m-d H:i:s'),
        'database' => 'supabase'
    ]);
}

function handleLogin($input) {
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Email and password required'
        ]);
        return;
    }
    
    // Query Supabase
    $result = querySupabase('users', ['email' => $email]);
    $users = json_decode($result, true);
    
    if (empty($users) || !password_verify($password, $users[0]['password'] ?? '')) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid credentials'
        ]);
        return;
    }
    
    $user = $users[0];
    $token = bin2hex(random_bytes(32));
    
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role']
        ],
        'role' => $user['role'],
        'token' => $token
    ]);
}

function handleRegister($input) {
    $required = ['name', 'email', 'password'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => "$field is required",
                'errors' => [$field => "$field required"]
            ]);
            return;
        }
    }
    
    // Check if user exists
    $result = querySupabase('users', ['email' => $input['email']]);
    $users = json_decode($result, true);
    
    if (!empty($users)) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'message' => 'User already exists'
        ]);
        return;
    }
    
    // Insert user
    $data = [
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => password_hash($input['password'], PASSWORD_DEFAULT),
        'role' => $input['role'] ?? 'customer',
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $result = insertSupabase('users', $data);
    $response = json_decode($result, true);
    
    if (isset($response[0])) {
        echo json_encode([
            'success' => true,
            'message' => 'Registration successful',
            'user' => [
                'id' => $response[0]['id'],
                'name' => $input['name'],
                'email' => $input['email'],
                'role' => $input['role'] ?? 'customer'
            ]
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Registration failed'
        ]);
    }
}

function handleLogout($input) {
    echo json_encode([
        'success' => true,
        'message' => 'Logged out successfully'
    ]);
}

function handleGetUser($input) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    $token = str_replace('Bearer ', '', $token);
    
    // Validate token logic here
    
    echo json_encode([
        'success' => true,
        'user' => ['name' => 'Test User', 'email' => 'test@test.com']
    ]);
}

// === SUPABASE HELPER FUNCTIONS ===

function querySupabase($table, $filters = []) {
    $url = SUPABASE_URL . '/rest/v1/' . $table;
    if (!empty($filters)) {
        $query = http_build_query($filters);
        $url .= '?' . $query;
    }
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}

function insertSupabase($table, $data) {
    $ch = curl_init(SUPABASE_URL . '/rest/v1/' . $table);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Prefer: return=representation'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}