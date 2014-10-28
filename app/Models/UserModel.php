<?php

namespace App\Models;

use DibiConnection;

class UserModel extends \Nette\Object
{
	const TABLE = 'user';


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
	 * @param string $email
	 * @return \DibiRow|FALSE
	 */
	public function findByEmail($email)
	{
		$query = $this->createQuery()
			->where(self::TABLE . '.email = %s', $email);

		return $query->fetch();
	}

	/**
	 * @param int $groupId
	 * @return \DibiRow|FALSE
	 */
	public function findByGroup($groupId)
	{
		$query = $this->createQuery();
		$query->join(GroupModel::USER_GROUP_TABLE)
			->on(self::TABLE . '.id = ' . GroupModel::USER_GROUP_TABLE . '.user_id')
			->where(GroupModel::USER_GROUP_TABLE . '.usergroup_id = %i', $groupId);

		return $query->fetchAll();
	}
	
	/**
	 * @param string $expresion
	 * @return \DibiRow|FALSE
	 */
	public function findByExpresion($expresion)
	{
		$query = $this->createQuery();
		$query->leftJoin(GroupModel::USER_GROUP_TABLE)
			->on(self::TABLE . '.id = ' . GroupModel::USER_GROUP_TABLE . '.user_id')
			->leftJoin(GroupModel::TABLE)
			->on(GroupModel::USER_GROUP_TABLE . '.usergroup_id = ' . GroupModel::TABLE . '.id')
			->where(self::TABLE . '.name LIKE %~like~', $expresion)
			->or(self::TABLE . '.surname LIKE %~like~', $expresion)
			->or(self::TABLE . '.email LIKE %~like~', $expresion)
			->or(GroupModel::TABLE . '.name LIKE %~like~', $expresion)
			->groupBy(self::TABLE . '.id');

		return $query->fetchAll();
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
}