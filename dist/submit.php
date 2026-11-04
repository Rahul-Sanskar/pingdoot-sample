<?php
/**
 * PingDoot — Enquiry form mailer
 * Sends form submissions to rahulsanskar@glocious.com
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// ── Helpers ────────────────────────────────────────────────────────────────

function sanitize(string $value): string {
    return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
}

function is_valid_email(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// ── Collect & validate ──────────────────────────────────────────────────────

$name    = sanitize($_POST['name']    ?? '');
$email   = sanitize($_POST['email']   ?? '');
$company = sanitize($_POST['company'] ?? '');
$phone   = sanitize($_POST['phone']   ?? '');
$solution = sanitize($_POST['solution'] ?? '');
$size    = sanitize($_POST['size']    ?? '');
$message = sanitize($_POST['message'] ?? '');
$consent = isset($_POST['consent']) ? true : false;

$errors = [];

if (empty($name))                   $errors[] = 'Name is required.';
if (empty($email))                  $errors[] = 'Email is required.';
if (!is_valid_email($email))        $errors[] = 'Please provide a valid email address.';
if (empty($company))                $errors[] = 'Company name is required.';
if (!$consent)                      $errors[] = 'Consent is required.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ── Compose email ───────────────────────────────────────────────────────────

$to      = 'rahulsanskar@glocious.com';
$subject = "New PingDoot Enquiry from {$name} ({$company})";

$body  = "You have received a new enquiry via the PingDoot website.\n";
$body .= str_repeat('-', 55) . "\n\n";
$body .= "Name       : {$name}\n";
$body .= "Email      : {$email}\n";
$body .= "Company    : {$company}\n";
$body .= "Phone      : " . ($phone    ?: '—') . "\n";
$body .= "Solution   : " . ($solution ?: '—') . "\n";
$body .= "Team size  : " . ($size     ?: '—') . "\n\n";
$body .= "Message:\n{$message}\n\n";
$body .= str_repeat('-', 55) . "\n";
$body .= "Sent via pingdoot.com enquiry form\n";
$body .= "Product by RSBIZ Pvt Ltd\n";

$headers  = "From: noreply@pingdoot.com\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// ── Send ────────────────────────────────────────────────────────────────────

$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    echo json_encode([
        'success' => true,
        'message' => "Thanks {$name}! Your enquiry has been received. We'll be in touch soon."
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Sorry, there was a problem sending your message. Please try again or email us directly.'
    ]);
}
