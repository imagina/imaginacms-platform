# imaginacms-iauctions

## Install
```bash
composer require imagina/iauctions-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Iauctions
```
## Seeder

```bash
php artisan module:seed Iauctions
```
## Short Description Module

### Auction - Types
	- INVERSE[0] (Default) = The module automatically chooses the winner
	- OPEN[1] = The winner is chosen manually

### Auction - Status
	- PENDING[0] (Default) = When the auction is created (it has not started yet)
	- ACTIVE[1] = When the auction starts
	- FINISHED[2] = When the auction ends

### Bid - Status
	- RECEIVED[0] (Default) = When a bid is created
	- DECLINED[1] = A bid may be declined by the administrator if necessary

### Category - Bid Service
	The categories can have a service for the calculation of points of the bid, if it does not have it, the amount of the bid sent will be taken

## Events with Notifications

### Auction Remaining Day (Job - CheckDaysToStartAuction)
	- Notification to: 
		- Responsible Auction (user_id) 
		- Providers (Users from same department)

### Auction Remaining Hour (To Finish) (Job - CheckHoursToFinishAuction)
	- Notification to: 
		- Responsible Auction (user_id) 
		- Providers (Users from same department)

### Auction Was Actived (Job - CheckStatusInitAuction)
	- Notification to: 
		- Responsible Auction (user_id) 
		- Providers (Users from same department)

### Auction Was Finished (Job - CheckStatusFinishAuction)
	- Notification to: 
		- Responsible Auction (user_id) 
		- Providers (Users from same department)

### Bid Was Created (Trait - Notificable)
	- Notification to: 
		- Responsible Auction (user_id)

### Winner Was Selected(Service - Auction Service)
	- Notification to: 
		- Responsible Auction (user_id)
		- Winner Bid (provider_id)
		- Emails from setting iauctions::formEmails
