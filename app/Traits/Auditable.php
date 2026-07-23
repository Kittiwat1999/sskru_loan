<?php
namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            static::recordAuditLog($model, 'created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            $oldValues = array_intersect_key($model->getOriginal(), $model->getDirty());
            $newValues = $model->getDirty();

            // ไม่บันทึกถ้าไม่มีการเปลี่ยนแปลงข้อมูลจริง
            if (empty($newValues)) {
                return;
            }

            static::recordAuditLog($model, 'updated', $oldValues, $newValues);
        });

        static::deleted(function ($model) {
            static::recordAuditLog($model, 'deleted', $model->getAttributes(), null);
        });
    }

    protected static function recordAuditLog($model, string $event, ?array $oldValues, ?array $newValues): void
    {
        AuditLog::create([
            'user_id'        => Auth::id(),
            'event'          => $event,
            'auditable_type' => get_class($model),
            'auditable_id'   => $model->getKey(),
            'old_values'     => $oldValues ? json_encode($oldValues) : null,
            'new_values'     => $newValues ? json_encode($newValues) : null,
            'url'            => Request::fullUrl(),
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
        ]);
    }
}