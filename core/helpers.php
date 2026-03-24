<?php

/**
 * Global Helper Functions
 */

// -------------------------------------------------------------------------
// Security
// -------------------------------------------------------------------------

/**
 * Escape output for safe HTML rendering (XSS prevention).
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a hidden CSRF input field.
 */
function csrf_field(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return '<input type="hidden" name="csrf_token" value="' . e($_SESSION['csrf_token']) . '">';
}

// -------------------------------------------------------------------------
// URL Helpers
// -------------------------------------------------------------------------

/**
 * Generate a full URL from a relative path.
 */
function url(string $path = ''): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Generate URL for a static asset.
 */
function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

// -------------------------------------------------------------------------
// Flash Messages
// -------------------------------------------------------------------------

/**
 * Display flash message HTML if present.
 */
function flash_message(): string
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    if (!$flash) {
        return '';
    }

    $type = e($flash['type']);
    $message = e($flash['message']);

    return '<div class="alert alert-' . $type . '">' . $message . '</div>';
}

// -------------------------------------------------------------------------
// Formatting
// -------------------------------------------------------------------------

/**
 * Format a number as IDR currency.
 */
function format_rupiah(float $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

/**
 * Format a date string.
 */
function format_date(?string $date, string $format = 'd M Y'): string
{
    if (!$date) return '-';
    return date($format, strtotime($date));
}

/**
 * Format a datetime string.
 */
function format_datetime(?string $datetime, string $format = 'd M Y H:i'): string
{
    if (!$datetime) return '-';
    return date($format, strtotime($datetime));
}

/**
 * Get old input value (for form re-population after validation error).
 */
function old(string $key, string $default = ''): string
{
    return e($_SESSION['old_input'][$key] ?? $default);
}
