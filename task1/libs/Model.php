<?php
class Model
{
	protected $mArray = array();
    protected $errors = array();
    
    public function __construct()
	{
		$this->mArray = array(
			'%TITLE%'=>'Contact Form',
			'%ERRORS%'=>'Empty field',
			'%NAME%'=>'',
			'%EMAIL%'=>'',
			'%NONE%' =>'',
			'%TECH%'=>'',
			'%PSYCH%'=>'',
			'%FINANC%'=>'',
			'%SOS%'=>'',
			'%MSG%'=>''
		);
        
        if (empty($this->mArray))
        {
            throw new ModelException('Can not get templates for html.');
        }
	}
	
	public function getArray()
	{
		return $this->mArray;
	}
	
	public function checkForm()
	{
        foreach ($_POST as $key => $val)
        {
            $val = strip_tags(trim($val));
            
            if ($this->checkField($key, $val))
            {
                if ('subject' === $key)
                {
                    $this->mArray['%'.strtoupper($val).'%'] = 'selected=""';
                    continue;
                }
                $this->mArray['%'.strtoupper($key).'%'] = $val;
            }
        }
        
        if (0 < count($this->errors))
        {
            $this->mArray['%ERRORS%'] = "Form filling errors:<br>".implode("<br>", $this->errors);
            return false;
        }
        else
        {
            return true;
        }
	}
	
	public function sendEmail()
	{
        $subject = "New ticket from site \"".SITENAME."\"";
        $mail = "New ticket from site \"".SITENAME."\".".PHP_EOL."
        User data:".PHP_EOL."
        - name: " . $this->mArray['%NAME%'] . PHP_EOL ."
        - email: " . $this->mArray['%EMAIL%'] . PHP_EOL . "
        - subject: " . $_POST['subject'] . PHP_EOL ."
        - message: " . $this->mArray['%MSG%'] . PHP_EOL . "
		- ip-address: " . $_SERVER['REMOTE_ADDR']. PHP_EOL . "
		- date: " . $_COOKIE['date'];
        
        $headers = "MIME-Version: 1.0 \r\n"; 
        $headers .= "Content-type: text/plain; charset=utf-8 \r\n";
        $headers .= "FROM: ".SITENAME." <". ADMIN .">\r\n";
        $headers .= "Reply-To: ".$this->mArray['%NAME%']." <". $this->mArray['%EMAIL%'] .">\r\n";
            
        if (mail(ADMIN, $subject, $mail, $headers))
        {
            header('Location: '.PATH);
        }
        else
        {
            $this->mArray['%ERRORS%'] = "Mail is not send. Try again.";
            return false;
        }
	}
    
    protected function checkField($key, $val)
    {
        if ('name' === $key && 3 >= strlen($val))
        {
            $this->errors[] = 'Invalid field "name"';
            return false;
        }
        
        if ('email' === $key && (6 >= strlen($val) || (false === strpos($val, '@')) || (false === strpos($val, '.'))))
		{
			$this->errors[] = 'Invalid field "email"';
            return false;
		}
        
        if ('msg' === $key && 10 >= strlen($val))
		{
			$this->errors[] = 'Invalid field "message"';
            return false;
		}
        
        if ('subject' === $key && 'none' === $val)
		{
			$this->errors[] = 'Invalid field "subject"';
            return false;
		}
        
        return true;
    }
}
?>