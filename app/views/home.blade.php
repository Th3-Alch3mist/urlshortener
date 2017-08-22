@include('header')
        <h1 align="center">URL Shortener</h1>
        <br />
        <h3 align="center">Shorten Your URLs to make them look better and more convenient.</h3>
        <h3 align="center">Log In to shorten a URL or retieve a shortened URL.</h3>
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
            <tr align="center">
                <td colspan="2">Click <strong><a href="signup">HERE</a></strong> to create a new account.</td>
            </tr>
        </table>
        </form>
        <br /><br />
        <table align="center">
            <tr>
                <td><span style="color: yellow;">Total Hits :</span></td>
                <td><span style="color: lime;">{{{ $clicks }}}</span></td>
            </tr>
            <tr>
                <td><span style="color: yellow;">Users :</span></td>
                <td><span style="color: lime;">{{ $users }}</span></td>
            </tr>
        </table>
@include('footer')