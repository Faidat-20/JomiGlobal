<?php

function generateOrderNumber() {
  $timestamp = (int)(microtime(true) * 1000);
  $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));
  return 'TRK-' . $timestamp . '-' . $random;
}
