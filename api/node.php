<?php


// node.php

// class for managining nodes
require_once('vtoken.php');

class NODE
{

	private $fields;
	private $table = 'nodes';

	function __construct()
	{
		$this->fields['nodeId'] = 0;
		$this->fields['data'] = '';
		$this->fields['ownerId'] = 0;
		$this->fields['groupId'] = 0;
		$this->fields['access'] = 0;
		$this->fields['type'] = 'default';
	}


	function create($fields, VCRUD $c)
	{
		return $c->create($this->table, $fields);
	}

	function read($conditions, VCRUD $c)
	{
		return $c->read($this->table, $conditions);
	}

	function update($fields, $conditions, VCRUD $c)
	{
		return $c->update($this->table, $fields, $conditions);
	}

	function delete()
	{
		// no.
	}

	function get($field)
	{
		return $this->fields[$field] ?? null;
	}

	function set($field, $value)
	{
		$this->fields[$field] = $value;
	}

	function getParents(VCRUD $c)
	{
		$parents = $c->read('links', ['childId', '=', $this->fields['nodeId']]);
		$parentIds = [];
		foreach ($parents as $parent) {
			$parentIds[] = $parent['parentId'];
		}
		return $parentIds;
	}

	function getChildren(VCRUD $c)
	{
		$children = $c->read('links', ['parentId', '=', $this->fields['nodeId']]);
		$childrenIds = [];
		foreach ($children as $child) {
			$childrenIds[] = $child['childId'];
		}
		return $childrenIds;
	}


	function processRead(VCRUD $c)
	{
		// do we have a token?
		$token = new VTOKEN();
		$userId = $token->getUserIdFromToken(($_REQUEST['token'] ?? ''), $c);
		if ($userId) {
			$nodeId = htmlspecialchars($_REQUEST['nodeId'] ?? 0);
		} else {
		}
		$nodeId = htmlspecialchars($_REQUEST['nodeId'] ?? 0);
		return [
			'status' => 'ok',
			'node' => $this->read(['nodeId', '=', $nodeId], $c)
		];
	}
}
