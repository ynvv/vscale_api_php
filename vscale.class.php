<?php

use \Unirest;

class Vscale {

	private $_token;
	private $_api;
	private $_json;


	function __construct($token, $json)
	{
		$this->_token = $token;
		$this->_api = 'https://api.vscale.io/v1/';
		$this->_json = $json;
	}


	private function sendRequest($method, $body, $type)
	{
		switch ($type) {
		    case 'get':
		        $data = Unirest\Request::get($this->_api.$method, ['X-Token' => $this->_token], $body);
		        var_dump($data->headers);
		        break;
		    case 'post':
		        $data = Unirest\Request::post($this->_api.$method, ['Content-Type' => 'application/json', 'X-Token' => $this->_token], json_encode($body));
		        break;
		    case 'patch':
		        $data = Unirest\Request::patch($this->_api.$method, ['X-Token' => $this->_token], $body);
		        break;
		    case 'delete':
		        $data = Unirest\Request::delete($this->_api.$method, ['X-Token' => $this->_token], $body);
		        break;
		    case 'put':
		        $data = Unirest\Request::put($this->_api.$method, ['X-Token' => $this->_token], $body);
		        break;    
		    default:
		       $data = Unirest\Request::get($this->_api.$method, ['X-Token' => $this->_token], $body);
		}
		var_dump($data->headers);
		if ($data->code === 403) {
			return ['type' => 'error', 'info' => 'invalid token'];
			exit;
		}
		if ($data->headers['VSCALE-ERROR-MESSAGE1'] == 'None') {
			return ['type' => 'error', 'info' => $data->headers['VSCALE-ERROR-MESSAGE']];
			exit;
		} else {
			return json_decode($data->raw_body, 1);
			exit;
		}
	}

	public function getAccountDetails()
	{
		return $this->sendRequest('account');
	}

	public function getScalets()
	{
		return $this->sendRequest('scalets');
	}

	public function createScalet($system, $plan, $name, $password, $location)
	{
		return $this->sendRequest('scalets', ['make_from' => $system, 'rplan' => $plan, 'do_start' => true, 'name' => $name, 'password' => $password, 'location' => $location], 'post');
	}

	public function getScaletInfo($scaletid)
	{
		return $this->sendRequest('scalets/'.$scaletid);
	}

	public function restartScalet($scaletid)
	{
		return $this->sendRequest('scalets/'.$scaletid. '/restart', ['id' => $scaletid], 'patch');
	}

	public function reinstallScalet($scaletid, $new_password)
	{
		return $this->sendRequest('scalets/'.$scaletid.'/rebuild', ['password' => $new_password], 'patch');
	}

	public function stopScalet($scaletid)
	{
		return $this->sendRequest('scalets/'.$scaletid.'/stop', ['id' => $scaletid], 'patch');
	}

	public function startScalet($scaletid)
	{
		return $this->sendRequest('scalets/'.$scaletid.'/start', ['id' => $scaletid], 'patch');
	}

	public function upgradeScalet($scaletid, $to_plan)
	{
		return $this->sendRequest('scalets/'.$scaletid.'/upgrade', ['rplan' => $to_plan], 'post');
	}

	public function deleteScalet($scaletid)
	{
		return $this->sendRequest('scalets/'.$scaletid, '', 'delete');
	}

	public function getTasks()
	{
		return $this->sendRequest('tasks');
	}

	public function addScaletKeys($scaletid, $keys)
	{
		return $this->sendRequest('scalets/'.$scaletid, ['keys' => $keys], 'patch');
	}

	public function createBackup($scaletid, $name)
	{
		return $this->sendRequest('scalets/'.$scaletid.'/backup', ['name' => $name], 'post');
	}

	public function restoreBackup($scaletid, $backup)
	{
		return $this->sendRequest('scalets/'.$scaletid.'/rebuild', ['make_from' => $backup], 'patch');
	}

	public function addTags($tagname, $scalets = null)
	{
		return $this->sendRequest('scalets/tags', ['name' => $tagname, 'scalets' => $scalets], 'post');
	}

	public function getTags()
	{
		return $this->sendRequest('scalets/tags');
	}

	public function getTagInfo($tagid)
	{
		return $this->sendRequest('scalets/tags/'.$tagid);
	}

	public function updateTag($tagid, $name = null, $scalets = null)
	{
		return $this->sendRequest('scalets/tags/'.$tagid, ['name' => $tagname, 'scalets' => $scalets], 'put');
	}

	public function deleteTag($tagid)
	{
		return $this->sendRequest('scalets/tags/'.$tagid, '', 'delete');
	}

