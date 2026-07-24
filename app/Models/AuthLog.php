<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AuthLog extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $tableName = 'auth_logs_' . date('Y_m');
        $this->setTable($tableName);

        self::ensureTableExists($tableName);
    }

    protected static function ensureTableExists(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_unicode_ci';

                $table->id();
                $table->unsignedBigInteger('user_id')->nullable(); // NULL ถ้าพิมพ์ Username ผิด
                $table->string('email_or_username')->nullable();  // ข้อมูลที่กรอกเข้ามาตอนพยายามล็อกอิน
                $table->string('event');                          // login_success, login_failed, logout, lockout, password_reset...
                $table->boolean('status')->default(true);         // true = Success, false = Failed
                $table->string('failure_reason')->nullable();    // สาเหตุที่ล้มเหลว
                
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('url')->nullable();
                $table->timestamps();

                // Index ช่วยให้ Query สรุปผลความปลอดภัยได้เร็วขึ้น
                $table->index(['user_id', 'event']);
                $table->index(['ip_address', 'status']);
                $table->index('created_at');
            });
        }
    }

    // Helper static สำหรับบันทึก Log สั้นๆ
    public static function record(
        string $event, 
        bool $status = true, 
        ?int $userId = null, 
        ?string $emailOrUsername = null, 
        ?string $failureReason = null
    ): void {
        static::create([
            'user_id'           => $userId,
            'email_or_username' => $emailOrUsername,
            'event'             => $event,
            'status'            => $status,
            'failure_reason'    => $failureReason,
            'ip_address'        => request()->ip(),
            'user_agent'        => request()->userAgent(),
            'url'               => request()->fullUrl(),
        ]);
    }
}