<?php

namespace App\Controllers;


use App\Models\Group;
use App\Models\GroupInvitation;
use App\Models\User;
use App\Requests\GroupInvitationRequest;
use App\Services\ResendService;

class GroupInvitationController extends Controller
{

    private ?ResendService $resend = null;

    public function __construct()
    {
        $this->resend = new ResendService();
    }

    public function prepareInvitation(int $groupId)
    {
        parent::__construct();

        $group = Group::find($groupId);

        if (!$group) {
            return $this->render('errors/404', ["errors" => "Le groupe n'existe pas"]);
        }

        return $this->render('invite/index', ['groupId' => $groupId]);
    }

    public function invite(int $groupId)
    {
        parent::__construct();

        $group = Group::find($groupId);

        if (empty($group)) {
            return $this->render('errors/404', ["errors" => "Le groupe n'existe pas"]);
        }

        $inviteRequest = new GroupInvitationRequest();

        if (!$inviteRequest->guestEmail) {
            return $this->render('errors/404', ["errors" => "Erreurs avec les données."]);
        }

        $invitedUser = User::findOneByEmail($inviteRequest->guestEmail);

        if (empty($invitedUser)) {
            return $this->render('invite/index', [
                'groupId' => $groupId,
                'errors' => "L'utilisateur n'existe pas."
            ]);
        }

        $invitation = new GroupInvitation();

        $invitationToken = bin2hex(random_bytes(16));

        $invitation
            ->setGroup($group)
            ->setUser($invitedUser)
            ->setToken($invitationToken)
            ->setExpiresAt((new \DateTime())->modify('+7 days'))
            ->setStatus(GroupInvitation::STATUS_PENDING)
        ;

        $invitation->save();


        $this->resend->sendInvite($invitation);

        return $this->render('invite/index', [
            'groupId' => $groupId,
            'success' => "L'invitation a été envoyé."
        ]);
    }

    public function acceptInvitation(string $token)
    {
        $invitation = GroupInvitation::getGroupInvitationByToken($token);

        $invitedUser = $invitation->getUser();
        $group = $invitation->getGroup();

        if (empty($invitedUser) || empty($group)) {
            return $this->render('errors/404', ['errors' => "Le groupe ou l'utilisateur n'exsite plus."]);
        }

        if ($invitedUser->belongsTo($group)) {
            return $this->render('invite/expired');
        }

        if ($invitation->isExpired() || $invitation->isAccepted()) {
            return $this->render('invite/expired');
        }

        $group->addMemberRo($invitedUser);

        $invitation->setStatus(GroupInvitation::STATUS_ACCEPTED);
        $invitation->save();

        return $this->render("invite/accept");
    }
}
