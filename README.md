# dumper
DB Backup : only tested with `MySQL` at the moment.

## Install

Via Composer

```bash
composer require sebastienfontaine/dumper
```

Publish config file

```bash
php artisan dumper:publish --name=backup-name
```

## Usage

Configure your backup by editing the config file. Test it by running

```bash
php artisan dumper:backup
```

If you want to use schedule functionality, be sure to configure your `cron` key in the config file. Then edit your Console/Kernel.php by adding 

```php
protected function schedule(Schedule $schedule)
{
    DumperScheduler::schedule($schedule);
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
