<?php

use Carbon\Carbon;

function isSponsored($apartment) {
    $is_sponsored = false;
    $last_sponsorship = $apartment->sponsorships->sortBy('created_at')->last();

    if ($last_sponsorship) {
        $last_payment = $last_sponsorship->payments->sortBy('created_at')->last();

        if ($last_payment->accepted) {
            $sponsorship_end = $last_sponsorship->created_at->addHours($last_sponsorship->sponsorshipType->duration);

            $is_sponsored = $sponsorship_end > Carbon::now();
        }
    }

    return $is_sponsored;
}
