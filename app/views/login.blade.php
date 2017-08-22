@include('header')
        <h1 align="center">Log In</h1>
        <br />
        <form action="login" method="post">
        <table align="center">
            <tr>
                <td><label for="email">Email Id:</label></td>
                <td><input type="text" class="Input" name="email" value="" placeholder="Your Email" /></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" class="Input" name="password" value="" placeholder="Password" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="Button" name="submit" value="Log In" /></td>
            </tr>
            <tr>
                <td></td>
                <td><a href="forgot-password">Forgot password?</a></td>
            </tr>
        </table>
        </form>
        @if(isset($loginerror))
        <p align="center"><span style="color: yellow;">{{ $loginerror }}</span></p>
        @endif
        <br />
        <p align="center">Click <strong><a href="{{{ $home }}}">HERE</a></strong> to go back to homepage.</p>
@include('footer')