<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Helper class for handling secure Email operations.
 */
class EmailHelper
{
    /**
     * Sends an OTP email using PHPMailer.
     *
     * @param string $email Recipient email
     * @param string $otp The 6-digit OTP code plain text
     * @return bool
     */
    public static function sendOtp(string $email, string $otp): bool
    {
        $subject = "Kode Verifikasi Akun Kelvora";
        $message = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;'>
                <div style='background-color: #2D3BD9; padding: 20px; text-align: center;'>
                    <h2 style='color: #ffffff; margin: 0;'>Verifikasi Kelvora</h2>
                </div>
                <div style='padding: 30px; background-color: #ffffff;'>
                    <p style='color: #334155; font-size: 16px; margin-top: 0;'>Halo,</p>
                    <p style='color: #334155; font-size: 16px;'>Terima kasih telah mendaftar di Kelvora. Berikut adalah kode OTP Anda untuk verifikasi email:</p>
                    <div style='background-color: #f8fafc; border: 2px dashed #94a3b8; padding: 15px; text-align: center; margin: 25px 0; border-radius: 8px;'>
                        <span style='font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #0f172a;'>{$otp}</span>
                    </div>
                    <p style='color: #64748b; font-size: 14px;'>Kode ini akan kedaluwarsa dalam 5 menit. <strong>Jangan berikan kode ini kepada siapapun!</strong></p>
                </div>
                <div style='background-color: #f1f5f9; padding: 15px; text-align: center;'>
                    <p style='color: #94a3b8; font-size: 12px; margin: 0;'>&copy; " . date('Y') . " Kelvora. All rights reserved.</p>
                </div>
            </div>
        ";

        return self::sendMail($email, $subject, $message);
    }

    /**
     * Internal function to send the email via PHPMailer
     */
    private static function sendMail(string $to, string $subject, string $body): bool
    {
        // Pastikan autoload composer di-require jika belum di global scope
        $autoloadPath = BASE_PATH . '/vendor/autoload.php';
        if (file_exists($autoloadPath) && !class_exists(PHPMailer::class)) {
            require_once $autoloadPath;
        }

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            
            // TODO: Ganti dengan konfigurasi SMTP Anda
            $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through (contoh: smtp.gmail.com)
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'galangsukmagama25@gmail.com';          // SMTP username
            $mail->Password   = 'ygnxqmwrmozdgdye';                     // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable implicit TLS encryption
            $mail->Port       = 587;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('noreply@kelvora.com', 'Kelvora Support');
            $mail->addAddress($to);

            //Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body); // For non-HTML email clients

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Log error for debugging internally
            $logDir = BASE_PATH . '/storage/logs';
            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }
            file_put_contents($logDir . '/email_error.log', "[" . date('Y-m-d H:i:s') . "] {$mail->ErrorInfo}\n", FILE_APPEND);
            
            return false;
        }
    }
}
