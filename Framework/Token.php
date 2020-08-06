<?php
namespace Blog\Framework;
/**
 * 
 */
class Token
{
	const TOKEN_VALIDITY_MINUTES = 1;

	const TOKEN_EXPIRATED = 3;
	const TOKEN_INVALID = 2;
	const TOKEN_VALID = 1;

	const TOKEN_GENERATION_TIME_KEY = 'tokenGenerationTime';
	const TOKEN_EXPIRATION_TIME_KEY = 'tokenExpirationTime';

	protected $tokenValue;
	protected $tokenGenerationDateTime;
	protected $tokenExpirationDateTime;

	public function __construct(int $tokenLength = 32)
	{
		$this->tokenValue              = bin2hex(openssl_random_pseudo_bytes($tokenLength));
		
		$this->tokenGenerationDateTime = new \DateTime();
		
		$this->tokenExpirationDateTime = clone $this->tokenGenerationDateTime;
		$this->tokenExpirationDateTime->modify('+ '.$this::TOKEN_VALIDITY_MINUTES.' minutes');
	}

	public function checkToken(string $tokenToCheck)
	{
		if (strcmp($this->tokenValue, $tokenToCheck) !== 0) {
			return $this::TOKEN_INVALID;
		}
		if ($this->tokenExpirationDateTime < new \DateTime()) {
			return $this::TOKEN_EXPIRATED;
		}
		return $this::TOKEN_VALID;
	}

	public function getTokenValue()
	{
		return $this->tokenValue;
	}
}