<?php $outputGPIOReset = "";
if (isset($_POST["GPIOResetButton"]))
{
$outputGPIOReset = shell_exec(escapeshellcmd("sudo ".$pluginDirectory."/".$_GET['plugin']."/callbacks.py --reset"));
}
?>

<script type="text/javascript">
<!--
    function toggle(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>

<div id="Si4713detection" class="settings">
<fieldset>
<legend>Si4713 Detection</legend>

<div style="float: right; clear: right;">
<span style="float: right;"><a href="#" onclick="toggle('RPi_Pinout')">Click for Raspberry Pi GPIO#'s</a></span>
<a title="By Tux-Man (Own work) [CC0], via Wikimedia Commons" href="https://commons.wikimedia.org/wiki/File%3ARaspberry_Pi_Mle_B_-_GPIO.png">
<img id="RPi_Pinout" style="display: none" width="333" alt="Raspberry Pi Mle B - GPIO" src="https://upload.wikimedia.org/wikipedia/commons/f/fd/Raspberry_Pi_Mle_B_-_GPIO.png"/>
</a>
</div>

<?php exec("sudo i2cget -y 1 0x63", $output, $return_val); ?>
<p>Detecting Si4713:
<?php if (implode($output) != "Error: Read failed") : ?>
<span class='good'>Detected on I<sup>2</sup>C address 0x63</span>
<?php else: ?>
<span class='bad'>Not detected on I<sup>2</sup>C addresses 0x63</span> <!-- TODO: Check on 0x11 as well -->
<br />
The Si4713 must be reset after power on to be detected. Set the GPIO# for Reset, save, then Use the GPIO Reset.
<?php endif; ?>
</p>
<p>GPIO# (not pin number) for Reset: <?php PrintSettingText("GPIONumReset", 1, 0, 2, 2, "Si4713_FM_RDS", "4"); ?><?php PrintSettingSave("GPIONumReset", "GPIONumReset", 1, 0, "Si4713_FM_RDS"); ?></p>
<form method="post"><p><button name="GPIOResetButton">Execute GPIO Reset</button> <?php echo $outputGPIOReset; ?></p></form>

</fieldset>
</div>

<br />

<div id="Si4713Pluginsettings" class="settings">
<fieldset>
<legend>Si4713 Plugin Settings</legend>
<p>Start Si4713 at: <?php PrintSettingSelect("Start", "Start", 1, 0, "FPPDStart", Array("FPPD Start (default)"=>"FPPDStart", "Playlist Start"=>"PlaylistStart", "Never"=>"Never"), "Si4713_FM_RDS", ""); ?><br />
At Start, the Si4713 is reset, FM settings initialized, will broadcast any audio played, and send messages RDS (if enabled).</p>
<p>Stop Si4713 at: <?php PrintSettingSelect("Stop", "Stop", 1, 0, "Never", Array("Playlist Stop"=>"PlaylistStop", "Never (default)"=>"Never"), "Si4713_FM_RDS", ""); ?><br />
At Stop, the Si4713 is reset. Listeners will hear static.</p>
</fieldset>
</div>

<br />

<div id="Si4713FMsettings" class="settings">
<fieldset>
<legend>Si4713 FM Settings</legend>

<p>Frequency (76.00-108.00): <?php PrintSettingText("Frequency", 1, 0, 6, 6, "Si4713_FM_RDS", "100.10"); ?>MHz <?php PrintSettingSave("Frequency", "Frequency", 1, 0, "Si4713_FM_RDS"); ?></p>
<p>Power (88-115, 116-120<sup>*</sup>): <?php PrintSettingText("Power", 1, 0, 3, 3, "Si4713_FM_RDS", "90"); ?>dB&mu;V <?php PrintSettingSave("Power", "Power", 1, 0, "Si4713_FM_RDS"); ?>
<br /><sup>*</sup>Can be set as high as 120dB&mu;V, but voltage accuracy above 115dB&mu;V is not guaranteed.</p>
<p>Preemphasis: <?php PrintSettingSelect("Preemphasis", "Preemphasis", 1, 0, "75us", Array("50&mu;s (Europe, Australia, Japan)"=>"50us", "75&mu;s (USA, default)"=>"75us"), "Si4713_FM_RDS", ""); ?></p>
<p>Antenna Tuning Capacitor (0=Auto, 1-191): <?php PrintSettingText("AntCap", 1, 0, 3, 3, "Si4713_FM_RDS", "0"); ?> * 0.25pF <?php PrintSettingSave("AntCap", "AntCap", 1, 0, "Si4713_FM_RDS"); ?></p>
</fieldset>
</div>

<br />

<div id="Si4713RDSsettings" class="settings">
<fieldset>
<legend>Si4713 RDS Settings</legend>
<p>Enable RDS: <?php PrintSettingCheckbox("EnableRDS", "EnableRDS", 1, 0, "True", "False", "Si4713_FM_RDS", ""); ?></p>
<p>Difference between RDS Station and RDS Text</p>
<p>RDS Station - Sent 8 characters at a time</p>
<p>Delay between blocks (>3): <?php PrintSettingText("StationDelay", 1, 0, 3, 3, "Si4713_FM_RDS", "4"); ?>seconds <?php PrintSettingSave("StationDelay", "StationDelay", 1, 0, "Si4713_FM_RDS"); ?></p>
<p>Static Text (can be blank): <?php PrintSettingText("StationText", 1, 0, 64, 32, "Si4713_FM_RDS", " Happy  Hallo-     -ween"); ?><?php PrintSettingSave("StationText", "StationText", 1, 0, "Si4713_FM_RDS"); ?></p>
<p>Include Title: <?php PrintSettingCheckbox("StationTitle", "StationTitle", 1, 0, "True", "False", "Si4713_FM_RDS", ""); ?>
 --- Include Artist: <?php PrintSettingCheckbox("StationArtist", "StationArtist", 1, 0, "True", "False", "Si4713_FM_RDS", ""); ?>
 --- Include Track Number: <?php PrintSettingCheckbox("StationTrackNum", "StationTrackNum", 1, 0, "True", "False", "Si4713_FM_RDS", ""); ?></p>

<br />

<p>RDS Text - Sent 32 characters at a time</p>
<p>Delay between blocks (>3): <?php PrintSettingText("RDSTextDelay", 1, 0, 3, 3, "Si4713_FM_RDS", "7"); ?>seconds <?php PrintSettingSave("RDSTestDelay", "RDSTextDelay", 1, 0, "Si4713_FM_RDS"); ?></p>
<p>Static Text (can be blank): <?php PrintSettingText("RDSTextText", 1, 0, 64, 32, "Si4713_FM_RDS", ""); ?><?php PrintSettingSave("RDSTextText", "RDSTextText", 1, 0, "Si4713_FM_RDS"); ?></p>
<p>Include Title: <?php PrintSettingCheckbox("RDSTextTitle", "RDSTextTitle", 1, 0, "True", "False", "Si4713_FM_RDS", ""); ?>
 --- Include Artist: <?php PrintSettingCheckbox("RDSTextArtist", "RDSTextArtist", 1, 0, "True", "False", "Si4713_FM_RDS", ""); ?></p>
<p style="display: none"> --- Include Track Number: <?php PrintSettingCheckbox("RDSTextTrackNum", "RDSTextTrackNum", 1, 0, "True", "False", "Si4713_FM_RDS", ""); ?></p>
</fieldset>
</div>

<br />

<div id="Si4713Debug" class="settings">
<fieldset>
<legend>Si4713 Debugging</legend>
<p>TODO: Link to logs</p>
<input onclick= "ViewFile('Logs', ScriptNameSelected);" id="btnViewScript" class="disableButtons" type="button"  value="View" />
<p>TODO: Info about radio settings</p>
</fieldset>
</div>

<br />

<div id="Si4713Info" class="settings">
<fieldset>
<legend>Additional Si4713 Information</legend>
<p><a href="https://www.adafruit.com/product/1958">Adafruit Si4713 Breakout Board</a></p>
<p><a href="https://www.silabs.com/documents/public/data-sheets/Si4712-13-B30.pdf">Si4713 Datasheet</a></p>
<p><a href="https://www.silabs.com/documents/public/application-notes/AN332.pdf">Si4713 Programming Guide</a></p>
<p><a href="https://www.silabs.com/documents/public/user-guides/Si47xxEVB.pdf">Si4713 Evaluation Board Guide</a></p>
</fieldset>
<!-- last div intentionally skipped to fix footer background -->
