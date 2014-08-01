<?php
/**
 * Licensed under The GPL-3.0 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @since	 2.0.0
 * @author	 Christopher Castro <chris@quickapps.es>
 * @link	 http://www.quickappscms.org
 * @license	 http://opensource.org/licenses/gpl-3.0.html GPL-3.0 License
 */
namespace Comment\Model\Entity;

use Cake\ORM\Entity;
use User\Model\Entity\User;

/**
 * Represents a single "comment" from "comments" database table.
 *
 */
class Comment extends Entity {

/**
 * Returns comment's author as a mock user entity. With the properties below:
 *
 * - `username`: QuickAppsCMS's `username` (the one used for login) if 
 * comment's author was a logged in user. NULL otherwise
 * - `name`: Real name of the author. `Anonymous` if not provided.
 * - `web`: Author's website (if provided).
 * - `email`: Author's email (if provided).
 *
 * @return \User\Model\Entity\User
 */
	public function _getAuthor() {
		$author = [
			'username' => null,
			'name' => $this->get('author_name'),
			'web' => $this->get('author_web'),
			'email' => $this->get('author_email')
		];

		if ($this->has('user')) {
			$user = $this->get('user');

			if ($user->id) {
				$author['username'] = $user->username;
				$author['name'] = $user->name;
				$author['email'] = $user->email;
			}
		}

		$author['name'] = empty($author['name']) ? __d('comment', 'Anonymous') : $author['name'];

		return new User($author);
	}
}
