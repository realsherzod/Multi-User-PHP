<h1>Admins dashboard</h1>

@if (auth()->guard('client')->check())
    <h2>Admin ro'yxatdan o'tgan</h2>
@endif


<form action="{{ route('logoutClient')}}" method="POST">
    @csrf


    <input type="submit" value="chiqish">
</form>