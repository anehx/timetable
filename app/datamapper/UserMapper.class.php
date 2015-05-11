<?php

require_once('/model/User.class.php');
require_once('datamapper/Mapper.class.php');

class UserMapper extends Mapper {
	/*
	 Returns a single user by his id

	 @param int $id
	 @returns model\User
	*/
	public function getUserByID($id) {
		$stmt = $this->db->prepare('
			SELECT * FROM `user`
			WHERE `user`.`id` = ?
			LIMIT 1
		');

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

	/*
	 Returns a single user by his username

	 @param string $username
	 @returns model\User
	*/
	public function getUserByUsername($username) {
		$stmt = $this->db->prepare("
			SELECT * FROM `user`
			WHERE `user`.`username` = ?
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

	/*
	 Returns an array of all available users

	 @returns array
	*/
	public function getUsers() {
		$stmt = $this->db->prepare("SELECT * FROM `user`");
		$stmt->execute();

		$result = $stmt->get_result();
		$users = array();

		if ($result->num_rows) {
			$data = $result->fetch_all(MYSQLI_ASSOC);

			foreach ($data as $row) {
				$users[] = User::fillFromRowData($row);
			}
		}

		return $users;
	}

	/*
	 Updates or creates an user
	*/
	public function save($user) {
		if (!$user->id) {
			$stmt = $this->db->prepare("
				INSERT INTO `user` (`username`, `first_name`, `last_name`, `password`, `is_superuser`) VALUES (
					?, ?, ?, ?, ?
				)
			");

			$stmt->bind_param(
				'ssssi',
				$user->username,
				$user->first_name,
				$user->last_name,
				$user->password,
				$user->is_superuser
			);
		}
		else {
			$stmt = $this->db->prepare("
				UPDATE `user` SET 
					`first_name`= ?,
					`last_name` = ?,
					`password` = ?,
					`is_superuser` = ?
				WHERE `user`.`id` = ?
				");

			$stmt->bind_param(
				'sssii',
				$user->first_name,
				$user->last_name,
				$user->password,
				$user->is_superuser,
				$user->id
			);
		}

		$stmt->execute();

		if (!$user->id) {
			$user->id = $this->db->insert_id;
		}
	}

	/*
	 Deletes an user
	*/
	public function delete($id) {
		$stmt = $this->db->prepare("DELETE FROM `user` WHERE `user`.`id` = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
	}
}