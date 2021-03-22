<?php


namespace App\Repositories\Admin;

use App\Models\Lender;
use App\Models\Rent;

class LendRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function history () {
        return Lender::with('lender', 'rent.game', 'order')->orderBy('created_at','ASC')->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function details ($id) {
        return Lender::with('lender', 'lender.address', 'rent.user.address', 'rent.game', 'rent.game.basePrice')->findOrFail($id);
    }

    public function updateStatus($lend_id, $status) {

        $lender = Lender::findOrFail($lend_id);

        if ($status == 1 || $status == 4) {
            $rentPost = Rent::findOrFail($lender->rent_id);
            $rentPost->rented_user_id = null;
            $rentPost->save();

        }
        $lender->status = $status;
        $lender->save();
        return true;
    }
}
