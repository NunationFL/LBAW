<div class="card col-12 col-lg-7 no-padding mx-auto mt-3" id="request_{{ $notification->id }}">
    <div class="card-body d-flex justify-content-between">
        @if ($notification->group != null)
            <p class="card-text my-auto"><a
                    href="{{ route('group', ['group_id' => $notification->group->id]) }}">{{ $notification->group->title }}</a>
                invited you to join their group
            </p>
            <div class="d-flex justify-content-end">

                <form method="POST"
                    action="{{ route('accept_group_invite', [auth()->user()->id, $notification->group_id]) }}"
                    class="col">
                    @csrf
                    <button class="btn btn-primary ms-3 " id="request_{{ $notification->id }}_accept">Join</button>
                </form>

                <form method="POST"
                    action="{{ route('reject_group_invite', [auth()->user()->id, $notification->group_id]) }}"
                    class="col">
                    @csrf
                    <button class="btn btn-primary ms-3 "
                        id="request_{{ $notification->id }}_decline">Decline</button>
                </form>

            </div>

        @elseif($notification->friend != null)
            <p class="card-text my-auto"><a
                    href="{{ route('user', [$notification->friend]) }}">{{ $notification->friend->username }}</a>
                sent
                you a friend request</p>
            <div class="d-flex justify-content-end">
                <form method="POST"
                    action="{{ route('reject_friend_request', [auth()->user()->id, $notification->friend_id]) }}"
                    class="col">
                    @csrf
                    <button id="request_{{ $notification->id }}_decline"
                        class="btn btn-primary ms-3 ">Reject</button>
                </form>

                <form method="POST"
                    action="{{ route('accept_friend_request', [auth()->user()->id, $notification->friend_id]) }}"
                    class="col">
                    @csrf
                    <button id="request_{{ $notification->id }}_accept" class="btn btn-primary ms-3 ">Accept</button>
                </form>
            </div>

        @endif
    </div>
</div>
