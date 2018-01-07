<div id="aligntable">
    <table id="maintable" cellpadding="0" cellspacing="0">
        <tbody>

        <tr valign="top">
            <td colspan="2" id="mainheader"><p class="bannertitle" style="">Banner Text</p>
                <p class="bannerslogan" style="">Banner Slogan</p>
                <?php echo $this->Html->image('SIHC_2017_Final_Branding_Banner.jpg', ['alt' => 'Banner',  'url'=>['controller' => 'Workshops']]); ?>

                <!--<img src="assets/banner.gif" id="bannerImage"></td>-->
        </tr>

        <tr id="hornav" valign="top">
            <td colspan="2" id="hornavcell">
        <tr valign="top">

            <td id="mainleftcell">
                <div class="leftbox" id="searchbox">
                    <form action="/index.php" method="get">
                        <input name="module" value="Website" type="hidden">
                        <input name="action" value="Search" type="hidden">
                        <div class="logindata">
                            <input name="toFind" size="6" class="loginform" id="formfieldSearch">
                            &nbsp;
                            <input value="Search" id="searchboxbutton" type="submit">
                        </div>
                    </form>
                </div>
                <div class="leftbox" id="loginbox">
                    <form action="/index.php?module=Website&amp;action=Login" method="post">
                        <table class="logintable">
                            <tbody>
                            <tr>
                                <td colspan="2" class="loginhead">Member Login</td>
                            </tr>
                            <tr>
                                <td class="loginlabels">User Name:</td>
                                <td><input name="username" size="8" class="formfield" id="formfieldLoginUsername"></td>
                            </tr>
                            <tr>
                                <td class="loginlabels">Password:</td>
                                <td><input name="password" size="8" class="formfield" id="formfieldLoginPassword" type="password"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;"><input name="loginButton" value="Login" class="loginbutton" type="submit"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center;"><a href="https://leanhealth.org.au/Register/" class="loginLink">Register</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="leftbox" id="contactdetailsbox">
                    <!-- $Id: addressFormatAU.php,v 1.1 2007/01/02 03:38:43 borg Exp $ -->
                    Street Address<br>
                    Suburb&nbsp;Postcode<br>
                    STATE&nbsp;
                    Australia<br>
                    Tel Phone<br>
                    Fax Fax<br>
                    <a href="mailto:Email" class="contactdetailslink" title="Email">Email Us</a> </div>
            </td>

            <td id="mainbodycell">
                <div class="header-main-menu">
                    <?php echo $this->element('site_menu');?>
                </div>

                <table border="0" width="100%" id="mainbodytable">
                    <tbody>
                    <tr valign="top">
                        <td align="left" width="99%">





