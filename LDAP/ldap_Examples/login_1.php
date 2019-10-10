<?php
session_start();
$current_page = "login";

if ( isset($_GET['logout'])  ) {
    $_SESSION=array();
    session_destroy();
    setcookie ( 'PHPSESSID', '', time()-3600, '/', '', 0, 0 );
    header ( 'Location: ./home' );
    exit;
}

if (isset($_SESSION['login']) && $_SESSION['login']===true) {
    header ('Location: ./main');
    exit;
}

if ($_POST) {

    if ($_POST["login"]==="true" && isset($_POST["username"]) && isset($_POST["password"])) {

        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $ldaprdn  = 'cn=admin,dc=ldap,dc=domain,dc=com';
        $ldappass = 'ldappass';
        $ldapport = 389;
        $server = "ldap.domain.com";
        $ldapconn = ldap_connect($server,$ldapport);

        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($ldapconn, LDAP_OPT_DEBUG_LEVEL, 7);

        if ($ldapconn) {

                $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
                if ($ldapbind) {

                    $ldaptree = "ou=users,dc=ldap,dc=domain,dc=com";
                    $result = ldap_search($ldapconn,$ldaptree, "(cn=$username)");
                    if ($result) {

                        // Array Object $data
                        $data = ldap_get_entries($ldapconn, $result);
/*
                        echo "<br /><br /><pre class=\"text-left\">";
                        echo print_r(array_values($data));
                        echo "<br /></pre>";
*/

                        if ($data["count"]>0) {
                            if (ldap_count_entries($ldapconn, $result)===1) {

                                $ldapHashPasswdValue = "{SHA}".base64_encode( pack('H*',sha1($password)) );

                                if ($data[0]["userpassword"][0] === $ldapHashPasswdValue) {

                                    $_SESSION["gidnumber"] = $data[0]["gidnumber"][0];
                                    $_SESSION["username"] = $username;
                                    $_SESSION["login"] = true;
                                    $_SESSION["cn"] = $data[0]["cn"][0];
                                    $_SESSION["dn"] = $data[0]["dn"];
                                    $_SESSION["sn"] = $data[0]["sn"][0];
                                    $_SESSION["givenname"] = $data[0]["givenname"][0];
                                    $_SESSION["mail"] = $data[0]["mail"][0];
                                    $_SESSION["userpassword"] = $data[0]["userpassword"][0];
                                    $_SESSION["homedirectory"] = $data[0]["homedirectory"][0];
                                    $_SESSION["uid"] = $data[0]["uid"][0];

                                    header ('Location: ./main');
                                    exit;

                                } else {
                                    $error = "Wrong password!";
                                }
                            } else {
                                $error = "Internal system error!<br/>Duplicate Entry ".ldap_count_entries($ldapconn, $result);
                            }
                        } else {
                            $error = "Wrong username!";
                        }

                    } else {
                        $error = "Error in search query: ".ldap_error($ldapconn);
                    }
                } else {
                    $error = "LDAP bind failed!";
                }

                ldap_close($ldapconn);
        } else {
            $error = "LDAP Connection to server $server Failed!";
        }
    } else { exit; }
}

$_SESSION=array();
session_destroy();
setcookie ( 'PHPSESSID', '', time()-3600, '/', '', 0, 0 );
$login = false;
require_once("./inc/header.php");
?>
            <div id="main" class="container">
                <form class="form-style" role="form" method="post" action="login">
                    <p class="login-icon"><i class="fa fa-user fa-5x center-block" aria-hidden="true"></i></p>
                    <h3 class="form-style-heading">Έλεγχος Πρόσβασης<br/><small>MSc Informatics<br/>2014-2016</small></h3>
                    <input type="text" name="username" class="form-control first-input" placeholder="Username" required autofocus>
                    <input type="password" name="password" class="form-control last-input" placeholder="Password" required>
                    <button class="btn btn-login btn-lg btn-block" type="submit">ΣΥΝΔΕΣΗ</button>
                    <input type="hidden" name="login" value="true">
                </form>
                <p class="lead text-center messages"><small><?php if ( isset($error) ) { echo $error; } ?></small></p>
            </div>

<?php
require_once("./inc/footer.php");