<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an activity.
     *
     * @param string $action Action name (e.g., 'assign_lawyer', 'create_package')
     * @param string $description Description of the action
     * @param Model|null $model Related model instance
     * @param array|null $changes Changes made (before/after)
     * @return ActivityLog
     */
    public static function log(
        string $action,
        string $description,
        ?Model $model = null,
        ?array $changes = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'changes' => $changes,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log lawyer assignment.
     */
    public static function logLawyerAssignment($question, $lawyer): ActivityLog
    {
        return self::log(
            action: 'assign_lawyer',
            description: "Soru #{$question->id} ({$question->title}) için avukat atandı: {$lawyer->name}",
            model: $question,
            changes: [
                'lawyer_id' => $lawyer->id,
                'lawyer_name' => $lawyer->name,
                'status' => 'waiting_lawyer_answer',
            ]
        );
    }

    /**
     * Log package creation.
     */
    public static function logPackageCreation($package): ActivityLog
    {
        return self::log(
            action: 'create_package',
            description: "Yeni paket oluşturuldu: {$package->name}",
            model: $package,
            changes: [
                'name' => $package->name,
                'price' => $package->price,
                'question_quota' => $package->question_quota,
            ]
        );
    }

    /**
     * Log package update.
     */
    public static function logPackageUpdate($package, array $oldValues): ActivityLog
    {
        $changes = [];
        foreach ($oldValues as $key => $oldValue) {
            if (isset($package->getAttributes()[$key]) && $package->getAttributes()[$key] != $oldValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $package->getAttributes()[$key],
                ];
            }
        }

        return self::log(
            action: 'update_package',
            description: "Paket güncellendi: {$package->name}",
            model: $package,
            changes: $changes ?: null
        );
    }

    /**
     * Log question closure.
     */
    public static function logQuestionClosure($question): ActivityLog
    {
        return self::log(
            action: 'close_question',
            description: "Soru kapatıldı: #{$question->id} ({$question->title})",
            model: $question,
            changes: [
                'status' => 'closed',
                'previous_status' => $question->getOriginal('status') ?? $question->status,
            ]
        );
    }

    /**
     * Log video publication.
     */
    public static function logVideoPublication($video): ActivityLog
    {
        return self::log(
            action: 'publish_video',
            description: "Video yayınlandı: {$video->title}",
            model: $video,
            changes: [
                'is_active' => true,
                'category' => $video->category->name ?? null,
            ]
        );
    }

    /**
     * Log video update.
     */
    public static function logVideoUpdate($video, array $oldValues): ActivityLog
    {
        $changes = [];
        foreach ($oldValues as $key => $oldValue) {
            if (isset($video->getAttributes()[$key]) && $video->getAttributes()[$key] != $oldValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $video->getAttributes()[$key],
                ];
            }
        }

        return self::log(
            action: 'update_video',
            description: "Video güncellendi: {$video->title}",
            model: $video,
            changes: $changes ?: null
        );
    }

    /**
     * Log FAQ creation.
     */
    public static function logFaqCreation($faq): ActivityLog
    {
        return self::log(
            action: 'create_faq',
            description: "Yeni SSS eklendi: {$faq->question}",
            model: $faq
        );
    }

    /**
     * Log FAQ update.
     */
    public static function logFaqUpdate($faq): ActivityLog
    {
        return self::log(
            action: 'update_faq',
            description: "SSS güncellendi: {$faq->question}",
            model: $faq
        );
    }

    /**
     * Log video category creation.
     */
    public static function logVideoCategoryCreation($category): ActivityLog
    {
        return self::log(
            action: 'create_video_category',
            description: "Yeni video kategorisi oluşturuldu: {$category->name}",
            model: $category
        );
    }

    /**
     * Log order approval.
     */
    public static function logOrderApproval($order): ActivityLog
    {
        return self::log(
            action: 'approve_order',
            description: "Sipariş onaylandı: #{$order->id} - Paket: {$order->package->name}",
            model: $order,
            changes: [
                'status' => 'approved',
            ]
        );
    }
}
