<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AuditLog extends Model
{
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // กำหนดชื่อ Table ตาม ปี_เดือน เช่น audit_logs_2026_07
        $tableName = 'audit_logs_' . date('Y_m');
        $this->setTable($tableName);

        // เช็คและสร้าง Table อัตโนมัติถ้ายังไม่มี
        self::ensureTableExists($tableName);
    }

    protected static function ensureTableExists(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('event'); // created, updated, deleted
                $table->string('auditable_type'); // Model name
                $table->unsignedBigInteger('auditable_id'); // Model ID
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->string('url')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();

                // Index เพื่อเพิ่มความเร็วในการ Query
                $table->index(['auditable_type', 'auditable_id']);
                $table->index('user_id');
            });
        }
    }

    // Helper method สำหรับดึง Log ย้อนหลังตามเดือน
    public static function inMonth(int $year, int $month)
    {
        $instance = new static();
        $tableName = sprintf('audit_logs_%04d_%02d', $year, $month);
        
        if (!Schema::hasTable($tableName)) {
            return collect(); // ส่งคืน Collection ว่างถ้าไม่มี Table ของเดือนนั้น
        }

        return $instance->setTable($tableName)->newQuery();
    }
}