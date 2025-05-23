<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationStatus;
use Illuminate\Http\Request;
use App\Models\SectionMat;
use App\Models\School_level;
use App\Models\Material;
use App\Models\Manuels;
use App\Models\Option;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $sectionm = SectionMat::where('id', $user->section_id)->pluck('name');
        $levelm = School_level::where('id', $user->level_id)->pluck('name');
        $matieretearcher = Material::where('id', $user->matier_id)->pluck('name');
        $optiontearcher = Option::where('id', $user->option_id)->pluck('name');          

        $matiere =[];
        if( !empty($user->section_id)){
        $matiere =Material::where('section_id', $user->section_id)->get();
        }
        $notifications = Notification::where(function ($query) use ($user) {
            $query->where('notifications.user_id', $user->id)
                ->where('notifications.type', 'single');
        })->orWhere(function ($query) use ($user) {
            if (!$user->isAdmin()) {
                $query->whereNull('notifications.user_id')
                    ->whereNull('notifications.group_id')
                    ->where('notifications.type', 'all_users');
            }
        });

        $userGroup = $user->userGroup()->first();
        if (!empty($userGroup)) {
            $notifications->orWhere(function ($query) use ($userGroup) {
                $query->where('notifications.group_id', $userGroup->group_id)
                    ->where('notifications.type', 'group');
            });
        }

        $notifications->orWhere(function ($query) use ($user) {
            $query->whereNull('notifications.user_id')
                ->whereNull('notifications.group_id')
                ->where(function ($query) use ($user) {
                    if ($user->isUser()) {
                        $query->where('notifications.type', 'students');
                    } elseif ($user->isTeacher()) {
                        $query->where('notifications.type', 'instructors');
                    } elseif ($user->isOrganization()) {
                        $query->where('notifications.type', 'organizations');
                    }
                });
        });

        $notifications = $notifications->leftJoin('notifications_status','notifications.id','=','notifications_status.notification_id')
            ->selectRaw('notifications.*, count(notifications_status.notification_id) AS `count`')
            ->with(['notificationStatus'])
            ->groupBy('notifications.id')
            ->orderBy('count','asc')
            ->orderBy('notifications.created_at','DESC')
            ->paginate(10);

        $data = [
            'pageTitle' => trans('panel.notifications'),
            'notifications' => $notifications,
            'sectionm' => $sectionm,
            'levelm' => $levelm,
            'matiere' => $matiere,
            'matieretearcher'  => $matieretearcher,
            'optiontearcher' => $optiontearcher,

        ];

        return view(getTemplate() . '.panel.notifications.index', $data);
    }

    public function saveStatus($id)
    {
        $user = auth()->user();

        $unReadNotifications = $user->getUnReadNotifications();

        if (!empty($unReadNotifications) and !$unReadNotifications->isEmpty()) {
            $notification = $unReadNotifications->where('id', $id)->first();

            if (!empty($notification)) {
                $status = NotificationStatus::where('user_id', $user->id)
                    ->where('notification_id', $notification->id)
                    ->first();

                if (empty($status)) {
                    NotificationStatus::create([
                        'user_id' => $user->id,
                        'notification_id' => $notification->id,
                        'seen_at' => time()
                    ]);
                }
            }
        }

        return response()->json([], 200);
    }
    public function markAllRead()
    {
        $user = auth()->user();

        $unReadNotifications = $user->getUnReadNotifications();

        if (!empty($unReadNotifications) && !$unReadNotifications->isEmpty()) {
            foreach ($unReadNotifications as $notification) {
                $status = NotificationStatus::where('user_id', $user->id)
                    ->where('notification_id', $notification->id)
                    ->first();

                if (empty($status)) {
                    NotificationStatus::create([
                        'user_id' => $user->id,
                        'notification_id' => $notification->id,
                        'seen_at' => time()
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'All notifications marked as read.'
        ], 200);
    }

}
