<div
    class="h-screen sticky top-0 flex  flex-col items-center content-center gap-0.5 w-52 bg-gray-200 overflow-y-auto">
    @if(auth()->check())
        <form action="{{ route('messenger.logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @endif
    @forelse($users as $user)
        <a class="flex justify-center @if(url()->current() === route('messenger',$user->id)) bg-gray-400 @else bg-gray-300 @endif p-4 w-full hover:bg-gray-400"
           href="{{ route('messenger',$user->id) }}">
            <p>{{ $user->name }}</p>
        </a>
    @empty
        <p class="mt-6">There are no any users yet...</p>
    @endforelse
</div>
