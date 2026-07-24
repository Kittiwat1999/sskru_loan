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
        
        $tableName = 'audit_logs_' . date('Y_m');
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
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('event'); 
                $table->string('auditable_type'); 
                $table->unsignedBigInteger('auditable_id'); 
                
                $table->text('old_values')->nullable();
                $table->text('new_values')->nullable();
                
                $table->string('url')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();

                $table->index(['auditable_type', 'auditable_id']);
                $table->index('user_id');
            });
        }
    }


    public function getOldValuesArrayAttribute(): ?array
    {
        return $this->old_values ? json_decode($this->old_values, true) : null;
    }

    public function getNewValuesArrayAttribute(): ?array
    {
        return $this->new_values ? json_decode($this->new_values, true) : null;
    }

    public static function inMonth(int $year, int $month)
    {
        $instance = new static();
        $tableName = sprintf('audit_logs_%04d_%02d', $year, $month);
        
        if (!Schema::hasTable($tableName)) {
            return collect(); 
        }

        return $instance->setTable($tableName)->newQuery();
    }
}