@include('header')
        <h1 align="center">Registration</h1>
        <br />
        @if(isset($willsign))
        <form acrion="signup" method="post">
        <table align="center">
            <tr>
                <td><label for="email">Email Id:</label></td>
                <td><input type="text" class="Input" name="email" value="" placeholder="Your Email" /></td>
            </tr>
            <tr>
                <td><label for="username">Username:</label></td>
                <td><input type="text" class="Input" name="username" value="" placeholder="Your Username" /></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" class="Input" name="password" value="" placeholder="Password" /></td>
            </tr>
            <tr>
                <td><label for="cpassword">Confirm Password:</label></td>
                <td><input type="password" class="Input" name="cpassword" value="" placeholder="Confirm Password" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="Button" name="submit" value="Sign Up" /></td>
            </tr>
        </table>
        </form>
            @if(isset($signuperror))
            <p align="center"><span style="color: yellow;">{{ $signuperror }}</span></p>
            @endif
        @elseif(isset($willactivate))
            <h2 align="center">Awaiting Activation!!</h2>
            <h3 align="center">Your account has been created. Check your email id for activation details.</h3>
        @else
            <h2 align="center">Successfully Signed Up!!</h2>
            <h3 align="center">Click <strong><a href="login">HERE</a></strong> to Log In</h3>
        @endif
        <p align="center">Click <strong><a href="{{{ $home }}}">HERE</a></strong> to go back to homepage.</p>
@include('footer')