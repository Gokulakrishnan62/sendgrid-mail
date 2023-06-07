<?php 

namespace SGM\app\Controllers;

class Menu
{
    function showing_menu() 
	{
		add_menu_page(
			__( 'Email Page',''),
			'Email',
			'manage_options',
			'slug',
			array($this,"email_page"),
			'',
			34
		);
	}

    function  email_page()
	{
		if(file_exists(SGM_PLUGIN_PATH . '/app/Views/form.php')) 
        {
			include (SGM_PLUGIN_PATH . '/app/Views/form.php');
        } 
        else 
        {
            wp_die('Error during show the email menu page');
        }
    }

    function sendgrid_mail()
    {
			if (isset($_POST) && !empty($_POST) && check_admin_referer('SGM_email_form') ) 
			{
				// sanitizing inputs
				$to = sanitize_email($_POST['SGM_email']);
				$subject = sanitize_text_field($_POST['SGM_subject']);
				$message = sanitize_textarea_field($_POST['SGM_message']);

				// validate Email
				if ((!filter_var($to, FILTER_VALIDATE_EMAIL)))
				{
					add_action('admin_notices', [$this,'email_error_notice_email']);
					return;
				}
					
				// Validate Subject
				if (empty($subject)) 
				{
					add_action('admin_notices', [$this,'email_error_notice_subject']);
					return;
				}

				// Validate Message
				if (empty($message)) 
				{
					add_action('admin_notices', [$this,'email_error_notice_message']);
					return;
				}

				
				//add_action('admin_notices', [$this,'show_success_message']);
				$this->sendgrid_send_email_check($to, $subject, $message);
				

			}

    }

	function email_error_notice_email()
	{
		?>
		<div class="notice notice-error is-dismissible">
			<p>Error in e-mail.</p>
		</div>
		<?php
	}

	function email_error_notice_subject()
	{
		?>
		<div class="notice notice-error is-dismissible">
			<p>Error occurs in Subject.</p>
		</div>
		<?php
	}

	function email_error_notice_message()
	{
		?>
		<div class="notice notice-error is-dismissible">
			<p>Error occurs in message.</p>
		</div>
		<?php
	}

	function show_success_message() 
	{
		?>
		<div class="notice notice-success is-dismissible">
			<p>Email send Successfully.</p>
		</div>
		<?php
	}

	function email_not_send_notice() 
	{
		?>
		<div class="notice notice-error is-dismissible">
			<p>Email not send.</p>
		</div>
		<?php
	}

	function sendgrid_send_email_check($to, $subject, $message) 
	{
		if($this->sendgrid_send_email($to, $subject, $message))
		{
			add_action('admin_notices', [$this,'show_success_message']);

		} else 
		{
			add_action('admin_notices', [$this,'email_not_send_notice']);
		}
	}
	

	function sendgrid_send_email($to, $subject, $message) 
	{
	
		// SendGrid API endpoint
		$url='https://api.sendgrid.com/v3/mail/send';
	
		// Request headers
		$headers = array(
			'Content-Type'=> 'application/json',
			'Authorization'=> 'Bearer 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'
		);
	
		// Request data
		$data = array(
			'personalizations' => array(
				array(
					'to' => array(
						array('email' => $to)
					)
				)
			),
			'from' => array(
				'email' => 'nivithann06@gmail.com'
			),
			'subject' => $subject,
			'content' => array(
				array(
					'type' => 'text/plain',
					'value' => $message
				)
			)
		);

		$response = wp_remote_post($url, array(
			'body' => wp_json_encode($data),
			'headers' =>  $headers
		));
		
		
		 if($response['response']['code'] == 202)
		 {
			print_r($response['response']['code']);
			return true;
		 }
		 else
		 {
			return false;
		 }
		
		
	}


}











