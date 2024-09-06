<?php
namespace App\Utility;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailUtility
{
    
    public static function sendMail($user_id, $recordModel,$recordId)
    {

        try{
            $email_body = "";
            $user           = User::where('id',$user_id)->first();
            $appointment_email           = 'test@mail.com';
            $recordModelData        = $recordModel::where('id',$recordId)->first();
            $subject        = 'Your appointment has been booked <dental@test.com>';
            $email_body .= "
					<section style='width: 99%;
					height: 100%;
					float: left;
					text-align: center;
					border: 1px solid #efc300;
					background: #cccccc78;'>
						<div style='background: #efc300;
						margin: 0;
						padding: 0;'>
							<h3 style='line-height: unset;
							margin: 0;
							padding: 10px 0;
							font-size: 22px;
							margin-block-start: 0;
							margin-block-end: 0;'>Welcome to dental@test.com</h3>
						</div>

						<div style='width: 100%;
						float: left;
						color: #fff;
						background: #151515;'>
							<div style='width:50%;float: left;text-align: left;'>
								<img style='width: 150px;margin: auto;text-align: center;padding: 20px;' src='".static_asset('assets/images/logo.png')."' />
							</div>
							<div style='width:50%;float: left;'>
								<p style='text-align: right;font-size: 18px; padding-right: 20px;'>HMH Executive Hire</p>
								<p style='text-align: right;font-size: 18px; padding-right: 20px;'>+44 333 577 5253</p>
							</div>
						</div>

						<div style='width:100%;float: left;text-align: left;
						padding-left: 15px;'>
							<h4>Dear <strong>".$user->name."</strong>,</h4>
							<p>Thank you for appointment our service.</p>
							<p>Please check bellow about your appointment details.</p>
						</div>

						<div style='width:100%;float: left;'>
							<table class='eletetb' style='width:95%;border-collapse: collapse;text-align: left;margin: auto;'>

							

                <tr>
					<td style='padding-left: 12px;border-top: 1px solid #efc300;
					border-bottom: 1px solid #efc300;
					border-right: 1px solid #efc300;padding-top: 4px;
					padding-bottom: 4px;font-size: 16px;border-left: 1px solid #efc300;background: #fff;'>
					appointment Type:
					</td>
					<td style='padding-left: 12px;border-top: 1px solid #efc300;
					border-bottom: 1px solid #efc300;padding-top: 4px;
					padding-bottom: 4px;font-size: 15px;border-right: 1px solid #efc300;background: #fff;'>
					".$user->name."
					</td>
				</tr>


							</table>
						</div>

						<div style='float: left;width:100%;    padding-left: 12px;
						text-align: left;'>
							<p>if you have any problem, feel free to contact with us mail us: <strong>appointment@dental@test.com</strong></p>
							<p>Thank you for choosing our service and hope to see you again.</p>
							<p>Have a nice journey!</p>
							<p>Kind Regards</p>
							<p>TEST</p>
						</div>
					</section>
				";

            /*Notification::send(array($user, $appointment_email), new EmailNotification($subject, $email_body));
            return true;*/

            $mail = new PHPMailer;

            $mail->isSendmail();

            /*$mail->isSMTP();
            $mail->SMTPDebug = false;
            $mail->Debugoutput = 'html';
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;*/

            $mail->Username = 'test@gmail.com';
            $mail->Password = '3454';
            $mail->setFrom('appointment@dental@test.com', 'DENT SOFT');
            $mail->addAddress($user->email); //call this multiple times for multiple recipients
            $mail->addAddress('appointment@dental@test.com'); //call this multiple times for multiple recipients
            $mail->Subject = $subject;
            $mail->msgHTML($email_body);
            $mail->send();
        }
        catch(\Exception $e){
            dump($e->getMessage());

            // dd($e);
        }
    }

}

?>
