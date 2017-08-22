@include('header')
        <h1 align="center">Change Password</h1>
        <p align="center">
            <strong>
                <a href="profile">Profile</a>
                <a href="change-password">Change Password</a>
                <a href="logout/?token={{ $token }}">Log Out</a>
            </strong>
        </p>
        <br />
        <form action="change-password" method="post">
        <table align="center">
            <tr>
                <td><label for="email">Your Current Password:</label></td>
                <td><input type="password" class="Input" name="password" value="" placeholder="Your Current Password" /></td>
            </tr>
            <tr>
                <td><label for="email">Your New Password:</label></td>
                <td><input type="password" class="Input" name="npassword" value="" placeholder="Your New Password" /></td>
            </tr>
            <tr>
                <td><label for="email">Confirm New Password:</label></td>
                <td><input type="password" class="Input" name="cnpassword" value="" placeholder="Confirm New Password" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="Button" name="submit" value="Submit" /></td>
            </tr>
        </table>
        </form>
        @if(isset($message))
        <p align="center"><span style="color: yellow;">{{ $message }}</span></p>
        @endif
@include('footer')