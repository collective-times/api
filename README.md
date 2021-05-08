# collective times api [![CircleCI](https://circleci.com/gh/collective-times/api.svg?style=svg)](https://circleci.com/gh/collective-times/api)

## Docker開発環境

```sh
# 環境変数ファイルを配置
$ cp .env.development .env

# 開発環境を立ち上げる
$ docker-compose up -d

# マイグレーションを実行
$ docker-compose exec api php artisan migrate

# ローカルサーバーを起動
$ docker-compose exec api php artisan serve
```

`http://localhost` が閲覧できるようになります。

### Run PHPUnit

```sh
$ docker-compose exec api vendor/bin/phpunit
```

## セットアップ

```
# パスワードグラントクライアントの作成
$ docker-compose exec api php artisan passport:client --password
```

## 困ったときは

1. `storage/logs/laravel.log` でアプリケーションログを確認すること
