<?php

namespace App\Helpers;

use App\Models\Settings\Term;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;

class ComplianceHelper
{
    /**
     * Give the status for the given term for the given user.
     *
     * @param User $user
     * @param Term $term
     * @return bool
     */
    public static function hasSignedGivenTerm(User $user, Term $term): bool
    {
        $termUser = DB::table('term_user')->where('user_id', $user->id)
            ->where('account_id', $user->account_id)
            ->where('term_id', $term->id)
            ->first();

        if (! $termUser) {
            return false;
        }

        return true;

//        $compliance = Term::find($termId);
//        $signedDate = DateHelper::parseDateTime($termUser->created_at);
//
//        return [
//            'signed' => true,
//            'signed_date' => DateHelper::getTimestamp($signedDate),
//            'ip_address' => $termUser->ip_address,
//            'user' => new UserResource($this),
//            'term' => new ComplianceResource($compliance),
//        ];
    }

    /**
     * Indicate if the user has accepted the most recent terms and privacy.
     * This really is a shortcut of the `hasSignedGivenTerm` method.
     *
     * @param User $user
     * @return bool
     */
    public static function isCompliantWithCurrentTerm(User $user): bool
    {
        $latestTerm = Term::latest()->first();

        return self::hasSignedGivenTerm($user, $latestTerm);
    }
}
