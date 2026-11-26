<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StudioSetting extends Model
{
    use HasFactory;
 
    protected $table = 'studio_settings';
 
    protected $fillable = [
        'setting_key',
        'setting_value',
        'updated_by',
    ];
 
    /** Used when a row is missing or empty, so the studio pages never break */
    public const DEFAULTS = [
        'pm_project_id'              => 307,   // Project Management project for studio shoots
        'pm_section_id'              => 105,   // Section inside that project
        'pm_shoot_assignee_id'       => 106,   // Default assignee of the shoot task
        'pm_item_assignee_id'        => 137,   // Default assignee of each shoot item sub task
        'item_due_days_before_shoot' => 3,     // Item sub task due date = shoot date - X days
    ];
 
    private const CACHE_KEY = 'studio_settings.all';
 
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
 
    /** All settings as [key => int], saved value or default */
    public static function allSettings(): array
    {
        $saved = Cache::rememberForever(self::CACHE_KEY, function () {
            return static::pluck('setting_value', 'setting_key')->all();
        });
 
        $values = [];
        foreach (self::DEFAULTS as $key => $default) {
            $value = $saved[$key] ?? null;
            $values[$key] = ($value === null || $value === '') ? $default : (int) $value;
        }
 
        return $values;
    }
 
    /** One setting, e.g. StudioSetting::setting('pm_section_id') */
    public static function setting(string $key)
    {
        return static::allSettings()[$key] ?? null;
    }
 
    /** Save many settings at once (unknown keys are ignored), then clear the cache */
    public static function saveMany(array $values): void
    {
        DB::transaction(function () use ($values) {
            foreach ($values as $key => $value) {
                if (!array_key_exists($key, self::DEFAULTS)) {
                    continue;
                }
 
                $row = static::firstOrNew(['setting_key' => $key]);
                $row->setting_value = (string) $value;
                $row->updated_by    = auth()->id();
                $row->save();   // only changed rows are really updated (and audited)
            }
        });
 
        Cache::forget(self::CACHE_KEY);
    }
 
    /** Who saved last and when (for "Last changed by …") */
    public static function lastChange(): array
    {
        $row = static::with('updatedByUser:id,name')->orderByDesc('updated_at')->first();
 
        return [
            'by' => optional(optional($row)->updatedByUser)->name,
            'at' => optional(optional($row)->updated_at)->format('Y-m-d\TH:i:s'),
        ];
    }
}
