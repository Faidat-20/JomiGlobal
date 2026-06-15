<?php

require_once ROOT . '/config/email.php';

function sendEmail($to, $toName, $subject, $htmlContent) {
  $url = 'https://api.brevo.com/v3/smtp/email';

  $data = [
    'sender' => [
      'name'  => MAIL_FROM_NAME,
      'email' => MAIL_FROM_EMAIL,
    ],
    'to' => [
      [
        'email' => $to,
        'name'  => $toName,
      ]
    ],
    'subject' => $subject,
    'htmlContent' => $htmlContent,
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'api-key: ' . BREVO_API_KEY,
    'content-type: application/json',
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  return $httpCode === 201;
}