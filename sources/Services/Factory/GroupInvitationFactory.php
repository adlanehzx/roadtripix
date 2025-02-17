<?php

namespace App\Services\Factory;

use App\Models\Group;
use App\Models\User;
use App\Models\GroupInvitation;

class GroupInvitationFactory
{
    public static function createFromDatabase(array $data): ?GroupInvitation
    {
        $groupInvitation = new GroupInvitation();

        $groupInvitation
            ->setId($data['id'])
            ->setGroup(Group::find($data['group_id']))
            ->setUser(User::find($data['user_id']))
            ->setToken($data['token'])
            ->setExpiresAt($data['expiresAt'])
            ->setStatus($data['status']);


        return $groupInvitation;
    }
}
