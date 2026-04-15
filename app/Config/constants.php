<?php

// Supabase Storage Configuration
// Keep the constant name as R2_PUBLIC_BUCKET_URL for backward compatibility with existing views
$supabaseUrl = $_SERVER['SUPABASE_URL'] ?? getenv('SUPABASE_URL') ?? 'https://sgtqyhfbhcxdoxijhoje.supabase.co';
$supabaseBucket = $_SERVER['SUPABASE_STORAGE_BUCKET'] ?? getenv('SUPABASE_STORAGE_BUCKET') ?? 'shop-conv';
define('R2_PUBLIC_BUCKET_URL', $supabaseUrl . '/storage/v1/object/public/' . $supabaseBucket . '/shopconv');