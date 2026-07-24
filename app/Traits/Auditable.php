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
            if ($model->shouldAudit('created')) {
                static::recordAuditLog(
                    $model, 
                    'created', 
                    null, 
                    $model->filterHiddenAttributes($model->getAttributes())
                );
            }
        });

        static::updated(function ($model) {
            if ($model->shouldAudit('updated')) {
                $oldValues = array_intersect_key($model->getOriginal(), $model->getDirty());
                $newValues = $model->getDirty();

                if (empty($newValues)) {
                    return;
                }

                static::recordAuditLog(
                    $model, 
                    'updated', 
                    $model->filterHiddenAttributes($oldValues), 
                    $model->filterHiddenAttributes($newValues)
                );
            }
        });

        static::deleted(function ($model) {
            if ($model->shouldAudit('deleted')) {
                static::recordAuditLog(
                    $model, 
                    'deleted', 
                    $model->filterHiddenAttributes($model->getAttributes()), 
                    null
                );
            }
        });
    }

    public function shouldAudit(string $event): bool
    {
        if (!property_exists($this, 'auditEvents')) {
            return true;
        }

        return in_array($event, $this->auditEvents);
    }

    public function filterHiddenAttributes(array $data): array
    {
        $hiddenKeys = array_merge($this->getHidden(), [
            'password', 
            'citizen_id', 
            'token', 
        ]);

        foreach ($data as $key => $value) {
            if (in_array($key, $hiddenKeys)) {
                $data[$key] = '[REDACTED]';
            }
        }

        return $data;
    }

    protected static function recordAuditLog($model, string $event, ?array $oldValues, ?array $newValues): void
    {
        AuditLog::create([
            'user_id'        => Auth::id(),
            'event'          => $event,
            'auditable_type' => get_class($model),
            'auditable_id'   => $model->getKey(),
            
            'old_values'     => $oldValues ? static::cleanAndEncodeJson($oldValues) : null,
            'new_values'     => $newValues ? static::cleanAndEncodeJson($newValues) : null,
            
            'url'            => Request::fullUrl(),
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
        ]);
    }

    protected static function cleanAndEncodeJson(array $data): string
    {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $data[$key] = $decoded;
                }
            }
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}