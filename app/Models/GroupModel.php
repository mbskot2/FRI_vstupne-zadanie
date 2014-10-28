<?php

namespace App\Models;

use DibiConnection;

class GroupModel extends \Nette\Object
{
	const TABLE = 'usergroup';
	const USER_GROUP_TABLE = 'user_usergroup';

	/**
	 * @var \DibiConnection
	 */
	private $database;


	/**
	 * @param \DibiConnection
	 */
	public function __construct(DibiConnection $database)
	{
		$this->database = $database;
	}

	/**
	 * @return \DibiFluent
	 */
	public function createQuery()
	{
		$query = $this->database->select(self::TABLE . '.*')
			->from(self::TABLE);

		return $query;
	}

	/**
	 * @param int $id
	 * @return \DibiRow|FALSE
	 */
	public function find($id)
	{
		$query = $this->createQuery()
			->where(self::TABLE . '.id = %i', $id);

		return $query->fetch();
	}

	/**
	 * @param string $name
	 * @return \DibiRow|FALSE
	 */
	public function findByName($name)
	{
		$query = $this->createQuery()
			->where(self::TABLE . '.name = %s', $name);

		return $query->fetch();
	}

	/**
	 * @param string $userId
	 * @return \DibiFluent
	 */
	public function findByUser($userId)
	{
		$query = $this->createQuery();
		$query->join(self::USER_GROUP_TABLE)
			->on(self::TABLE . '.id = ' . self::USER_GROUP_TABLE . '.usergroup_id')
			->where(self::USER_GROUP_TABLE . '.user_id = %i', $userId);

		return $query;
	}

	/**
	 * @return array
	 */
	public function findAll()
	{
		return $this->createQuery()->fetchAll();
	}

	/**
	 * @param array|\DibiRow $user
	 * @return bool
	 */
	public function save(&$user)
	{
		if (!isset($user['id']))
		{
			$this->database->insert(self::TABLE, $user)
				->execute();

			$user['id'] = $this->database->getInsertId();
		}
		else
		{
			$this->database->update(self::TABLE, $user)
				->where(self::TABLE, '.id = %i', $user['id'])
				->execute();
		}

		return $this->database->getAffectedRows() == 1;
	}

	/**
	 * @param int $id
	 * @return bool
	 */
	public function delete($id)
	{
		$this->database->delete(self::TABLE)
			->where(self::TABLE . '.id = %i', $id)
			->execute();

		return $this->database->getAffectedRows() == 1;
	}

	/**
	 * @param int $groupId
	 * @param int $userId
	 * @return bool
	 */
	public function addUserToGroup($groupId, $userId)
	{
		$args = array(
			UserModel::TABLE . '_id' => $userId,
			GroupModel::TABLE . '_id' => $groupId
		);

		$this->database->insert(self::USER_GROUP_TABLE, $args)
			->execute();

		return $this->database->getAffectedRows() == 1;
	}

	/**
	 * @param int $groupId
	 * @param int $userId
	 * @return bool
	 */
	public function removeUserFromGroup($groupId, $userId)
	{
		$this->database->delete(self::USER_GROUP_TABLE)
			->where(self::USER_GROUP_TABLE . '.' . UserModel::TABLE . '_id = %i', $userId)
			->where(self::USER_GROUP_TABLE . '.' . GroupModel::TABLE . '_id = %i', $groupId)
			->execute();

		return $this->database->getAffectedRows() == 1;
	}
}