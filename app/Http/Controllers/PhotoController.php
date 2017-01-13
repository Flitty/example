<?php

namespace App\Http\Controllers;

use App\Album;
use App\Comment;
use App\GroupUser;
use App\Image;
use App\Like;
use App\NormalComment;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    private function imageInfo($id) {
        try {
            return Image::with(
                'likers.user',
                'disLikers.user',
                'comments.userInfo',
                'comments.likers.user',
                'comments.disLikers.user')->find($id);
        } catch (\Exception $ex) {
            return response('Error', 403);
        }
    }

    public function test() {
        return view('photo_test');
    }

    public function show($id)
    {
        try {
            $data = $this->imageInfo($id);
            if($data) {
                return response()->json(['status' => true, 'data' => $data]);
            }
            return response('Not found', 404);
        } catch (\Exception $ex) {
            return response('Error', 403);
        }

    }

    public function like($id) {
        try {
            $user_id = Auth::id();
            $is_like = Image::with(['likes' => function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            }, 'disLikes' => function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            }])->find($id);
            if (count($is_like->disLikes) > 0) {
                $data = [
                    'like/dislike' => 1,
                    'user_id' => $user_id,
                    'image_id' => $id
                ];
                Image::find($id)->likes()->create($data);
                Like::find($is_like->disLikes[0]->id)->delete();
                $data = $this->imageInfo($id);
                return response()->json(['status' => true, 'data' => $data]);
            }
            if (count($is_like->likes) == 0) {
                $data = [
                    'like/dislike' => 1,
                    'user_id' => $user_id,
                    'image_id' => $id
                ];
                Image::find($id)->likes()->create($data);
            } else {
                Like::find($is_like->likes[0]->id)->delete();
            }
            $data = $this->imageInfo($id);
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $ex) {
            return response('Error', 403);
        }
    }

    public function disLike($id) {
        try {
            $user_id = Auth::id();
            $is_like = Image::with(['likes' => function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            }, 'disLikes' => function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            }])->find($id);
            if (count($is_like->likes) > 0) {
                $data = [
                    'like/dislike' => 0,
                    'user_id' => $user_id,
                    'image_id' => $id
                ];
                Image::find($id)->disLikes()->create($data);
                Like::find($is_like->likes[0]->id)->delete();
                $data = Image::with(
                    'likers.user',
                    'disLikers.user',
                    'comments.userInfo',
                    'comments.likers.user',
                    'comments.disLikers.user')->find($id);
                return response()->json(['status' => true, 'data' => $data]);
            }
            if (count($is_like->disLikes) == 0) {
                $data = [
                    'like/dislike' => 0,
                    'user_id' => $user_id,
                    'image_id' => $id
                ];
                Image::find($id)->disLikes()->create($data);
            } else {
                Like::find($is_like->disLikes[0]->id)->delete();
            }
            $data = Image::with(
                'likers.user',
                'disLikers.user',
                'comments.userInfo',
                'comments.likers.user',
                'comments.disLikers.user')->find($id);
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $ex) {
            return response('Error', 403);
        }
    }

    public function addComment(Requests\ImageCommentRequest $request) {
        try {
            $user_id = Auth::id();
            $data = [
                'user_id' => $user_id,
                'text' => $request->text,
                'image_id' => $request->image_id
            ];
            Image::find($request->image_id)->comments()->create($data);
            $data = $this->imageInfo($request->image_id);
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Exception $ex) {
            return response('Error', 403);
        }
    }

    public function updateComment(Requests\ImageCommentRequest $request) {
        try {
            $user_id = Auth::id();
            $comment = NormalComment::find($request->comment_id);
            if ($comment) {
                $user = Image::with('album.user')->find($request->image_id);
                $id = false;
                if ($user->album()->first()) {
                    if ($user->album()->first()->user()->first()) {
                        $id = $user->album()->first()->user()->first()->id == $user_id;
                    }
                }
                $is_has_right = GroupUser::whereHas('role', function ($q) {
                    $q->where('name', '!=', 'player');
                })->where('user_id', $user_id)->first();
                if ($comment->user_id == $user_id || $id || $is_has_right) {
                    $comment->text = $request->text;
                    $comment->save();
                    $data = $this->imageInfo($request->image_id);
                    return response()->json(['status' => true, 'data' => $data]);
                }
                return response('Permission denied', 403);
            }
            return response('Not found', 404);
        } catch (\Exception $ex) {
            return response('Error', 403);
        }
    }

    public function deleteComment(Request $request) {
        try {
            $user_id = Auth::id();
            $comment = NormalComment::find($request->comment_id);
            if ($comment) {
                $user = Image::with('album.user')->find($request->image_id);
                $id = false;
                if ($user->album()->first()) {
                    if ($user->album()->first()->user()->first()) {
                        $id = $user->album()->first()->user()->first()->id == $user_id;
                    }
                }
                $is_has_right = GroupUser::whereHas('role', function ($q) {
                    $q->where('name', '!=', 'player');
                })->where('user_id', $user_id)->first();
                if ($comment->user_id == $user_id || $id || $is_has_right) {
                    $comment->delete();
                    $data = $this->imageInfo($request->image_id);
                    return response()->json(['status' => true, 'data' => $data]);
                }
                return response('Permission denied', 403);
            }
            return response('Not found', 404);
        } catch (\Exception $ex) {
            return response('Error', 403);
        }
    }
}
