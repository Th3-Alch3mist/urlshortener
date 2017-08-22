@include('header')
        <h2 align="center">Stats For URL : {{{ $shorturl }}}</h2>
        <p align="center">
            <strong>
                <a href="profile">Profile</a>
                <a href="change-password">Change Password</a>
                <a href="logout/?token={{ $token }}">Log Out</a>
            </strong>
        </p>
        <br />
        <div align="left">
        <table align="center">
            <tr>
                <td>Long URL :</td>
                <td><a href="{{{ $longurl }}}">{{{ $longurl }}}</a></td>
            </tr>
            <tr>
                <td>Total Hits :</td>
                <td>{{ $hits }}</td>
            </tr>
            <tr>
                <td>Created At :</td>
                <td>{{ $created_at }}</td>
            </tr>
            <tr>
                <td>Created From :</td>
                <td>{{ $ip }}</td>
            </tr>
            @if($hits > 0)
            <tr></tr>
            <tr></tr>
            <tr align="center">
                <td colspan="2">Traffic Details</td>
            </tr>
            <tr align="center">
                <td>Country</td>
                <td>Hits</td>
            </tr>
            @foreach($traffic as $hit)
            <tr align="center">
                <td><img src="images/flags/flag_{{ $hit['country'] }}.gif" /></td>
                <td><span style="color: lime;">{{ $hit['hits'] }}</span></td>
            </tr>
            @endforeach
            @endif
        </table>
        </div>
@include('footer')