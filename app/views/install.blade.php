@include('header')
        <h1 align="center">URL Shortener Installation</h1>
        <br />
        <form action="install" method="post">
        <table align="center">
            <tr>
                <td><label for="url">Website URL:</label></td>
                <td><input type="text" class="Input" name="url" value="http://" placeholder="Your Website URL" /></td>
            </tr>
            <tr></tr>
            <tr>
                <td><label for="dbhost">Database Host:</label></td>
                <td><input type="text" class="Input" name="dbhost" value="" placeholder="Database Host" /></td>
            </tr>
            <tr>
                <td><label for="dbname">Database Name:</label></td>
                <td><input type="text" class="Input" name="dbname" value="" placeholder="Database Name" /></td>
            </tr>
            <tr>
                <td><label for="dbuname">Database Username:</label></td>
                <td><input type="text" class="Input" name="dbuname" value="" placeholder="Database Username" /></td>
            </tr>
            <tr>
                <td><label for="dbpass">Database Password:</label></td>
                <td><input type="password" class="Input" name="dbpass" value="" placeholder="Database Password" /></td>
            </tr>
            <tr>
                <td><label for="tblprefix">Table Prefix:</label></td>
                <td><input type="text" class="Input" name="tblprefix" value="url_" placeholder="Database Table Prefix" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" class="Button" name="submit" value="Install" /></td>
            </tr>
        </table>
        </form>
        @if(isset($message))
        <p align="center"><span style="color: red;">{{ $message }}</span></p>
        @endif
@include('footer')