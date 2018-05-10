<?php

namespace App\Http\Controllers\Invitation;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\InterestedUser;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class InterestedUserController extends Controller
{
    use ApiResponse;

    /**
     * Create new interested user
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $interestedUser = new InterestedUser();

        $this->validate($request, $interestedUser->validation, $interestedUser->messages);

        $interestedUser->create([
            'email' => $request->email,
            'token' => str_random(24),
        ]);

        return $this->apiSuccess(['message' => 'Thank you for requesting your interest']);
    }

    /**
     * Form to create User from invitation
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invitation.interested-user');
    }

    /**
     * Get an interested users invitation from their invitation_code
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invitation_code' => 'required'
        ]);
        /** if validation fails show invite page with error  */
        if ($validator->fails()) {
            return $this->apiFail(['inviteError' => [
                'title'   => 'We cant find your invitation',
                'message' => 'Sorry we were unable to find you invitation to this team'
            ]]);
        }
        /** decode the users invitation code */
        $invitationData = $this->decodeInvitation($request->get('invitation_code'));
        /** if decodeInvitation returned false show invite page with error */
        if (!$invitationData) {
            return $this->apiFail(['inviteError' => [
                'title'   => 'We cant find your invitation',
                'message' => 'Sorry we were unable to find your invitation'
            ]]);
        }
        /** get invitation using email address and token */
        $invitation = InterestedUser::findByEmailAndToken($invitationData['email'], $invitationData['token']);
        /** if no invitation show invite page with error  */
        if (!$invitation) {
            return $this->apiFail(['inviteError' => [
                'title'   => 'We cant find your invitation',
                'message' => 'Sorry we were unable to find your invitation'
            ]]);
        }
        return $this->apiSuccess(['invitation' => $invitation]);
    }

    /**
     * Decodes $invitationCode into email and token
     * @param string $invitationCode
     * @return array
     */
    private function decodeInvitation($invitationCode)
    {
        $invitationData = [];
        /** decode invitation code into email and token array */
        parse_str(base64_decode($invitationCode), $invitationData);
        /** validate invitation data */
        if (!isset($invitationData['email']) || !isset($invitationData['token'])) {
            return [];
        }
        /** return decoded invitation data */
        return $invitationData;
    }
}
