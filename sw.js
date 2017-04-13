/*
 *
 *  Push Notifications codelab
 *  Copyright 2015 Google Inc. All rights reserved.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License
 *
 */

/* eslint-env browser, serviceworker, es6 */

//'use strict';

/* eslint-disable max-len */

const applicationServerPublicKey = 'BH8-hIchXKMI6AKSee8gD0hhPThRqaEhIEtMJwcTjEQhiOKdG-_2tTIO-6hOAK4kwg5M9Saedjxp4hVE-khhWxY';
var nomeUSuario = "";

/* eslint-enable max-len */




function urlB64ToUint8Array(base64String) {
	const padding = '='.repeat((4 - base64String.length % 4) % 4);
	const base64 = (base64String + padding)
		.replace(/\-/g, '+')
		.replace(/_/g, '/');

	const rawData = window.atob(base64);
	const outputArray = new Uint8Array(rawData.length);

	for (let i = 0; i < rawData.length; ++i) {
		outputArray[i] = rawData.charCodeAt(i);
	}
	return outputArray;
}

self.addEventListener('install', function(event) {
	event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', function(event) {
	event.waitUntil(self.clients.claim());
});

self.addEventListener('push', function(event) {
	console.log('[Service Worker] Push Received.');
	console.log(`[Service Worker] Push had this data: "${event.data.text()}"`);

	var evento = event.data.text().split("|");
	console.log(evento[0]);
	var title = "";
	var mostra = 1;
	var options = {};

	if (evento[0] == "horaComer") {
		title = 'Hora de Comer!';

		var body = "";
		for (var i = 1; i < evento.length - 2; i += 2) //ultimo cont'em nome do usuario
		{
			if (evento[i] == '0') {
				body += "\u2753 ";
			}
			if (evento[i] == '1') {
				body += "\u2714 ";
			}
			if (evento[i] == '2') {
				body += "\u274C ";
			}
			body += evento[i + 1] + "\n";
		}
		options = {
			body: body,
			icon: 'images/icon.png',
			badge: 'images/badge.png',
			tag: 'boraComer',
			actions: [{
				action: 'vo',
				title: 'Vo'
			}, {
				action: 'numvo',
				title: 'Numvo'
			}]
		}
		self.nomeUsuario = evento[evento.length - 1];
	} else if (evento[0] == "novoUsuario") {
		title = 'Novo usuario no BoraCome!';
		options = {
			body: 'Ele se chama ' + evento[1],
			icon: 'images/icon.png',
			badge: 'images/badge.png'
		}
		self.nomeUsuario = evento[2];
	} else if (evento[0] == "fecha") {
		self.registration.getNotifications()
			.then(function(notifications) {
				if (notifications && notifications.length > 0) {
					// Start with one to account for the new notification
					// we are adding
					//var notificationCount = 1;
					for (var i = 0; i < notifications.length; i++) {
						var existingNotification = notifications[i];
						existingNotification.close();
					}
					notificationData.notificationCount = notificationCount;
				}
			});
		mostra = 0;
		
	} else {
		title = 'Outro Aviso!';
		options = {
			body: 'Notificacao desconhecida',
			icon: 'images/icon.png',
			badge: 'images/badge.png'
		}
	}
	if (mostra == 1)
		event.waitUntil(self.registration.showNotification(title, options));

});

self.addEventListener('notificationclick', function(event) {
	console.log('[Service Worker] Notification click Received.');

	if (!event.action) {
		// event.notification.close();
		console.log('meunome  =' + self.nomeUsuario);
		console.log('Notification Click.');
		// event.waitUntil(
		// 	clients.openWindow('https://developers.google.com/web/')
		// );
		// Was a normal notification click
		return;
	}

	switch (event.action) {
		case 'vo':
			console.log('Usuario Vai.');
			fetch(`./back/confirma.php?nome=${self.nomeUsuario}&vai=1`);
			break;
		case 'numvo':
			console.log('Usuario Numvai.');
			fetch(`./back/confirma.php?nome=${self.nomeUsuario}&vai=2`);
			break;
		default:
			console.log(`Unknown action clicked: '${event.action}'`);
			break;
	}

});

self.addEventListener('pushsubscriptionchange', function(event) {
	console.log('[Service Worker]: \'pushsubscriptionchange\' event fired.');
	const applicationServerKey = urlB64ToUint8Array(applicationServerPublicKey);
	event.waitUntil(
		self.registration.pushManager.subscribe({
			userVisibleOnly: true,
			applicationServerKey: applicationServerKey
		})
		.then(function(newSubscription) {
			// TODO: Send to application server

			console.log('[Service Worker] New subscription: ', newSubscription);
		})
	);
});