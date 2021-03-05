<?php

declare(strict_types=1);

/**
 * @copyright Copyright (c) 2021 Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @author Roeland Jago Douma <roeland@famdouma.nl>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OC\Authentication\Listeners;

use OCP\Authentication\TwoFactorAuth\IProvider;
use OCP\Authentication\TwoFactorAuth\TwoFactorProviderForUserEnabled;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TwoFactorProviderForUserDisabledLegacyListener implements IEventListener {
	/** @var EventDispatcherInterface */
	private $eventDispatcher;

	public function __construct(EventDispatcherInterface $eventDispatcher) {
		$this->eventDispatcher = $eventDispatcher;
	}

	public function handle(Event $event): void {
		if (!($event instanceof TwoFactorProviderForUserEnabled)) {
			return;
		}

		$dispatchEvent = new GenericEvent($event->getUser(), ['provider' => $event->getProvider()->getDisplayName()]);
		$this->eventDispatcher->dispatch(IProvider::EVENT_FAILED, $dispatchEvent);
	}
}
