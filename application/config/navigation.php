<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @version SVN: $Id:$
 */

return array(
	'admin.partner_group.index' => array(
		'title' => 'Группы партнеров',
		'route' => 'admin-partner_group:index'
	),
	'admin.promo.edit' => array(
		'title' => 'Редактировать промо',
		'route' => 'admin-promo:edit'
	),
	'admin.partner_requisites_moderate.index' => array(
		'title' => 'Реквизиты на модерации',
		'route' => 'admin-partner_requisites_moderate:index'
	),
	'admin.partner_requisites_moderate.edit' => array(
		'title' => 'Редактировать реквизиты',
		'route' => 'admin-partner_requisites_moderate:edit',
		'parent' => 'admin.partner_requisites_moderate.index',
	),

	'admin.partner_requisites_edit.edit' => array(
		'model' => 'user',
		'title' => 'Редактировать реквизиты ${model.name}',
		'route' => 'admin-partner_requisites_edit:edit',
	),

	'admin.message_type.index' => array(
		'title' => 'Типы сообщений',
		'route' => 'admin-message_type:index'
	),
	'admin.message_type.edit' => array(
		'model' => 'message_type',
		'parent' => 'admin.message_type.index',
		'title' => 'Редактировать шаблон "${model.title}"',
		'route' => 'admin-message_type:edit?id=${model.id}',
		
	),
	'admin.ticket_branch.index' => array(
		'title' => 'Сообщения в поддержку',
		'route' => 'admin-ticket_branch:index'
	),
	'admin.ticket_branch.edit' => array(
		'title' => 'Ответить на сообщение',
		'route' => 'admin-ticket_branch:edit',
		'parent' => 'admin.ticket_branch.index',
	),
	'admin.ticket_branch.create' => array(
		'title' => 'Новая ветка',
		'route' => 'admin-ticket_branch:create',
		'parent' => 'admin.ticket_branch.index',
	),
	'admin.money_payout.index' => array(
		'title' => 'Выплаты',
		'route' => 'admin-money_payout:index'
	),
	'admin.money_payout.edit' => array(
		'title' => 'Редактировать выплату',
		'route' => 'admin-money_payout:edit',
		'parent' => 'admin.money_payout.index',
	),
	'admin.money_payment_client.index' => array(
		'title' => 'Клиентские платежи',
		'route' => 'admin-money_payment_client:index',
	),
	'admin.money_payment_client.create' => array(
		'title' => 'Добавить платеж',
		'route' => 'admin-money_payout:create',
		'parent' => 'admin.money_payment_client.index',
	),
	'admin.money_payment_partner.index' => array(
		'title' => 'Партнерские отчисления',
		'route' => 'admin-money_payment_partner:index',
	),
	'admin.client.index' => array(
		'title' => 'Клиенты',
		'route' => 'admin-client:index',
	),
	'admin.client.edit' => array(
		'title' => 'Редактировать клиента',
		'route' => 'admin-client:edit',
		'parent' => 'admin.client.index',
	),
	'admin.client.create' => array(
		'title' => 'Новый клиент',
		'route' => 'admin-client:create',
		'parent' => 'admin.client.index',
	),
	'admin.money_balance.index' => array(
		'title' => 'Балансы',
		'route' => 'admin-money_balance:index',
	),
	'admin.money_balance.edit' => array(
		'model' => 'user',
		'title' => 'Редактировать баланс партнера "${model.name}"',
		'route' => 'admin-money_balance:edit',
		'parent' => 'admin.money_balance.index',
	),
);