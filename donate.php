<?php
require("loggedin.php");
$id = mysql_real_escape_string($_SESSION['id']);
$userC = mysql_query("SELECT nation FROM players WHERE id='$id'");
$userF = mysql_fetch_array($userC);
$nation = $userF['nation'];
?>
<div id="title">Donations</div>
If you'd like to donate money to Pixel Nations, you may do so below. Donations are not required, Pixel Nations is 100% free to play. Players can receive in-game benefits for donation, but on the off-chance something goes wrong I will reserve the right to choose whether or not to give benefits. Donations are donations, and are non-refundable. Any benefits should be processed within 24 hours.
<br /><br />
<b>Note:</b> You will only receive an in-game bonus for a donation every <b>3 days</b>. To clarify, if you donate today, you will receive your bonus but if you donate in the next day 3 days afterward you will not get a bonus. This is to prevent anyone from getting a ridiculous amount of in-game bonuses.
<br />
<?php
$diff10 = abs(strtotime($userF['donate_date']) - strtotime(date(c)));
$hours10 = round($diff10/60/60/24);
if($hours10 < 3) {
$donate = "<p style='color:#FF0000;'>You are currently not eligible for donation bonuses.</p>";
} if($hours10 >= 3) {
$donate = "<p style='color:green;'>You are eligible for donation bonuses.</p>";
}
echo $donate;
?>
<br />
<center><table>
<tr><td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="5EX4N2PZ4CXJE">
<input type="hidden" name="custom" value="<?php echo $nation; ?>">
<input type="hidden" name="item_number" value="<?php echo $nation; ?>">
<input type="image" style="border:none; background:#FFF" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></td><td>$5 Donation - Up to $5,000,000 in-game money. Please make sure to specify your nation name when donating.</td></tr>
<tr><td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="RZRTNY7D87KMS">
<input type="hidden" name="custom" value="<?php echo $nation; ?>">
<input type="hidden" name="item_number" value="<?php echo $nation; ?>">
<input type="image" style="border:none; background:#FFF" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</td><td>$10 Donation - Up to $12,000,000 in-game money. Please make sure to specify your nation name when donating.</td></tr>
<tr><td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="63XTJ28BR2KZS">
<input type="hidden" name="custom" value="<?php echo $nation; ?>">
<input type="hidden" name="item_number" value="<?php echo $nation; ?>">
<input type="image" style="border:none; background:#FFF" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</td><td>$20 Donation - Up to $25,000,000 in-game money. Please make sure to specify your nation name when donating.</td></tr>
</table>