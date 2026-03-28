<?php

namespace App\Models;

use Core\BaseModel;
use Exception;

/**
 * Model for handling email OTP verifications.
 */
class EmailOtp extends BaseModel
{
    protected string $table = 'email_otps';
    
    protected array $fillable = ['email', 'otp_hash', 'expires_at', 'attempts'];
    
    // Limits
    private const EXPIRE_MINUTES = 5;
    private const MAX_ATTEMPTS = 3;

    /**
     * Generate a secure numeric OTP for the given email.
     * Inserts into DB and returns the plain 6-digit code.
     */
    public function generate(string $email): string
    {
        // Cancel/Delete older active OTPs for this email to prevent spam reuse
        $this->raw("DELETE FROM {$this->table} WHERE email = :email", ['email' => $email]);

        // Secure Random 6 digit
        $plainOtp = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $otpHash = password_hash($plainOtp, PASSWORD_DEFAULT);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+' . self::EXPIRE_MINUTES . ' minutes'));

        $this->create([
            'email' => $email,
            'otp_hash' => $otpHash,
            'expires_at' => $expiresAt,
            'attempts' => 0
        ]);

        return $plainOtp;
    }

    /**
     * Verifies an OTP code for a given email.
     * Follows strict rules for expiration and max attempts.
     *
     * @return array [bool $isValid, string $message, ?int $otpId]
     */
    public function verify(string $email, string $otp): array
    {
        $record = $this->rawOne(
            "SELECT * FROM {$this->table} WHERE email = :email ORDER BY id DESC LIMIT 1",
            ['email' => $email]
        );

        if (!$record) {
            return [false, 'Kode OTP tidak ditemukan atau sudah hangus.', null];
        }

        // Check expiration
        if (strtotime($record->expires_at) < time()) {
            $this->delete($record->id);
            return [false, 'Kode OTP sudah expired.', null];
        }

        // Check attempts
        if ((int)$record->attempts >= self::MAX_ATTEMPTS) {
            $this->delete($record->id);
            return [false, 'Terlalu banyak percobaan salah. Silakan minta kode baru.', null];
        }

        // Validate hash
        if (password_verify($otp, $record->otp_hash)) {
            return [true, 'Valid.', $record->id];
        }

        // Increment attempts
        $this->update($record->id, ['attempts' => (int)$record->attempts + 1]);

        $remaining = self::MAX_ATTEMPTS - ((int)$record->attempts + 1);
        if ($remaining <= 0) {
            $this->delete($record->id);
            return [false, 'Terlalu banyak percobaan salah. Silakan minta kode baru.', null];
        }

        return [false, "Kode OTP salah. Sisa percobaan: $remaining.", null];
    }

    /**
     * Clears an OTP record completely (e.g. after successful use).
     */
    public function markUsed(int $otpId): void
    {
        $this->delete($otpId);
    }

    /**
     * Enforce Rate Limiting (Kirim OTP max 3-5 kali per jam per email).
     * Check how many generating requests occurred in the last hour.
     */
    public function canSendOTP(string $email): bool
    {
        $oneHourAgo = date('Y-m-d H:i:s', strtotime('-1 hour'));
        
        $sql = "SELECT COUNT(*) as count FROM {$this->table} 
                WHERE email = :email AND created_at >= :window";
        
        $result = $this->rawOne($sql, [
            'email' => $email,
            'window' => $oneHourAgo
        ]);

        return (int)$result->count < 5; // Allow max 5 requests per hour
    }
}
