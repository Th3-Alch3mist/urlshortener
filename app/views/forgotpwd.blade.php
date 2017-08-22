@include('header')
        <h1 align="center">Forgot Password??</h1>
        <br />
        <form action="forgot-password" method="post">
        <table align="center">
            <tr>
                <td><label for="email">Your Email Id:</label></td>
                <td><input type="text" class="Input" name="email" value="" placeholder="Your Email" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="Button" name="submit" value="Submit" /></td>
            </tr>
        </table>
        </form>
        @if(isset($message))
        <p align="center"><span style="color: yellow;">{{{ $message }}}</span></p>
        @endif
        <br />
        <p align="center">Click <strong><a href="{{{ $home }}}">HERE</a></strong> to go back to homepage.</p>
@include('footer')