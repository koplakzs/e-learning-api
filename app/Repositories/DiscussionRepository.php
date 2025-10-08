<?php

namespace App\Repositories;

use App\Interfaces\DiscussionRepositoryInterface;
use App\Models\Discussion;
use App\Models\Reply;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiscussionRepository implements DiscussionRepositoryInterface
{
    public function getAll()
    {
        $query = Discussion::orderBy('created_at', 'desc')->get();
        return $query;
    }
    public function getById(string $id)
    {
        $query = Discussion::find($id);

        return $query;
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $discussion = new Discussion();
            $discussion->course_id = $data['course_id'];
            $discussion->content = $data['content'];
            $discussion->user_id = Auth::user()->id;
            $discussion->save();
            DB::commit();

            return $discussion;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }

    public function reply(string $id, array $data)
    {
        DB::beginTransaction();

        try {
            $reply = new Reply();
            $reply->discussion_id = $id;
            $reply->content = $data['content'];
            $reply->user_id = Auth::user()->id;
            $reply->save();
            DB::commit();

            return $reply;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new Exception($th->getMessage());
        }
    }
}
