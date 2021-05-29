# URLTeamStatsTracker 

URLTeamStatsTracker is a PHP command line script for tracking hourly, daily and monthly user stats for ArchiveTeam's [URLTeam project](https://tracker.archiveteam.org:1338/).

## Scripts
* `track.php` - Track stats for one or move users.
* `view.php` - View tracked stats for one or move users.

### Parameters
Use `--user` to track a single user or `--users` track multiple users (separate each username with a comma).

Supported update types: `--hourly`, `--daily` and `--monthly`.

### Cron
For a single user:

```
0 0 * * * php track.php --user=VerifiedJoseph --daily
0 0 1 * * php track.php --user=VerifiedJoseph --monthly
```

For multiple users:

```
0 0 * * * php track.php --users=user1,user2 --daily
0 0 1 * * php track.php --users=user1,user2 --monthly
```


## Requirements

* PHP >= 7.4
* Composer
* PHP Extensions:
	* JSON [https://secure.php.net/manual/en/refs.xml.php](https://www.php.net/manual/en/book.json.php)
	* cURL [https://secure.php.net/manual/en/book.curl.php](https://secure.php.net/manual/en/book.curl.php)

## Dependencies
(Via [Composer](https://getcomposer.org/))

* `php-curl-class/php-curl-class` [https://github.com/php-curl-class/php-curl-class](https://github.com/php-curl-class/php-curl-class)
* `league/climate` [https://github.com/thephpleague/climate](https://github.com/thephpleague/climate)

