<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Description of response
 *
 * @author Eugene Dounar <e.dounar@smartdesign.by>
 */
abstract class Download_Result
{
	protected $raw_headers = '';
	protected $info = array();
	protected $error_code = 0;
	protected $headers = array();

	final public function __write_header($curl, $bytes)
	{
		$this->raw_headers .= $bytes;
		return strlen($bytes);
	}

	public function load($info, $content, $error_code)
	{
		$this->info = $info;
		$this->error_code = $error_code;
		$this->headers = explode("\r\n\r\n", $this->raw_headers);
		
		// Headers end with \r\n\r\n - so last element of array is an empty string
		array_pop($this->headers);
	}

	/**
	 * Get the body of last HTTP response
	 * 
	 * @return string
	 */
	abstract public function get_contents();

	/**
	 * Get headers for last performed HTTP Request
	 * @return string
	 */
	final public function get_headers()
	{
		return end($this->headers);
	}

	/**
	 * Get an array of all headers received while downloading the task
	 * including redirection headers and etc
	 * 
	 * @return array
	 */
	final public function get_all_headers()
	{
		return $this->headers;
	}

	/**
	 * cURL error code. See http://curl.haxx.se/libcurl/c/libcurl-errors.html
	 * @return integer
	 */
	final public function get_error_code()
	{
		return $this->error_code;
	}

	/**
	 * Get any info about download. Last url, download speed, content-type etc..
	 * For list of available keys see curl_getinfo() result
	 * @param string $key curl_getinfo() result key
	 * @return string 
	 */
	final public function get_info($key)
	{
		if (isset($this->info[$key]))
		{
			return $this->info[$key];
		}
		else
		{
			return NULL;
		}
	}

