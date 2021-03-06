<?php

/**
 * This is the user mapper
 *
 * @author     Jonas Metzener <jonasmetzener@gmail.com>
 * @author     Fabian Jäiser <fabian.jaeiser@bluewin.ch>
 * @copyright  2015 timetable
 * @license    MIT
 */

namespace inc\datamapper;

use inc\model\User;

class UserMapper extends \lib\Mapper {
	/**
	 * Mapper singleton
	 *
	 * @var \inc\datamapper\UserMapper
	 */
	protected static $singleton = null;

	/**
	 * Returns a single user by his identifier
	 *
	 * @param int $id
	 * @param bool $ignoreSuperusers (optional) 
	 * @throws \UnexpectedValueException
	 * @return \inc\model\User
	 */
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
			throw new \UnexpectedValueException('No user with this ID found');
		} else {
			$data = $result->fetch_assoc();
			return User::fillFromRowData($data);
		}
	}

	/**
	 * Returns a single user by his username
	 *
	 * @param string $username
	 * @throws \UnexpectedValueException
	 * @return \inc\model\User
	 */
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
			throw new \UnexpectedValueException('No user with this username found');
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
	 */
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
	 * @param \inc\model\User $user
	 * @return void
	 */
	public function save(\inc\model\User $user) {
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
	 * @return void
	 */
	public function delete($id) {
		$stmt = $this->db->prepare("DELETE FROM `user` WHERE `id` = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
}
