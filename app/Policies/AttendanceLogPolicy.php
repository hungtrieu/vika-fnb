<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AttendanceLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendanceLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_attendance::log');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendanceLog  $attendanceLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->can('view_attendance::log');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_attendance::log');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendanceLog  $attendanceLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->can('update_attendance::log');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendanceLog  $attendanceLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->can('delete_attendance::log');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_attendance::log');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendanceLog  $attendanceLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->can('force_delete_attendance::log');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_attendance::log');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendanceLog  $attendanceLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->can('restore_attendance::log');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_attendance::log');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AttendanceLog  $attendanceLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, AttendanceLog $attendanceLog): bool
    {
        return $user->can('replicate_attendance::log');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_attendance::log');
    }

}
