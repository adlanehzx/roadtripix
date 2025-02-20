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
            ->setExpiresAt(\DateTime::createFromFormat('Y-m-d H:i:s', $data['expires_at']))
            ->setStatus($data['status']);


        return $groupInvitation;
    }
}