	final public function error()
	{
		$descriptions = array(
				0 => "OK",
				1 => "The URL you passed to libcurl used a protocol that this libcurl does not support. The support might be a compile-time option that you didn't use, it can be a misspelled protocol string or just a protocol libcurl has no code for.",
				2 => "Very early initialization code failed. This is likely to be an internal error or problem.",
				3 => "The URL was not properly formatted.",
				5 => "Couldn't resolve proxy. The given proxy host could not be resolved.",
				6 => "Couldn't resolve host. The given remote host was not resolved.",
				7 => "Failed to connect() to host or proxy.",
				8 => "After connecting to a FTP server, libcurl expects to get a certain reply back. This error code implies that it got a strange or bad reply. The given remote server is probably not an OK FTP server.",
				9 => "We were denied access to the resource given in the URL. For FTP, this occurs while trying to change to the remote directory.",
				11 => "After having sent the FTP password to the server, libcurl expects a proper reply. This error code indicates that an unexpected code was returned.",
				13 => "libcurl failed to get a sensible result back from the server as a response to either a PASV or a EPSV command. The server is flawed.",
				15 => "An internal failure to lookup the host used for the new connection.",
				17 => "Received an error when trying to set the transfer mode to binary or ASCII.",
				18 => "A file transfer was shorter or larger than expected. This happens when the server first reports an expected transfer size, and then delivers data that doesn't match the previously given size.",
				19 => "This was either a weird reply to a 'RETR' command or a zero byte transfer complete.",
				21 => "When sending custom \"QUOTE\" commands to the remote server, one of the commands returned an error code that was 400 or higher (for FTP) or otherwise indicated unsuccessful completion of the command.",
				22 => "This is returned if CURLOPT_FAILONERROR is set TRUE and the HTTP server returns an error code that is >= 400. (This error code was formerly known as CURLE_HTTP_NOT_FOUND.)",
				23 => "An error occurred when writing received data to a local file, or an error was returned to libcurl from a write callback.",
				25 => "Failed starting the upload. For FTP, the server typically denied the STOR command. The error buffer usually contains the server's explanation for this. (This error code was formerly known as CURLE_FTP_COULDNT_STOR_FILE.)",
				26 => "There was a problem reading a local file or an error returned by the read callback.",
				27 => "A memory allocation request failed. This is serious badness and things are severely screwed up if this ever occurs.",
				28 => "Operation timeout. The specified time-out period was reached according to the conditions.",
				30 => "The FTP PORT command returned error. This mostly happens when you haven't specified a good enough address for libcurl to use. See CURLOPT_FTPPORT.",
				31 => "The FTP REST command returned error. This should never happen if the server is sane.",
				33 => "The server does not support or accept range requests.",
				34 => "This is an odd error that mainly occurs due to internal confusion.",
				35 => "A problem occurred somewhere in the SSL/TLS handshake. You really want the error buffer and read the message there as it pinpoints the problem slightly more. Could be certificates (file formats, paths, permissions), passwords, and others.",
				36 => "Attempting FTP resume beyond file size.",
				37 => "A file given with FILE:// couldn't be opened. Most likely because the file path doesn't identify an existing file. Did you check file permissions?",
				38 => "LDAP cannot bind. LDAP bind operation failed.",
				39 => "LDAP search failed.",
				41 => "Function not found. A required zlib function was not found.",
				42 => "Aborted by callback. A callback returned \"abort\" to libcurl.",
				43 => "Internal error. A function was called with a bad parameter.",
				45 => "Interface error. A specified outgoing interface could not be used. Set which interface to use for outgoing connections' source IP address with CURLOPT_INTERFACE. (This error code was formerly known as CURLE_HTTP_PORT_FAILED.)",
				47 => "Too many redirects. When following redirects, libcurl hit the maximum amount. Set your limit with CURLOPT_MAXREDIRS.",
				48 => "An option set with CURLOPT_TELNETOPTIONS was not recognized/known. Refer to the appropriate documentation.",
				49 => "A telnet option string was Illegally formatted.",
				51 => "The remote server's SSL certificate or SSH md5 fingerprint was deemed not OK.",
				52 => "Nothing was returned from the server, and under the circumstances, getting nothing is considered an error.",
				53 => "The specified crypto engine wasn't found.",
				54 => "Failed setting the selected SSL crypto engine as default!",
				55 => "Failed sending network data.",
				56 => "Failure with receiving network data.",
				58 => "problem with the local client certificate.",
				59 => "Couldn't use specified cipher.",
				60 => "Peer certificate cannot be authenticated with known CA certificates.",
				61 => "Unrecognized transfer encoding.",
				62 => "Invalid LDAP URL.",
				63 => "Maximum file size exceeded.",
				64 => "Requested FTP SSL level failed.",
				65 => "When doing a send operation curl had to rewind the data to retransmit, but the rewinding operation failed.",
				66 => "Initiating the SSL Engine failed.",
				67 => "The remote server denied curl to login",
				68 => "File not found on TFTP server.",
				69 => "Permission problem on TFTP server.",
				70 => "Out of disk space on the server.",
				71 => "Illegal TFTP operation.",
				72 => "Unknown TFTP transfer ID.",
				73 => "File already exists and will not be overwritten.",
				74 => "This error should never be returned by a properly functioning TFTP server.",
				75 => "Character conversion failed.",
				76 => "Caller must register conversion callbacks.",
				77 => "Problem with reading the SSL CA cert (path? access rights?)",
				78 => "The resource referenced in the URL does not exist.",
				79 => "An unspecified error occurred during the SSH session.",
				80 => "Failed to shut down the SSL connection.",
				81 => "Socket is not ready for send/recv wait till it's ready and try again. This return code is only returned from curl_easy_recv(3) and curl_easy_send(3)",
				82 => "Failed to load CRL file",
				83 => "Issuer check failed",
		);

		if (isset($descriptions[$this->error_code]))
		{
			return $descriptions[$this->error_code];
		}
		else
		{
			return 'Unknown error';
		}
	}
}