	public function getBackupList()
	{
		return $this->sendRequest('backups');
	}

	public function getBackupInfo($backupid)
	{
		return $this->sendRequest('backups/'.$backupid);
	}

	public function deleteBackup($backupid)
	{
		return $this->sendRequest('backups/'.$backupid, '', 'delete');
	}

	public function relocateBackup($backupid, $to)
	{
		return $this->sendRequest('backups/'.$backupid.'/relocate', ['destination' => $to], 'post');
	}

	public function getLocations()
	{
		return $this->sendRequest('locations');
	}

	public function getImageList()
	{
		return $this->sendRequest('images');
	}

	public function getPlanList()
	{
		return $this->sendRequest('rplans');
	}

	public function getPrices()
	{
		return $this->sendRequest('billing/prices');
	}

	public function getSSHkeys()
	{
		return $this->sendRequest('sshkeys');
	}

	public function addSSHkey($name, $key)
	{
		return $this->sendRequest('sshkeys', ['name' => $name, 'key' => $key], 'post');
	}

	public function deleteSSHKey($keyid)
	{
		return $this->sendRequest('sshkeys/'.$keyid, '', 'delete');
	}

	public function getNotifyBalance()
	{
		return $this->sendRequest('billing/notify');
	}

	public function setNotifyBalance($value)
	{
		return $this->sendRequest('billing/notify', ['notify_balance' => $value], 'put');
	}

	public function getBalance()
	{
		return $this->sendRequest('billing/balance');
	}

	public function getPayments()
	{
		return $this->sendRequest('billing/payments');
	}

	public function getRangePayments($start, $end)
	{
		return $this->sendRequest('billing/consumption?start='.$start.'&end='.$end);
	}

	public function getDomainsList()
	{
		return $this->sendRequest('domains');
	}

	public function addDomain($domain)
	{
		return $this->sendRequest('domains', ['name' => $domain], 'post');
	}

	public function getDomainInfo($domainid)
	{
		return $this->sendRequest('domains/'.$domainid);
	}

	public function updateDomainInfo($domainid, $tags)
	{
		return $this->sendRequest('domains/'.$domainid, ['tags' => $tags], 'patch');
	}

	public function deleteDomain($domainid)
	{
		return $this->sendRequest('domains/'.$domainid, '', 'delete');
	}

	public function getDomainRecords($domainid)
	{
		return $this->sendRequest('domains/'.$domainid.'/records');
	}

	public function addDomainRecord($domainid, $domain, $type, $content, $ttl)
	{
		return $this->sendRequest('domains/'.$domainid.'/records', ['name' => $domain, 'type' => $type, 'content' => $content, 'ttl' => $ttl], 'post');
	}

	public function updateDomainRecord($domainid, $recordid, $domain, $type, $content, $ttl)
	{
		return $this->sendRequest('domains/'.$domainid.'/records/'.$recordid, ['name' => $domain, 'type' => $type, 'content' => $content, 'ttl' => $ttl], 'put');
	}

	public function deleteDomainRecord($domainid, $recordid)
	{
		return $this->sendRequest('domains/'.$domainid.'/records/'.$recordid, '', 'delete');
	}

	public function getDomainRecord($domainid, $recordid)
	{
		return $this->sendRequest('domains/'.$domainid.'/records/'.$recordid);
	}

	public function addDomainTag($tagname)
	{
		return $this->sendRequest('domains/tags', ['name' => $tagname], 'post');
	}

	public function getDomainTags()
	{
		return $this->sendRequest('domains/tags');
	}

	public function getDomainTagInfo($tagid)
	{
		return $this->sendRequest('domains/tags/'.$tagid);
	}

	public function updateDomainTag($tagid, $name, $domains)
	{
		return $this->sendRequest('domains/tags/'.$tagid, ['name' => $name, 'domains' => $domains], 'put');
	}

	public function deleteDomainTag($tagid)
	{
		return $this->sendRequest('domains/tags/'.$tagid, '', 'delete');
	}

	public function addPTRrecord($ip, $content)
	{
		return $this->sendRequest('domains/ptr', ['ip' => $ip, 'content' => $content], 'post');
	}

	public function getPTRrecords()
	{
		return $this->sendRequest('domains/ptr');
	}

	public function updatePTRrecord($ptrid, $ip, $content)
	{
		return $this->sendRequest('domains/ptr/'.$ptrid, ['ip' => $ip, 'content' => $content], 'put');
	}

	public function deletePTRrecord($ptrid)
	{
		return $this->sendRequest('domains/ptr/'.$ptrid, '', 'delete');
	}


}
