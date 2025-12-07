<?php

// Try to get environment variable using $_SERVER first, then getenv()
$r2PublicBucketUrl = $_SERVER['R2_PUBLIC_BUCKET_URL'] ?? getenv('R2_PUBLIC_BUCKET_URL') ?? 'https://pub-62a8bede3bdc49d3ad4f551584dc01be.r2.dev';

define('R2_PUBLIC_BUCKET_URL', $r2PublicBucketUrl.'/shopconv');