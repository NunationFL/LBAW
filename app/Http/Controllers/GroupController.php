<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

use Auth;

class GroupController extends Controller
{
    //Returns a page with the informations of a group
    public function show($id)
    {

        if (!ctype_digit($id)) {
            abort(404);
        }
        $group = Group::find($id);

        $reviews = $group->reviews()->take(3)->get();

        return view('pages.group_page', [
            'group' => $group,
            'reviews' => $reviews
        ]);
    }

    public function getPage($id, $page)
    {
        if (!ctype_digit($id)) {
            abort(404);
        }
        if (!ctype_digit($id) || !ctype_digit($page)) {
            return view(self::ERROR_404_PAGE);
        }
        $u = Group::find($id);
        if ($u == null) {
            return view(self::ERROR_404_PAGE);
        }

        $reviews = $u->reviews()->skip($page * 3)->take(3)->get();
        return view('pagination.feed', ['reviews' => $reviews]);
    }

    //Returns a page with a list of all the groups
    public function list()
    {

        $this->authorize('view', Group::class);

        $groups = Auth::user()->groups;

        return view('pages.groups_list', [
            'groups' => $groups
        ]);
    }

    //Returns a page with a form to add a group
    public function add_group_page()
    {

        $this->authorize('create', Group::class);

        return view('pages.add_group');
    }

    //Creates a group
    public function create(Request $request)
    {

        $this->authorize('create', Group::class);

        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'string',
            'groupPhoto' => 'image'
        ]);


        $imageName = time() . '.' . $request->groupPhoto->extension();

        $request->groupPhoto->move(public_path('img'), $imageName);

        $group = Group::create([
            'title' => $request->title,
            'description' => $request->description,
            'photo' => 'img/' . $imageName,
            'admin' => auth()->user()->id
        ]);

        if ($group) {

            $members = [];
            $members[] = auth()->user()->id;

            $group->members()->sync($members);

            $notification = User::find(auth()->user()->id)->notifications()->where('group_id', $group->id);
            $notification->delete();

            $group->members()->updateExistingPivot(auth()->user()->id, [
                'membership_state' => 'accepted',
            ]);

            

            return redirect()->route('group', ['group_id' => $group->id]);
        }


        return redirect()->route('landing_page');
    }

    //Returns a list of users that can be invited
    public function invitation_page($group_id)
    {

        if (!ctype_digit($group_id)) {
            abort(404);
        }
        $group = Group::find($group_id);

        $this->authorize('invite', $group);

        $group_members = $group->members()->where('membership_state', 'accepted')->pluck('group_member.id')->all();

        $friends = auth()->user()->friends->whereNotIn('id', $group_members);

        return view('pages.group_invite', [
            'friends' => $friends,
            'group_id' => $group_id,
        ]);
    }

    //Invites a user to a group
    public function invite_user($group_id, $user_id)
    {

        if (!ctype_digit($group_id)) {
            abort(404);
        }
        if (!ctype_digit($user_id)) {
            abort(404);
        }
        $group = Group::find($group_id);

        $user = User::find($user_id);

        $this->authorize('invite_user', [$group, $user]);

        $group->members()->attach($user);
        $group->save();

        return back();
    }

    //Accepts a group invitation
    public function accept_invite($user_id, $group_id)
    {

        if (!ctype_digit($group_id)) {
            abort(404);
        }
        if (!ctype_digit($user_id)) {
            abort(404);
        }
        $group = Group::find($group_id);

        $user = User::find($user_id);

        $this->authorize('accept_invite', [$group, $user]);

        $group->members()->updateExistingPivot($user_id, [
            'membership_state' => 'accepted',
        ]);

        $notification = User::find($user_id)->notifications()->where('group_id', $group_id);
        $notification->delete();

        return back();
    }

    //Rejects a group invitation
    public function reject_invite($user_id, $group_id)
    {

        if (!ctype_digit($group_id)) {
            abort(404);
        }
        if (!ctype_digit($user_id)) {
            abort(404);
        }
        $group = Group::find($group_id);
        $user = User::find($user_id);

        $this->authorize('reject_invite', [$group, $user]);

        $group->members()->updateExistingPivot($user_id, [
            'membership_state' => 'rejected',
        ]);

        $notification = User::find($user_id)->notifications()->where('group_id', $group_id);
        $notification->delete();

        return back();
    }

    //Deletes a group
    public function delete($group_id)
    {

        if (!ctype_digit($group_id)) {
            abort(404);
        }
        $group = Group::find($group_id);

        $this->authorize('delete', $group);

        $group->delete();

        return redirect()->route('groups_list');
    }

    //Allows user to leave a group
    public function leave($group_id, $user_id)
    {
        if (!ctype_digit($group_id)) {
            abort(404);
        }
        if (!ctype_digit($user_id)) {
            abort(404);
        }

        $group = Group::find($group_id);

        $this->authorize('leave', $group);

        $group->members()->detach($user_id);

        return back();
    }

    //Returns a page with list of users in that group
    public function members_page($group_id)
    {
        if (!ctype_digit($group_id)) {
            abort(404);
        }

        $group = Group::find($group_id);

        $members = $group->members;

        return view('pages.group_members', [
            'group' => $group,
            'members' => $members
        ]);
    }
}
