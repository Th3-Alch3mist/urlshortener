@include('header')
<h1 align="center">Welcome {{{ $id }}}</h1>
<p align="center">
    <strong>
        <a href="profile">Profile</a>
        <a href="change-password">Change Password</a>
        <a href="logout/?token={{ $token }}">Log Out</a>
    </strong>
</p>
<form action="profile" method="post">
<table align="center">
    <tr>
        <td><label for="url">Enter URL:</label></td>
        <td><input class="Input" type="text" name="url" value="http://" placeholder="You URL to be shortened" size="70" /></td>
        <td><label for="customkey">Custom Short URL:</label></td>
        <td><input class="Input" type="text" name="customkey" maxlength="13" value=""  size="50" placeholder="Alphanumeric with maximum 13 characters" /></td>
    </tr>
    <tr>
        <td><label for="title">Enter URL Title:</label></td>
        <td><input class="Input" type="text" name="title"  size="70" placeholder="You URL title" /></td>
        <td colspan="2"><input class="Button" type="submit" name="submit" value="Shorten" />
    </tr>
</table>
@if(isset($urlerror))
<p align="center"><span style="color: yellow;">{{ $urlerror }}</span></p>
@endif
@if(isset($urls))
<br /><br />
<table align="center">
    <tr>
        <th>Shortened URL</th>
        <th>Long URL</th>
        <th>Unique Hits</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($urls as $url)
    <tr>
        <td align="center"><a href="{{ $url->shorturl }}">{{{ $url->shorturl }}}</a></td>
        <td><a href="{{ $url->longurl }}">@if(strlen($url->title) > 0){{{ $url->title }}}@else{{{ $url->longurl }}}@endif</a></td>
        <td align="center">{{{ $url->hits }}}</td>
        <td><a href="stats-{{ $url->shorturl }}">Show Stats</a></td>
        <td><a href="delete-{{ $url->shorturl }}"><input class="Button" type="button" value="Delete" /></a></td>
    </tr>
    @endforeach
</table>
@endif
</form>
@include('footer')