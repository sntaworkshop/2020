<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>SNTA 2020 file upload</title>
        <link href="dataupload.css" rel="stylesheet" type="text/css" />
        <script src="dataupload.js"></script>
    </head>
    <body>
        <center><table width=600><tr><td>
        <header>
            <table><tr>
            <td><h2>SNTA 2020 file upload</h2></td>
            <td><a href="https://sdm.lbl.gov/snta/" class="stuts">Back to SNTA 2020 program</a><br>
		    <a href="https://sdm.lbl.gov/snta/2020/talks/" class="stuts2">Back to the uploadpage</a></td>
            </tr></table>
        </header>
		
		<?php
		$myname = $_POST['myname'];
		$mycompany = $_POST['mycompany'];
		$myemail = $_POST['myemail'];
		if (empty($_POST["myname"])) {
			die ("Your name cannot be empty.");
		}
		if (!preg_match("/^[a-zA-Z ]*$/",$myname)) {
			die ("Only letters and white space allowed");
		}
		if (empty($_POST["mycompany"])) {
			die ("Your institution cannot be empty.");
		}
		if (empty($_POST["myemail"])) {
			die ("Your email address cannot be empty.");
		}
		if (!filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
			die ("Invalid email format.");
		}

		$accesslog = "./logs/download.html";
		$fp = fopen($accesslog, "a") or die("Please report the problem to asim@lbl.gov.");
		$mydates=date('m/d/Y l H:i:s T');
		$myoutput=$mydates." - ".$_SERVER['REMOTE_ADDR']." - ".gethostbyaddr($_SERVER['REMOTE_ADDR'])." - ".$myname." / ".$mycompany." / ".$myemail."<br>\n";
		fwrite($fp, $myoutput);
		fclose($fp);

		$myagree = $_POST['ackDisclaimer'];
		$mycheck = (int)$_POST['MYCHECKS'];
		$mychecknum = (int)$_POST['MYCHECKSNUM'];
		$mykey = $_POST['MYKEY'];

		if ($mycheck != 2020 ) {
		    die ("The current year input wasn't entered correctly. Go back and try it again.");
		} elseif ($mychecknum != 36 ) {
		    die ("The arithmetic answer wasn't entered correctly. Go back and try it again.");
		} elseif (
                  ($mykey != "greatsnta2020") and 
                  ($mykey != "snta20tamuc") 
                 ) {
		    die ("$mykey, The personal key does not match. Go back and try it again.");
		} 

		?>
		
        <div class="container">
            <div class="contr"><h3>You can select the pre-recorded presentation file (or slide file) and click Upload button</h3></div>

            <div class="upload_form_cont">
                <form id="upload_form" enctype="multipart/form-data" method="post" action="dataupload.php">
                    <div>
                        <div><label for="upload_file">Please select your file</label></div>
                        <div><input type="file" name="upload_file" id="upload_file" onchange="fileSelected();" /></div>
                    </div>
                    <div>
                        <input type="button" value="Upload" onclick="startUploading()" />
                    </div>
                    <div id="fileinfo">
                        <div id="filename"></div>
                        <div id="filesize"></div>
                        <div id="filetype"></div>
                        <div id="filedim"></div>
                    </div>
                    <div id="error">You should select valid files only!</div>
                    <div id="error2">An error occurred while uploading the file</div>
                    <div id="abort">The upload has been canceled by the user or the browser dropped the connection</div>
                    <div id="warnsize">Your file is very big. We can't accept it. Please select more small file or contact Alex.</div>

                    <div id="progress_info">
                        <div id="progress"></div>
                        <div id="progress_percent">&nbsp;</div>
                        <div class="clear_both"></div>
                        <div>
                            <div id="speed">&nbsp;</div>
                            <div id="remaining">&nbsp;</div>
                            <div id="b_transfered">&nbsp;</div>
                            <div class="clear_both"></div>
                        </div>
                        <div id="upload_response"></div>
                    </div>
                </form>

                <!-- ><img id="preview" /> -->
            </div>
        </div>
		
<!--
		<A href="#" onClick="window.history.back();return false;"><H2 class="centered">Return to the previous page</H2></A>
-->
		</p>
		<font size="-1">
		<?php
		include 'footer.html'
		?>
		</font>
        </td></tr></table></center>
    </body>
</html>
