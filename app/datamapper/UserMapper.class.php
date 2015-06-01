<?php

/**
 * This is the user mapper
 *
 * @package    timetable
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 **/

namespace datamapper;

use datamapper\Mapper;
use model\User;

class UserMapper extends Mapper {
	/**
	 * Mapper singleton
	 **/
	protected static $singleton = null;

	/**
	 * Returns a single user by his identifier
	 *
	 * @param int $id
	 * @param bool $ignoreSuperusers (optional) 
	 * @throws UnexpectedValueException
	 * @return model\User
	 **/
	public function getUserByID($id, $ignoreSuperusers = false) {
		$where = $ignoreSuperusers ? 'AND `isSuperuser` = 0' : '';
		$stmt = $this->db->prepare(sprintf('
			SELECT * FROM `user`
			WHERE `id` = ? %s
			LIMIT 1
		', $where));

		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();

		if (!$result->num_rows) {
			throw new UnexpectedValueException('No user with this ID found');
		} else {
			$data = $result->fetch_assoc();
			return User::fillFromRowData($data);
		}
	}

	/**
	 * Returns a single user by his username
	 *
	 * @param string $username
	 * @throws UnexpectedValueException
	 * @return model\User
	 **/
	public function getUserByUsername($username) {
		$stmt = $this->db->prepare("
			SELECT * FROM `user`
			WHERE `username` = ?
			LIMIT 1
		");

		$stmt->bind_param('s', $username);
		$stmt->execute();

		$result = $stmt->get_result();

		if (!$result->num_rows) {
			throw new UnexpectedValueException('No user with this username found');
		} else {
			$data = $result->fetch_assoc();
			return User::fillFromRowData($data);
		}
	}

	/**
	 * Returns an array of all users
	 *
	 * @param bool $ignoreSuperusers (optional)
	 * @return array
	 **/
	public function getUsers($ignoreSuperusers = false) {
		$where = $ignoreSuperusers ? 'WHERE `isSuperuser` = 0' : '';
		$stmt = $this->db->prepare(sprintf("SELECT * FROM `user` %s", $where));
		$stmt->execute();

		$result = $stmt->get_result();
		$users = array();

		if ($result->num_rows) {
			while ($row = $result->fetch_assoc()) {
				$users[] = User::fillFromRowData($row);
			}
		}

		return $users;
	}

	/**
	 * Updates or creates an user
	 *
	 * @param model\User $user
	 **/
	public function save(model\User $user) {
		if (!$user->id) {
			$stmt = $this->db->prepare("
				INSERT INTO `user` (`username`, `firstName`, `lastName`, `password`, `isSuperuser`) VALUES (
					?, ?, ?, ?, ?
				)
			");

			$stmt->bind_param(
				'ssssi',
				$user->username,
				$user->firstName,
				$user->lastName,
				$user->password,
				$user->isSuperuser
			);
		}
		else {
			$stmt = $this->db->prepare("
				UPDATE `user` SET 
					`firstName`= ?,
					`lastName` = ?,
					`password` = ?,
					`isSuperuser` = ?
				WHERE `id` = ?
				");

			$stmt->bind_param(
				'sssii',
				$user->firstName,
				$user->lastName,
				$user->password,
				$user->isSuperuser,
				$user->id
			);
		}

		$stmt->execute();

		if (!$user->id) {
			$user->id = $this->db->insert_id;
		}
	}

	/**
	 * Deletes an user
	 *
	 * @param int $id
	 **/
	public function delete($id) {
		$stmt = $this->db->prepare("DELETE FROM `user` WHERE `id` = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
}
